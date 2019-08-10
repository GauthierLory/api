<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class Voter implements VoterInterface
{
    /**
     * @param string $attribute
     * @param array $subject
     * @return bool
     */
    abstract protected function supports($attribute, $subject): bool;

    /**
     * @param string $attribute
     * @param array $subject
     * @param TokenInterface $token
     * @return bool
     */
    abstract protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool;
}