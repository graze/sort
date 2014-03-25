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
 * Sort transform
 *
 * This function will return a transform callback for use within PHP's `usort`
 * functions. Multiple `$fns` can be provided and on sort will be applied in
 * order until comparison values no longer match.
 *
 * @link http://www.php.net/manual/en/function.usort.php
 * @link http://www.php.net/manual/en/function.uasort.php
 * @link http://www.php.net/manual/en/function.uksort.php
 *
 * @param callable|callable[] $fns
 * @param integer $order
 * @return Closure
 */
function sort_transform($fn, $order = ASC) {
    $resA =  1 * $order;
    $resB = -1 * $order;

    if (is_callable($fn)) {
        $fn = [$fn];
    }

    return function ($itemA, $itemB) use ($fn, $resA, $resB) {
        foreach ($fn as $_fn) {
            $a = call_user_func($_fn, $itemA);
            $b = call_user_func($_fn, $itemB);

            if ($a !== $b) {
                return $a > $b ? $resA : $resB;
            }
        }

        return 0;
    };
};
