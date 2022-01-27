<?php
namespace App\Context\Common\Application\Event;


class UserEvents
{
    public const EVENT_USER_CREATE      = 'user.create';
    public const EVENT_USER_CREATED     = 'user.created';
    public const EVENT_SIGNUP_STARTED   = 'user.signup.started';
    public const EVENT_SIGNUPED         = 'user.signuped';
    public const EVENT_SIGNUP_COMPLETED = 'user.signup.completed';
}