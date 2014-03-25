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
 * Memoized Schwartzian sort
 *
 * This function applies a Schwartzian Transform sorting algorithm to an array
 * of values. Multiple `$fns` can be provided and on sort will be applied in
 * order until comparison values no longer match. If a value appears in `$arr`
 * more than once, a stored result is used rather than reapplying the `$fn`.
 *
 * @link http://en.wikipedia.org/wiki/Schwartzian_transform
 *
 * @param array $arr
 * @param callable|callable[] $fn
 * @param integer $order
 * @return array
 */
function mschwartzian_sort(array $arr, $fn, $order = ASC) {
    return schwartzian_sort($arr, memoize($fn), $order);
};
