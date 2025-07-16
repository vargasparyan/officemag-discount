<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private const FIXTURE_USER_FIRST_NAMES = [
        'Серёга',
        'Паша',
        'Игорь',
    ];

    private const FIXTURE_USER_LAST_NAMES = [
        'Кочарян',
        'Зубарев',
        'Кочеров',
    ];

    private const FIXTURE_USER_PATRONYMIC = [
        'Сергеевич',
        'Павлович',
        'Игоревич',
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; ++$i) {
            $user = new User();
            $user->setFirstName(self::FIXTURE_USER_FIRST_NAMES[$i]);
            $user->setLastName(self::FIXTURE_USER_LAST_NAMES[$i]);
            $user->setPatronymic(self::FIXTURE_USER_PATRONYMIC[$i]);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
