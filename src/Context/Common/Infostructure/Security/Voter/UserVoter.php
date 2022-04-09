<?php
namespace App\Context\Common\Infostructure\Security\Voter;

use App\Context\Common\Domain\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class UserVoter extends Voter
{
    private const PUBLIC_ACCESS = "PUBLIC_ACCESS";
    private const USER_COLLECTION_GET = "USER_COLLECTION_GET";
    private const USER_SIGNUP = "USER_SIGNUP";
    private const USER_CREATE = "USER_CREATE";
    private const USER_GET = "USER_GET";
    private const USER_ACTIVATE = "USER_ACTIVATE";
    private const USER_CHANGE_ACTIVATION_TOKEN = "USER_CHANGE_ACTIVATION_TOKEN";
    private const USER_UPDATE_NICKNAME = "USER_UPDATE_NICKNAME";
    private const USER_UPDATE_STATUS = "USER_UPDATE_STATUS";
    private const USER_UPDATE_ROLE = "USER_UPDATE_ROLE";
    

    public function __construct(private Security $_security)
    {}

    protected function supports(string $attribute, $subject)
    {
        $supportsSubject = $subject instanceof User;
        $supportsAttribute = \in_array($attribute, [
            // self::USER_COLLECTION_GET,
            self::USER_SIGNUP,
            self::USER_CREATE,
            self::USER_GET,
            self::USER_ACTIVATE,
            self::USER_CHANGE_ACTIVATION_TOKEN,
            self::USER_UPDATE_NICKNAME,
            self::USER_UPDATE_STATUS,
            self::USER_UPDATE_ROLE,
        ]);

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param User $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /**
         * @var User $currentUser
         */
        $currentUser = $token->getUser();

        match ($attribute) {
            self::USER_CREATE ,
            self::USER_UPDATE_STATUS,
            self::USER_UPDATE_ROLE,
                => $this->_isGranted(User::ROLE_ADMIN),

            self::USER_SIGNUP,
            self::USER_ACTIVATE,
            self::USER_CHANGE_ACTIVATION_TOKEN,
                => $this->_isGranted(self::PUBLIC_ACCESS),

            self::USER_GET,
            self::USER_UPDATE_NICKNAME,
                => $this->_isGranted(User::ROLE_ADMIN) 
                || $this->_isGranted(User::ROLE_USER) && $subject->getId() === $currentUser->getId(),

            default => false,
        };
    }

    private function _isGranted($attributes, $subject = null): bool
    {
        return $this->_security->isGranted($attributes, $subject);
    }
}