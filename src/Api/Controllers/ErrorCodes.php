<?php
/**
 * Created by PhpStorm.
 * User: alexandru.cicioc
 * Date: 3/15/2017
 * Time: 1:40 PM
 */

namespace Course\Api\Controllers;


class ErrorCodes
{
    const GENERIC_ERROR = 1;
    const INVALID_PARAMETER = 2;
    const BAD_REQUEST = 3;
    const INVALID_AUTH_TOKEN = 4;
    const MISSING_PARAMETER = 5;

    const USER_CREATE_USERNAME_ALREADY_TAKEN = 100;

    const USER_LOGIN_USERNAME_DOES_NOT_EXIST = 200;
    const USER_LOGIN_INCORRECT_PASSWORD = 201;

    const USER_NOT_LOGGED_ID = 401;
}
