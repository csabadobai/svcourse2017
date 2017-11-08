<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 21-10-17
 * Time: 16:36
 */

namespace Course\Api\Model;


use Course\Services\Persistence\MySql;

class ChallengeModel extends ActiveRecord
{

    private static $config = [
        self::CONFIG_TABLE_NAME => 'challenges',
        self::CONFIG_PRIMARY_KEYS => ['id'],
        self::CONFIG_DB_COLUMNS => ['id', 'name', 'metadata', 'type']
    ];

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        return self::$config;
    }

    /**
     * @param string $name
     * @param string $metadata
     * @param int $type
     * @return int
     */
    public static function insert(string $name, string $metadata, int $type)
    {
        $results = MySql::insert(
            self::getTableName(),
            $data[] = [
                'name' => $name,
                'metadata' => $metadata,
                'type' => $type
            ]
        );

        return $results;
    }

    /**
     * @param int $id
     * @return ChallengeModel
     */
    public static function loadById(int $id): ChallengeModel
    {
        $result = MySql::getOne(self::getTableName(), ['id' => $id]);
        return new self($result);
    }

    /**
     * @param string $name
     * @return array
     */
    public static function loadByName(string $name): array
    {
        $results = MySql::getMany(self::getTableName(), ['name' => $name]);
        $challenges = [];

        foreach ($results as $result) {
            $challenges[] = new static($result);
        }

        return $challenges;
    }

    /**
     * @param int $type
     * @return array
     */
    public static function loadByType(int $type): array {
        $results = MySql::getMany(self::getTableName(), ['type'=>$type]);
        $challenges = [];

        foreach ($results as $result ) {
            $challenges[] = new static($result);
        }

        return $challenges;
    }
}