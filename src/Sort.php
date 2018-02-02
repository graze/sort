<?php
/*
 * This file is part of Graze Sort
 *
 * Copyright (c) 2014 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/sort/blob/master/LICENSE
 * @link http://github.com/graze/sort
 */
namespace Graze;

use Closure;

class Sort
{
    /**
     * @const integer
     */
    const DESC = -1;
    const ASC  =  1;

    /**
     * Comparison sort
     *
     * This function applies a Comparison sorting function to an array of values.
     * Multiple `$fns` can be provided and on sort will be applied in order until
     * comparison values no longer match.
     *
     * @param array $arr
     * @param callable|callable[] $fn
     * @param int $order
     * @return array
     */
    public static function comparison(array $arr, $fn, $order = self::ASC)
    {
        usort($arr, self::comparisonFn($fn, $order));
        return $arr;
    }

    /**
     * Comparison function
     *
     * This returns a closure around a Comparison function for use within PHP's
     * `usort` functions when given a simple comparison function. Multiple `$fns`
     * can be provided and on sort will be applied in order until comparison values
     * no longer match.
     *
     * @link http://www.php.net/manual/en/function.usort.php
     * @link http://www.php.net/manual/en/function.uasort.php
     * @link http://www.php.net/manual/en/function.uksort.php
     *
     * @param callable|callable[] $fn
     * @param int $order
     * @return Closure
     */
    public static function comparisonFn($fn, $order = self::ASC)
    {
        $resA =  1 * $order;
        $resB = -1 * $order;
        $fn = self::getCallableList($fn);

        return function ($itemA, $itemB) use ($fn, $resA, $resB) {
            foreach ($fn as $_fn) {
                if ($_fn instanceof Closure) {
                    $a = $_fn($itemA);
                    $b = $_fn($itemB);
                } else {
                    $a = call_user_func($_fn, $itemA);
                    $b = call_user_func($_fn, $itemB);
                }

                if ($a !== $b) {
                    return $a > $b ? $resA : $resB;
                }
            }

            return 0;
        };
    }

    /**
     * Swartzian sort
     *
     * This function applies a Schwartzian Transform sorting function to an array
     * of values. Multiple `$fns` can be provided and on sort will be applied in
     * order until comparison values no longer match.
     *
     * @link http://en.wikipedia.org/wiki/Schwartzian_transform
     *
     * @param array $arr
     * @param callable|callable[] $fn
     * @param int $order
     * @return array
     */
    public static function schwartzian(array $arr, $fn, $order = self::ASC)
    {
        $fn = self::getCallableList($fn);

        array_walk($arr, function (&$v, $k) use ($fn) {
            $out = [];
            foreach ($fn as $_fn) {
                $out[] = $_fn instanceof Closure ? $_fn($v) : call_user_func($_fn, $v);
            }

            $out[] = $k;
            $out[] = $v;
            $v = $out;
        });

        if (self::DESC === $order) {
            arsort($arr);
        } else {
            asort($arr);
        }

        return array_values(array_map(function ($v) {
            return array_pop($v);
        }, $arr));
    }

    /**
     * @param callable|callable[] $fn
     * @return callable[]
     */
    protected static function getCallableList($fn)
    {
        if (is_callable($fn)) {
            return [$fn];
        }

        return $fn;
    }
}
