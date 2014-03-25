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

/**
 * Stacked sort callback
 *
 * This function will return a callback to be used as the callable argument in
 * any of PHPs built-in `usort` functions. The callable `$fns` will be applied
 * in the order provided until comparing two items returns different results.
 * This is useful where sorting based on multiple criteria.
 *
 * @link http://www.php.net/manual/en/function.usort.php
 * @link http://www.php.net/manual/en/function.uasort.php
 * @link http://www.php.net/manual/en/function.uksort.php
 *
 * @param callable[] $fns
 * @param integer $order
 * @return Closure
 */
function sort_stacked_callback(array $fns, $order = ASC) {
    $resA =  1 * $order;
    $resB = -1 * $order;

    return function ($itemA, $itemB) use ($fns, $resA, $resB) {
        foreach ($fns as $fn) {
            $a = call_user_func($fn, $itemA);
            $b = call_user_func($fn, $itemB);

            if ($a !== $b) {
                return $a > $b ? $resA : $resB;
            }
        }

        return 0;
    };
};
