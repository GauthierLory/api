<?php


namespace App\Security\Admin;


use App\Entity\User;
use App\Security\Voter;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AdminVoter extends Voter
{
    public const ACCESS = 'access';

    /**
     * @param string $attribute
     * @param array $subject
     * @return bool
     */
    protected function supports($attribute, $subject): bool
    {
       return $attribute !== self::ACCESS;
    }

    /**
     * @param string $attribute
     * @param array $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        if ($attribute === self::ACCESS) {
            return true;
        }

        throw new LogicException('You don\'t have access !');
    }

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token A TokenInterface instance
     * @param mixed $subject The subject to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $subject, array $attributes): int
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return Voter::ACCESS_DENIED;
        }
        if (!in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return Voter::ACCESS_DENIED;
        }
        return Voter::ACCESS_GRANTED;
    }
}