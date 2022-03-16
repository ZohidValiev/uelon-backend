<?php
namespace App\Context\Category\Infostructure\Dto;

use App\Context\Category\Infostructure\Constraint\CategoryPosition;

class CategoryChangePositionDto 
{
    /**
     * Category new position
     */
    #[CategoryPosition()]
    public $position;
}