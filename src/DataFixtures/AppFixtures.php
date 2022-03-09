<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadAccounts($manager);
    }

    public function loadAccounts(ObjectManager $manager): void
    {
        $accounts = [
            [
                'email' => 'c_croizat@hetic.eu',
                'company' => 'Hetic',
                'countries' => ['fr', 'en', 'es'],
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
            ]
        ];
        foreach ($accounts as $data) {
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
