<?php
namespace App\Context\Common\Infostructure\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

final class SigninOutputDto 
{
    #[Groups(["u:read"])]
    public int $id;

    #[Groups(["u:read"])]
    public string $username;

    #[Groups(["u:read"])]
    public string $nickname;
}