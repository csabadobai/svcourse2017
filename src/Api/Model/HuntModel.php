<?php
/**
 * Created by PhpStorm.
 * User: csaba.dobai
 * Date: 04-04-2017
 * Time: 14:09
 */

namespace Course\Api\Model;

use Course\Api\Exceptions\Precondition;
use Course\Services\Persistence\MySql;

class HuntModel extends ActiveRecord
{

    // States definition
    const STATE_ACTIVE = 'A';
    const STATE_STARTED = 'S';
    const STATE_COMPLETED = 'C';

    // Available states
    const STATES = [
        self::STATE_ACTIVE,
        self::STATE_STARTED,
        self::STATE_COMPLETED,
    ];

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        return [
            self::CONFIG_TABLE_NAME => 'hunts',
            self::CONFIG_PRIMARY_KEYS => ['id'],
            self::CONFIG_DB_COLUMNS => ['id', 'name', 'state'],
        ];
    }

    /**
     * @param string $state
     *
     * @return HuntModel[]
     * @throws PreconditionException
     */
    public static function loadByState(string $state): array
    {
        Precondition::isTrue(in_array($state, self::STATES), 'The state is not valid');

        $huntModelList = [];
        $results = MySql::getMany(self::getTableName(), ['state' => $state]);

        foreach ($results as $result){
            $huntModelList[] = new static($result);
        }

        return $huntModelList;

    }
}