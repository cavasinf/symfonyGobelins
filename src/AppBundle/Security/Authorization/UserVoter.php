<?php

namespace AppBundle\Security\Authorization;

use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

Class UserVoter extends Voter
{

    const CST_ROLE_ADMIN = "ROLE_ADMIN";

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    public function supports($attribute, $subject)
    {
        if ($attribute == self::CST_ROLE_ADMIN)
            return true;
        else
            return false;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    public function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof User)
            return false;

        if (self::CST_ROLE_ADMIN === $attribute && in_array(self::CST_ROLE_ADMIN,$user->getRoles()))
            return true;
        else
            return false;
    }
}