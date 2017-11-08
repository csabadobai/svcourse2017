<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 22-10-17
 * Time: 03:09
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\ChallengeModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Response;

class ChallengesController implements Controller
{

    public function get()
    {
        $linkParam = $_GET['name'] || $_GET['type'];

        try {
            Precondition::isNotEmpty($linkParam, 'name' || 'type');
        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::MISSING_PARAMETER, $linkParam . ' parameter is empty or missing');
        }

        $type = $_GET['type'];
        $name = $_GET['name'];
        $data = [];

        if (!is_null($type)) {
            if (!is_integer($type)) {
                Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, 'type parameter should be of integer type');
            } else {
                $data[] = ChallengeModel::loadByType($type);
            }
        } elseif (!is_null($name)) {
            $data[] = ChallengeModel::loadByName($name);
        }

        Response::showSuccessResponse('challenges retrieved successfully', $data);
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