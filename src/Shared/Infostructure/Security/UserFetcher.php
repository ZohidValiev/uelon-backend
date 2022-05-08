<?php
namespace App\Shared\Infostructure\Security;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use Exception;
use Symfony\Component\Security\Core\Security;

class UserFetcher implements UserFetcherInterface
{
    public function __construct(private readonly Security $security)
    {}

    public function getAuthUser(): AuthUserInterface
    {
        $user = $this->security->getUser();

        if ($user === null) {
            throw new Exception("User is not logged in");
        }

        if (!$user instanceof AuthUserInterface) {
            throw new Exception(sprintf("User must implement %s interface", [AuthUserInterface::class]));
        }

        return $user;
    }
        
}