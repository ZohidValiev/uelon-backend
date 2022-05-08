<?php
namespace App\Shared\Application\Query;


interface QueryBusInterface
{
    public function handle(QueryInterface $query): mixed;
}