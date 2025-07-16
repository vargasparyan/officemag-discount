<?php

namespace App\Service;

use App\Entity\Discount;
use App\Entity\User;
use App\Factory\DiscountFactory;
use App\Formatter\UserDiscountDataFormatter;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;


readonly class UserDiscountService
{
    public function __construct(private EntityManagerInterface $em, private DiscountFactory $discountFactory)
    {
    }

    public function getUserDiscountGeneratedData(int $userId): array
    {
        $discount =  $this->em->getRepository(Discount::class)->findOneBy([
            'user' => $userId,
        ], ['id' => 'DESC']);

        if ($discount && $discount->getCreatedAt() >= new DateTimeImmutable('-1 hour') ) {
            return UserDiscountDataFormatter::transform(
                $userId,
                UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_WARNING,
                'В течении часа скидка остается прежней',
                $discount
            );
        }

        $message = 'Скидка успешно сгенерирована!';

        if ($discount && $discount->getCreatedAt() >= new DateTimeImmutable('-3 hour') ) {
            $message = 'Мы обновили Вам скидку и теперь у вас новая скидака!';
        }

        $user     =  $this->em->getRepository(User::class)->find($userId);
        $discount = $this->discountFactory->createDiscount($user);

        $this->em->persist($discount);
        $this->em->flush();

        return UserDiscountDataFormatter::transform(
            $userId,
            UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_SUCCESS,
            $message,
            $discount,
        );
    }

    public function getUserDiscountCodeCheckingData(int $userId, ?string $code): array
    {
        $message  = 'Введите код скидки, чтобы мы могли ее проверить';
        $status   = UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_WARNING;
        $discount =  null;

        if (null !== $code) {
            $discount =  $this->em->getRepository(Discount::class)->findOneBy([
                'code' => $code,
            ], ['id' => 'DESC']);

            if (null === $discount) {
                $message = 'Вам следует сначало сгенерировать скидку';
                $status  = UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_WARNING;
            } elseif ($discount->getCreatedAt() < new DateTimeImmutable('-3 hour')) {
                $message = 'Скидка недоступна';
                $status  = UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_FAILED;
            } elseif ($discount->getUser()->getId() !== $userId) {
                $message = 'Скидка недоступна';
                $status  = UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_FAILED;
            } elseif ($discount->getUser()->getLastDiscount()->getCode() !== $discount->getCode()) {
                $message = 'Скидка устарела';
                $status  = UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_FAILED;
            } else {
                $message = 'Спешите восспользоваться Вашей скидкой!';
                $status  = UserDiscountDataFormatter::DISCOUNT_GENERATION_STATUS_SUCCESS;
            }
        }

        return UserDiscountDataFormatter::transform(
            $userId,
            $status,
            $message,
            $discount,
        );
    }
}
