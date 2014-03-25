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
 * Cached sort callback
 *
 * This function will return a callback to be used as the callable argument in
 * any of PHP's built-in `usort` functions. The `$fn` callable given to this
 * function will only every be applied to each item once, and the value will be
 * cached and reused further through the sort.
 *
 * @link http://www.php.net/manual/en/function.usort.php
 * @link http://www.php.net/manual/en/function.uasort.php
 * @link http://www.php.net/manual/en/function.uksort.php
 *
 * @param callable $fn
 * @param integer $order
 * @return Closure
 */
function csort_callback(callable $fn, $order = ASC) {
    $store = new Store($fn);
    $resA  =  1 * $order;
    $resB  = -1 * $order;

    return function ($itemA, $itemB) use ($store, $resA, $resB) {
        $a = $store->getValue($itemA);
        $b = $store->getValue($itemB);

        return $a === $b ? 0 : $a > $b ? $resA : $resB;
    };
};