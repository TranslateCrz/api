<?php

namespace App\View;

use App\Entity\Account;

class AccountPresenter
{
    public function presentAccount(Account $account): AccountView
    {
        $view = new AccountView();
        $view->id = $account->getUuid();
        $view->email = $account->getEmail();
        $view->role = $account->getRoles();
        $view->company = $account->getCompany();
        $view->countries = $account->getCountries();
        $view->createdAt = $account->getCreatedAt()->format('c');

        return $view;
    }

    /**
     * @param iterable|Account[] $accounts
     * @return array|AccountView[]
     */
    public function presentAccounts(iterable $accounts): array
    {
        $view = [];
        foreach ($accounts as $account) {
            $view[] = $this->presentAccount($account);
        }

        return $view;
    }
}