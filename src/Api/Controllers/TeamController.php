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
use Course\Api\Model\UserModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Request;
use Course\Services\Http\Response;
use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Services\Utils\StringUtils;

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
        $name = $request->name;

        if (strlen($request->name) < 4) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'team name length should be 4 or greater'
            );
        }

        try {
            $userModel = UserModel::loadUserFromSession();
        } catch (NoResultsException $e) {
            Response::showErrorResponse(
                ErrorCodes::USER_NOT_LOGGED_ID,
                'user is not logged in'
            );
        }

        $teamModel = TeamsModel::create($name, $userModel->id);

        Response::showSuccessResponse('team created', ['teamId' => $teamModel->id]);
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