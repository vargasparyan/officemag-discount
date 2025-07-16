<?php

namespace App\Formatter;

use App\Entity\Discount;

class UserDiscountDataFormatter
{
    public const DISCOUNT_GENERATION_STATUS_SUCCESS = 'success';
    public const DISCOUNT_GENERATION_STATUS_WARNING = 'warning';
    public const DISCOUNT_GENERATION_STATUS_FAILED  = 'failed';

    public static function transform(int $userId, string $status, string $message, ?Discount $discount): array
    {
        return [
            'userId'                     => $userId,
            'amount'                     => $discount?->getAmount(),
            'code'                       => $discount?->getCode(),
            'discount_generation_status' => $status,
            'message'                    => $message,
        ];
    }
}
