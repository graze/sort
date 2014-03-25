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
 * Swartzian sort
 *
 * This function applies a Schwartzian Transform sorting algorithm to an array
 * of values. Multiple `$fns` can be provided and on sort will be applied in
 * order until comparison values no longer match.
 *
 * @link http://en.wikipedia.org/wiki/Schwartzian_transform
 *
 * @param array $arr
 * @param callable|callable[] $fns
 * @param integer $order
 * @return array
 */
function schwartzian_sort(array $arr, $fn, $order = ASC) {
    if (is_callable($fn)) {
        $fn = [$fn];
    }

    array_walk($arr, function (&$v, $k) use ($fn) {
        $out = [];
        foreach ($fn as $_fn) {
            $out[] = call_user_func($_fn, $v);
        }

        $out[] = $k;
        $out[] = $v;
        $v = $out;
    });

    if (DESC === $order) {
        arsort($arr);
    } else {
        asort($arr);
    }

    return array_values(array_map(function ($v) {
        return array_pop($v);
    }, $arr));
};
