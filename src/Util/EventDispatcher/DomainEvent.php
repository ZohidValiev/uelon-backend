<?php
namespace App\Util\EventDispatcher;


class DomainEvent
{
    /**
     * Event name
     */
    protected string $name;

    /**
     * The event target
     */
    protected $target;

    public function __construct(string $name, $target = null)
    {
        $this->name = $name;
        $this->target = $target;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTarget()
    {
        return $this->target;
    }
}