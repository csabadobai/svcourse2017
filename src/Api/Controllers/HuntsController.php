<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 17-10-17
 * Time: 21:22
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\HuntModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Response;

class HuntsController implements Controller
{

    public function get()
    {
        $hunts = [];

        if (array_key_exists('status', $_GET)) {
            $status = $_GET['status'];
        } else {
            $status = null;
        }

        $statuses = HuntModel::STATES;
        $states = ['A' => "active", 'S' => "started", 'C' => "completed"];

        if ($status == null) {
            foreach (HuntModel::loadAll() as $hunt) {
                $hunts[] = [
                    'id' => $hunt->id,
                    'name' => $hunt->name,
                    'state' => $hunt->state
                ];
            }
            $message = 'all hunts retrieved';
        } else {
            try {
                Precondition::isTrue(in_array($status, $statuses), 'no such status');
            } catch (PreconditionException $e) {
                Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, $e->getMessage());
            }
            foreach (HuntModel::loadByState($status) as $hunt) {
                $hunts[] = [
                    'id' => $hunt->id,
                    'name' => $hunt->name
                ];
                foreach ($states as $key => $value) {
                    if ($status == $key) {
                        $message = 'all ' . $value;
                    }
                }
            }
            $message .= ' hunts retrieved.';
        }

        Response::showSuccessResponse($message, ['hunts' => $hunts]);
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