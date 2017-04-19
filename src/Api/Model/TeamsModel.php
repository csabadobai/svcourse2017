<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/27/2017
 * Time: 8:27 AM
 */

namespace Course\Api\Model;


use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Services\Persistence\MySql;

class TeamsModel extends ActiveRecord
{
    protected static function getConfig(): array
    {
        return [
            self::CONFIG_TABLE_NAME => 'teams',
            self::CONFIG_DB_COLUMNS => ['id', 'name', 'owner_id'],
            self::CONFIG_PRIMARY_KEYS => ['id'],
        ];
    }

    public static function create(string $name, int $ownerId): self
    {
        $teamId = MySql::insert(
            self::getTableName(),
            ['name' => $name, 'owner_id' => $ownerId]
        );

        return self::loadById($teamId);
    }

    /**
     * @param int $id
     *
     * @return TeamsModel
     * @throws NoResultsException
     */

    public static function loadById(int $id): self
    {
        $result = MySql::getOne(self::getTableName(), ['id' => $id]);

        return new self($result);
    }

    /**
     * @param int $id
     * @return static
     */
    public static function getById(int $id) {

        $result = MySql::getOne(self::getTableName(), ['id' => $id]);

        return new static($result);

    }
}