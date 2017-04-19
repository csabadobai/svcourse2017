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

class UserController implements Controller
{
    public function get()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    public function create()
    {
        $body = Request::getJsonBody();

        try {
            Precondition::lengthIsBetween($body->username, 4, 20, 'username');
            Precondition::lengthIsBetween($body->password, 6, 20, 'password');
        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, $e->getMessage());
        }

        if (UserModel::usernameExists($body->username)) {
            Response::showErrorResponse(ErrorCodes::USER_CREATE_USERNAME_ALREADY_TAKEN, 'username already taken');
        }

        $password = StringUtils::encryptPassword($body->password);
        $userModel = UserModel::create($body->username, $password);

        Response::showSuccessResponse('user created', ['userId' => $userModel->id]);
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