<?php
namespace App\Categories\Application\Command\ChangePosition;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        /**
         * @var int A category entity id
         */
        public readonly int $id, 
        /**
         * @var int A category entity position
         */
        public readonly int $position,
    )
    {}
}