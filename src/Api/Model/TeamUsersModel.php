<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 04-04-2017
 * Time: 13:29
 */

namespace Course\Api\Model;

use Course\Services\Persistence\MySql;

class TeamUsersModel extends ActiveRecord
{
    private static $config = [
        self::CONFIG_TABLE_NAME => 'hunt_team_users',
        self::CONFIG_PRIMARY_KEYS => ['id'],
        self::CONFIG_DB_COLUMNS => ['id', 'team_id', 'user_id', 'hunt_id'],
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
}