<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 23-04-17
 * Time: 14:13
 */

namespace Course\Api\Controllers;

use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\TeamUsersModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Response;
use Course\Services\Http\Request;
use Course\Api\Model\UserModel;
use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Services\Persistence\Exceptions\QueryException;

class TeamJoinController
{
    // Handler for HTTP get methods
    public function get()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    // Handler for HTTP POST methods
    public function create()
    {
        $request = Request::getJsonBody();

        try {
            $userModel = UserModel::loadUserFromSession();
        } catch (NoResultsException $e) {
            Response::showErrorResponse(ErrorCodes::USER_NOT_LOGGED_ID, 'user is not logged in');
        }

        $userId = $userModel->id;

        try {
            Precondition::isNotEmpty($request->teamId, 'teamId');
            Precondition::isNotEmpty($request->huntId, 'huntId');
        } catch (PreconditionException $e) {
            Response::showErrorResponse($e->getCode(), $e->getMessage());
        }

        try {
            TeamUsersModel::insert($request->teamId, $userId, $request->huntId);
        } catch (QueryException $e) {
            Response::showErrorResponse(ErrorCodes::ALREADY_MEMBER, 'user already a member of the team');
        }

        Response::showSuccessResponse('team joined');
    }

    // Handler for HTTP PUT methods
    public function update()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    // Handler for HTTP DELETE methods
    public function delete()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }
}