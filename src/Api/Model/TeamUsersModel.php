<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 04-04-2017
 * Time: 13:29
 */

namespace Course\Api\Model;

use Course\Services\Persistence\MySql;
use Course\Api\Exceptions\Precondition;

class TeamUsersModel extends ActiveRecord
{
    
    const STATUS_READY = 'R';
    const STATUS_NOT_READY = 'N';
    
    const STATUS = [
        self::STATUS_READY,
        self::STATUS_NOT_READY
    ];
    
    private static $config = [
        self::CONFIG_TABLE_NAME => 'team_users',
        self::CONFIG_PRIMARY_KEYS => ['id'],
        self::CONFIG_DB_COLUMNS => ['id', 'team_id', 'user_id', 'hunt_id', 'status'],
    ];

    /** @var TeamsModel */
    protected $teamModel;
    /** @var UserModel */
    protected $userModel;

    /**
     * @return array
     */

    protected  static function getConfig(): array
    {
        return self::$config;
    }

    /**
     * @param int $huntId
     *
     * @return TeamUsersModel[]
     */

    public static function loadByHuntId(int $huntId): array
    {
        $results = MySql::getMany(self::getTableName(), ['hunt_id' => $huntId]);
        $models = [];

        foreach ($results as $result) {
            $models[] = new static($result);
        }

        return $models;
    }

    /**
     * @param int $teamId
     *
     * @return TeamUsersModel[]
     */

    public static function loadByTeamId(int $teamId): array
    {
        $results = MySql::getMany(self::getTableName(), ['team_id' => $teamId]);
        $models  = [];

        foreach ($results as $result) {
            $models[] = new static($result);
        }
        return $models;
    }


    /**
     * @return TeamsModel
     */
    public function getTeamModel()
    {
        if(is_null($this->teamModel)) {
            $this->teamModel = TeamsModel::getById($this->team_id);
        }

        return $this->teamModel;
    }

    /**
     * @return UserModel
     */
    public function getUserModel(): UserModel
    {
        if(is_null($this->userModel)) {
            $this->userModel = UserModel::loadById($this->user_id);
        }

        return $this->userModel;
    }

    public static function insert(int $teamId, int $userId, int $huntId, $status)
    {
        Precondition::isTrue(in_array($status, self::STATUS), 'The status is not valid');
        
        if(!isset($status)) {
            $status = self::STATE_NOT_READY;
        }
        
        $results = MySql::insert(
                self::getTableName(), 
                [
                    'team_id' => $teamId, 
                    'user_id' => $userId, 
                    'hunt_id' => $huntId, 
                    'status' => $status
                ]);

        return $results;
    }
    
    public static function updateTeamStatus(int $teamId, string $status)
    {
        Precondition::isTrue(in_array($status, self::STATUS), 'The status is not valid');
        
        $where = ['team_id' => $teamId];
        $columnName = 'status';
        
        MySql::update(self::getTableName(), $columnName, $status, $where);
    }
}