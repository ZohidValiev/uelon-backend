<?php
namespace App\Users\Infostructure\DataTransformer;


class UserOperations
{
    public const OPERATION_COLLECTION_GET = 'get';

    public const OPERATION_SIGNUP = "signup";
    public const OPERATION_ACTIVATE = "activate";
    public const OPERATION_CHANGE_ACTIVATION_TOKEN = "changeActivationToken";
    public const OPERATION_CREATE = "create";
    public const OPERATION_CHANGE_PASSWORD = "changePassword";
    public const OPERATION_UPDATE_NICKNAME = "updateNickname";
    public const OPERATION_UPDATE_STATUS = "updateStatus";
    public const OPERATION_UPDATE_ROLE = "updateRole";
    public const OPERATION_DELETE = "delete";

    
    /**
     * @return string[]
     */
    public static function getInputDataTransformerOperations(): array
    {
        return [
            self::OPERATION_SIGNUP,
            self::OPERATION_ACTIVATE,
            self::OPERATION_CHANGE_ACTIVATION_TOKEN,
            self::OPERATION_CREATE,
            self::OPERATION_CHANGE_PASSWORD,
            self::OPERATION_UPDATE_NICKNAME,
            self::OPERATION_UPDATE_STATUS,
            self::OPERATION_UPDATE_ROLE,
        ];
    }
    
    /**
     * @return string[]
     */
    public static function getOutputDataTransformerOperations(): array
    {
        return [
            self::OPERATION_SIGNUP,
            self::OPERATION_ACTIVATE,
            self::OPERATION_CHANGE_ACTIVATION_TOKEN,
            self::OPERATION_CREATE,
            self::OPERATION_CHANGE_PASSWORD,
            self::OPERATION_UPDATE_NICKNAME,
            self::OPERATION_UPDATE_STATUS,
            self::OPERATION_UPDATE_ROLE,
        ];
    }
}