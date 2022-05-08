<?php
namespace App\Categories\Infostructure\DataTransformer;


class CategoryOperations
{
    public const OPERATION_CREATE = 'create';
    public const OPERATION_UPDATE = 'update';
    public const OPERATION_CHANGE_POSITION = 'changePosition';

    /**
     * @return string[]
     */
    public static function getInputDataTransformerOperations(): array
    {
        return [
            self::OPERATION_CREATE,
            self::OPERATION_UPDATE,
            self::OPERATION_CHANGE_POSITION,
        ];
    }
    
    /**
     * @return string[]
     */
    public static function getOutputDataTransformerOperations(): array
    {
        return [
            self::OPERATION_CREATE,
            self::OPERATION_UPDATE,
            self::OPERATION_CHANGE_POSITION,
        ];
    }
}