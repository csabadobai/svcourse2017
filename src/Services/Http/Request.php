<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 4:35 PM
 */

namespace Course\Services\Http;


use Course\Api\Controllers\ErrorCodes;
use Course\Api\Model\UserModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Utils\StringUtils;
use Course\Services\Utils\Exceptions\DecryptException;

class Request
{
    public static function getJsonBody()
    {
        $rawBody = file_get_contents("php://input");
        return json_decode($rawBody);
    }

    /**
     * @param string $key
     * @return string
     * @throws HttpException
     */
    public static function getHeader(string $key): string
    {
        $headerKey = 'HTTP_' . strtoupper($key);

        if(!isset($_SERVER[$headerKey]))
        {
            throw new HttpException('Header with key ' . $key . ' is missing', ErrorCodes::BAD_REQUEST);
        }
    }

    /**
     * @return UserModel
     */
    public static function getAuthUser(): UserModel
    {
        try {
            $authToken = self::getHeader('AuthorizationToken');
            $userModel = StringUtils::decryptData($authToken);

            if(!($userModel instanceof UserModel))
            {
                Response::showErrorResponse(ErrorCodes::INVALID_AUTH_TOKEN, 'Invalid auth token');
            }

            return $userModel;
        } catch (DecryptException $e) {
            Response::showErrorResponse(ErrorCodes::INVALID_AUTH_TOKEN, 'Could not decrypt token');
        } catch (HttpException $e) {
            Response::showErrorResponse($e->getCode(), $e->getMessage());
        }
    }
}