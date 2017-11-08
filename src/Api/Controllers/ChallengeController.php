<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 22-10-17
 * Time: 02:01
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\ChallengeModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Request;
use Course\Services\Http\Response;

class ChallengeController implements Controller
{

    public function get()
    {
        {
            throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
        }
    }

    public function create()
    {
        $request = Request::getJsonBody();

        try {
            Precondition::isNotEmpty($request->name, 'name');
            Precondition::isNotEmpty($request->metadata, 'metadata');
            Precondition::isNotEmpty($request->type, 'type');
        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::MISSING_PARAMETER, 'parameter is missing');
        }

        if (!is_integer($request->type)) {
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, 'type parameter should be of integer type');
        }

        $challenge = ChallengeModel::insert($request->name, $request->metadata, $request->type);

        Response::showSuccessResponse('challenge created successfully', ['challenge_id' => $challenge]);
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