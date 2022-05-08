<?php
namespace App\Shared\Application\Dto;


interface InputDtoInterface
{
    public function createCommand(): mixed;
}