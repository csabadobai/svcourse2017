<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 04-04-2017
 * Time: 12:50
 */

namespace Course\Api\Controllers;

use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\Response;
use Course\Api\Model\TeamUsersModel;

class HuntTeamsController implements Controller
{
    public function get()
    {
        try {
            Precondition::isTrue(array_key_exists('huntId', $_GET), 'The parameter "huntId" is not set');
            Precondition::isTrue($_GET['huntId'] > 0, 'The parameter "huntId" is invalid');
        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, $e->getMessage());
        }
        $huntId = $_GET['huntId'];
        $teams = [];

        foreach (TeamUsersModel::loadByHuntId($huntId) as $teamUsersModel) {
            $teams[] = [
                'id' => $teamUsersModel->team_id,
                'name' => $teamUsersModel->getTeamModel()->name
            ];
        }

        Response::showSuccessResponse('joined teams retrieved', ['teams' => $teams]);
    }
    public function create()
    {
        {
            throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
        }
    }
    public function update()
    {
        {
            throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
        }
    }
    public function delete()
    {
        {
            throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
        }
    }
}