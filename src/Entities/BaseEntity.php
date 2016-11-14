<?php

namespace Entities;
use Spot\Entity;

/**
 * Workaround for Spot2 magic
 *
 * @package Entities
 */
abstract class BaseEntity extends Entity
{
    /**
     * @throws \Exception
     * @return array
     */
    public static function fields()
    {
        throw new \Exception('Implement me');
    }

    /**
     * @throws \Exception
     */
    public function update()
    {
        foreach (array_keys($this->fields()) as $fieldName) {
            $this->_dataModified[$fieldName] = $this->_data[$fieldName] = $this->$fieldName;
        }
    }
}