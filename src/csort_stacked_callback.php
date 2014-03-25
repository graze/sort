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
 * Stacked cache sort callback
 *
 * This function will return a callback to be used as the callable argument in
 * any of PHPs built-in `usort` functions. Each callable in the `$fns` array
 * given to this function will only every be applied to each item once, and the
 * value will be cached and reused further through the sort. The callable
 * `$fns` will be applied in the order provided until comparing two items
 * returns different results. This is useful where sorting based on multiple
 * criteria.
 *
 * @link http://www.php.net/manual/en/function.usort.php
 * @link http://www.php.net/manual/en/function.uasort.php
 * @link http://www.php.net/manual/en/function.uksort.php
 *
 * @param callable[] $fns
 * @param integer $order
 * @return Closure
 */
function csort_stacked_callback(array $fns, $order = ASC) {
    $stores = [];
    $resA =  1 * $order;
    $resB = -1 * $order;

    foreach ($fns as $fn) {
        $stores[] = new Store($fn);
    }

    return function ($itemA, $itemB) use ($stores, $resA, $resB) {
        foreach ($stores as $store) {
            $a = $store->getValue($itemA);
            $b = $store->getValue($itemB);

            if ($a !== $b) {
                return $a > $b ? $resA : $resB;
            }
        }

        return 0;
    };
};
