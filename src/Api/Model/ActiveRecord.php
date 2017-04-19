<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/19/2017
 * Time: 12:32 PM
 */

namespace Course\Api\Model;


use Course\Api\Exceptions\Precondition;

abstract class ActiveRecord
{
    const CONFIG_TABLE_NAME = 'tableName';
    const CONFIG_DB_COLUMNS = 'dbColumns';
    const CONFIG_PRIMARY_KEYS = 'primaryKeys';

    private $data = [];

    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        Precondition::isTrue(isset($this->data[$name]), 'field ' . $name . ' does not exist');
        return $this->data[$name];
    }

    protected abstract static function getConfig(): array;

    public static function getTableName()
    {
        return static::getConfig()[self::CONFIG_TABLE_NAME];
    }
}