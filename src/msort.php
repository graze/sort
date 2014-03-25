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
 * Memoized sort
 *
 * This function applies PHP's `usort` with a given `$fn` or `$fns` to an array
 * of values. Multiple `$fns` can be provided and will be applied in order
 * until comparison values no longer match. Values returned by `$fn` will be
 * stored for use throughout the sorting algorithm.
 *
 * @param array $arr
 * @param callable|callable[] $fn
 * @param integer $order
 * @return array
 */
function msort(array $arr, $fn, $order = ASC) {
    usort($arr, msort_transform($fn, $order));
    return $arr;
};
