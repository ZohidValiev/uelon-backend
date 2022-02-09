<?php
namespace App\Context\Common\Application\Event;


class UserEvents
{
    public const EVENT_USER_CREATE = 'user.create';
    public const EVENT_USER_CREATED = 'user.created';
    public const EVENT_USER_SIGNUP = 'user.signup';
    public const EVENT_USER_SIGNUPED = 'user.signuped';
    public const EVENT_USER_CHANGED_ACTIVATION_TOKEN = 'user.changed-activation-token';
}