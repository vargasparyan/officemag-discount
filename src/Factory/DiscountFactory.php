<?php

namespace App\Factory;

use App\Entity\Discount;
use App\Entity\User;

class DiscountFactory
{
    public function createDiscount(User $user): Discount
    {
        $discount = new Discount();
        $discount->setCode(md5(uniqid(mt_rand(), true)));
        $discount->setAmount( random_int(1, 50) );
        $discount->setUser($user);
        $user->addDiscount($discount);

        return $discount;
    }
}
