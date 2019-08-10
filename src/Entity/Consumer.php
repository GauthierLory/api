<?php


namespace App\Entity;


class Consumer extends User
{
    /**
     * @return array
     */
    public function getRoles(): array
    {
        $this->roles[] = 'ROLE_CONSUMER';
        return parent::getRoles();
    }
}