<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Translation;
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
            'translations' => [
                [
                    'code' => 'home.title',
                    'country' => 'fr',
                    'value' => 'Le titre de la page d\'accueil',
                ],
                [
                    'code' => 'home.main.text',
                    'country' => 'fr',
                    'value' => 'Bla bla bla ...',
                ],
            ],
        ],
        [
            'email' => 'corentin.croizat@hetic.net',
            'company' => null,
            'countries' => ['fr', 'en', 'es'],
            'roles' => ['ROLE_USER'],
            'translations' => [],
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
            $this->loadTranslations($manager, $account, $data['translations']);
        }

        $manager->flush();
    }

    public function loadTranslations(ObjectManager $manager, Account $account, array $translations): void
    {
        foreach ($translations as $data) {
            $translation = new Translation($account, $data['code'], $data['country']);
            $translation->setValue($data['value']);
            $manager->persist($translation);
        }
    }
}
