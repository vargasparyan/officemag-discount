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

    private const FIXTURE_USER_EMAIL = [
        'kocharyan@gmail.com',
        'zubarev@gmail.com',
        'kocherov@gmail.com',
    ];

    private const FIXTURE_USER_PASSWORD = [
        '$2y$12$4Umg0rCJwMswRw/l.SwHHOMB2CVuLTzVsnmgvVaPhmJuUfO89LBQ6', //vadan.gasparyan
        '$2y$12$4Umg0rCJwMswRw/l.SwHHODpKtzZWodeKF3Vj6/Bde5ZFf7LrAM2G', //rasmuslerdorf
        '$2y$12$4Umg0rCJwMswRw/l.SwHvuQV01coP0eWmGzd61QH2RvAOMANUBGC.', //rasmuslerdorf
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; ++$i) {
            $user = new User();
            $user->setFirstName(self::FIXTURE_USER_FIRST_NAMES[$i]);
            $user->setLastName(self::FIXTURE_USER_LAST_NAMES[$i]);
            $user->setPatronymic(self::FIXTURE_USER_PATRONYMIC[$i]);
            $user->setEmail(self::FIXTURE_USER_EMAIL[$i]);
            $user->setPassword(self::FIXTURE_USER_PASSWORD[$i]);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
