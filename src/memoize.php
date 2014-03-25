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
 * Memoize
 *
 * This function stores values returned by applying `$fn` or `$fns` to a value.
 *
 * @param callable|callable[] $fn
 * @return Closure|Closure[]
 */
function memoize($fn) {
    if (is_callable($fn)) {
        $fn = [$fn];
    }

    $fns = [];
    foreach ($fn as $_fn) {
        $store = new Store($_fn);
        $fns[] = function ($item) use ($store) {
            return $store->getValue($item);
        };
    }

    return 1 === count($fns) ? reset($fns) : $fns;
};
