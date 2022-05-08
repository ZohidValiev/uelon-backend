<?php
namespace App\Shared\Domain\Entity;


interface EntityIDInterface 
{
    public function getId(): ?int;
}