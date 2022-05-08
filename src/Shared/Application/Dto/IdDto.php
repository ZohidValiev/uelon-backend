<?php
namespace App\Shared\Application\Dto;


class IdDto
{
    public function __construct(
        /**
         * @var int
         */
        public readonly int $id
    )
    {}
}