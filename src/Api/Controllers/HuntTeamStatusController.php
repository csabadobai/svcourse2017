<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Course\Api\Controllers;

use Course\Services\Http\Request;
use Course\Services\Http\Response;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Api\Model\UserModel;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Exceptions\Precondition;
use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Api\Model\TeamsModel;
use Course\Api\Model\TeamUsersModel;

/**
 * Description of HuntTeamStatus
 *
 * @author csaba.dobai
 */
class HuntTeamStatusController implements Controller 
{
    
    public function get()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }
    
    public function create()
    {
        // get JSON request body
        $body = Request::getJsonBody();
        
        // validate the provided fields
        try {
            Precondition::isNotEmpty($body->teamId, 'teamId');
            Precondition::isNotEmpty($body->status, 'status');
            Precondition::isTrue(in_array($body->status, TeamUsersModel::STATUS), 'invalid status provided');
        } catch (PreconditionException $e) {
            Response::showErrorResponse($e->getCode(), $e->getMessage());
        }

        // get the current user
        try {
            $userModel = UserModel::loadUserFromSession();
        } catch (NoResultsException $e) {
            Response::showErrorResponse($e->getCode(), $e->getMessage());
        }
        
        // assign the team owner to a variable
        $teamModel = TeamsModel::getTeamOwner($body->teamId);
        
//        var_dump($teamModel);
//        die();
        
        $owner = $teamModel->owner_id;
        
        // verify that the current user is the owner of the team
        if($userModel->id !== $owner) 
        {
            Response::showErrorResponse(ErrorCodes::NOT_OWNER, 'user is not the owner of this team');
        }
        
//        $teamUsersModel = TeamUsersModel::loadByTeamId($body->teamId);
//        
//        var_dump($teamUsersModel);
//        die();
        
        TeamUsersModel::updateTeamStatus($body->teamId, $body->status);
                
        Response::showSuccessResponse('status updated successfully to ' . $body->status);
        
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
