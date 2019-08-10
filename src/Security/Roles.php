<?php


namespace App\Security;


abstract class Roles
{
    public const ADMIN = 'ROLE_ADMIN';
    public const LABEL_ADMIN = 'Admin';
    public const USER = 'ROLE_USER';
    public const LABEL_USER = 'Utilisateur';

    /** @var array  */
    public static $list = [
        self::LABEL_ADMIN => self::ADMIN,
        self::LABEL_USER => self::USER,
    ];
}