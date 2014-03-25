<?php
/*
 * This file is part of Graze\Sort
 *
 * Copyright (c) 2014 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/sort/blob/master/LICENSE
 * @link http://github.com/graze/sort
 */
namespace Graze\Sort;

use UnexpectedValueException;

class Store
{
    /**
     * @var callable
     */
    protected $callable;

    protected $booleans = [];
    protected $doubles  = [];
    protected $integers = [];
    protected $objects  = [];
    protected $strings  = [];

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param mixed $val
     * @return mixed
     */
    public function getValue($val)
    {
        return $this->isStored($val) ? $this->getStoredValue($val) : $this->calculateValue($val);
    }

    /**
     * @param mixed $val
     * @return $val
     */
    protected function calculateValue($val)
    {
        $calculated = call_user_func($this->callable, $val);

        $type = gettype($val);
        $key  = $this->generateKey($val);

        return $this->{$type . 's'}[$key] = $calculated;
    }

    /**
     * @param $val
     * @return mixed
     */
    protected function generateKey($val)
    {
        if (is_object($val)) {
            return spl_object_hash($val);
        } elseif (is_bool($val)) {
            return (integer) $val;
        }

        return $val;
    }

    /**
     * @param mixed $val
     * @return mixed
     */
    protected function getStoredValue($val)
    {
        $type = gettype($val);
        $key  = $this->generateKey($val);

        return $this->isStored($val, $key) ? $this->{$type . 's'}[$key] : null;
    }

    /**
     * @param mixed $val
     * @return boolean
     */
    protected function isStored($val, $key = null)
    {
        $type = gettype($val);
        $key  = null !== $key ? $key : $this->generateKey($val);

        if (in_array($type, ['array', 'resource', 'unknown type'])) {
            throw new UnexpectedValueException('Unsupported type "' . $type . '"');
        }

        return isset($this->{$type . 's'}[$key]);
    }
}
