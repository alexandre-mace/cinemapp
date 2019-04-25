<?php

namespace App\Security;

use App\Entity\Booking;
use App\Entity\User;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BookingVoter extends Voter
{
    const SHOW = 'show';
    const EDIT = 'edit';
    const DELETE = 'delete';
    private $authChecker;

    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::SHOW, self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on Task objects inside this voter
        if (!$subject instanceof Booking) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $booking = $subject;

        switch ($attribute) {
            case self::SHOW:
            case self::EDIT:
            case self::DELETE:
                return $this->hasRight($booking, $user);
        }
        throw new LogicException('This code shouldn\'t be reached');
    }

    private function hasRight(Booking $booking, User $user)
    {
        if ($this->authChecker->isGranted('ROLE_ADMIN', $user)) {
            return true;
        }
        return $user === $booking->getUser();
    }
}