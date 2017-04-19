<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 4:07 PM
 */

namespace Course\Api\Controllers;

use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\UserModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Request;
use Course\Services\Http\Response;
use Course\Services\Utils\StringUtils;

class UserLoginController implements Controller
{
    public function get()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    public function create()
    {
        $body = Request::getJsonBody();

        try {
            Precondition::isNotEmpty($body->username, 'username');
            Precondition::isNotEmpty($body->password, 'password');
            Precondition::lengthIsBetween($body->username, 4, 20, 'username');
            Precondition::lengthIsBetween($body->password, 6, 20, 'password');
        } catch (PreconditionException $e) {
            Response::showErrorResponse($e->getCode(), $e->getMessage());
        }

        if (!UserModel::usernameExists($body->username)) {
            Response::showErrorResponse(ErrorCodes::USER_LOGIN_USERNAME_DOES_NOT_EXIST, 'username does not exist');
        }

        $password = StringUtils::encryptPassword($body->password);
        $userModel = UserModel::loadByUsername($body->username);

        if ($userModel->password != $password) {
            Response::showErrorResponse(ErrorCodes::USER_LOGIN_INCORRECT_PASSWORD, 'incorrect password');
        }

        session_start(['cookie_lifetime' => 86400]);
        $_SESSION['userId'] = $userModel->id;

        Response::showSuccessResponse('user authenticated', ['userId' => $userModel->id, 'authorizationToken' => StringUtils::encryptData($userModel)]);
    }

    public function update()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    public function delete()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }
}