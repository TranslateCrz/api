<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const ACCOUNTS = [
        [
            'email' => 'c_croizat@hetic.eu',
            'company' => 'Hetic',
            'countries' => ['fr', 'en', 'es'],
            'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
        ],
        [
            'email' => 'corentin.croizat@hetic.net',
            'company' => null,
            'countries' => ['fr', 'en', 'es'],
            'roles' => ['ROLE_USER'],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $this->loadAccounts($manager);
    }

    public function loadAccounts(ObjectManager $manager): void
    {
        foreach (self::ACCOUNTS as $data) {
            $account = new Account($data['email']);
            $account
                ->setCountries($data['countries'])
                ->setCompany($data['company'])
                ->setRoles($data['roles'])
            ;
            $manager->persist($account);
        }

        $manager->flush();
    }
}
