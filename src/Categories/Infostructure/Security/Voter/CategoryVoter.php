<?php
namespace App\Categories\Infostructure\Security\Voter;

use App\Categories\Domain\Entity\Category;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CategoryVoter extends Voter
{
    const CATEGORY_GET    = "CATEGORY_GET";
    const CATEGORY_CREATE = "CATEGORY_CREATE";
    const CATEGORY_UPDATE = "CATEGORY_UPDATE";
    const CATEGORY_DELETE = "CATEGORY_DELETE";
    const CATEGORY_CHANGE_POSITION = "CATEGORY_CHANGE_POSITION";

    public function __construct(private Security $security)
    {}

    protected function supports(string $attribute, $subject)
    {
        $supportsAttribute = in_array($attribute, [
            self::CATEGORY_GET,
            self::CATEGORY_CREATE,
            self::CATEGORY_UPDATE,
            self::CATEGORY_DELETE,
            self::CATEGORY_CHANGE_POSITION,
        ], true);

        $supportsSubject = $subject instanceof Category || $subject === null;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param Category $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        return match ($attribute) {
            self::CATEGORY_GET,
                => $this->_isGranted("ROLE_ADMIN") || $subject->isActive(),

            self::CATEGORY_CREATE,
            self::CATEGORY_UPDATE,
            self::CATEGORY_DELETE,
            self::CATEGORY_CHANGE_POSITION,
                => $this->_isGranted("ROLE_ADMIN"),

            default => false,
        };
    }

    private function _isGranted($attributes): bool
    {
        return $this->security->isGranted($attributes);
    }
}