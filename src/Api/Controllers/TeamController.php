<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/20/2017
 * Time: 6:31 PM
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\TeamsModel;
use Course\Api\Model\TeamUsersModel;
use Course\Api\Model\UserModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Request;
use Course\Services\Http\Response;
use Course\Services\Persistence\Exceptions\NoResultsException;

class TeamController implements Controller
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
            Precondition::isNotEmpty($request->huntId, 'huntId');
            Precondition::isNotEmpty($request->name, 'name');
            Precondition::lengthIsBetween($request->name, 4, 20, 'name');
        } catch (PreconditionException $e) {
            Response::showErrorResponse($e->getCode(), $e->getMessage());
        }

//        if (strlen($request->name) < 4)
//        {
//            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER,'team name length should be 4 or greater');
//        }

//        try {
//            $userModel = UserModel::loadUserFromSession();
//        } catch (NoResultsException $e) {
//            Response::showErrorResponse(ErrorCodes::USER_NOT_LOGGED_IN,'user is not logged in');
//        }

        $userModel = UserModel::loadUserFromSession();
        $userId = $userModel->id;

        if(!isset($userModel)) {
            throw new NoResultsException(ErrorCodes::USER_NOT_LOGGED_IN, ErrorCodes::USER_NOT_LOGGED_IN, 'user is not logged in');
        }

        $teamModel = TeamsModel::create($request->name, $userId);
        $teamId = $teamModel->id;

        if(empty($request->huntId)){
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, 'huntId parameter is null');
        }
        
        TeamUsersModel::insert($teamId, $userId, $request->huntId);

        Response::showSuccessResponse('team created', ['teamId' => $teamId]);
    }

    // Handler for HTTP PUT methods
    public function update()
    {
        throw new HttpException('Method Not Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    // Handler for HTTP DELETE methods
    public function delete()
    {
        throw new HttpException('Method Not Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }
}