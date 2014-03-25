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
 * Memoized sort transform
 *
 * This function will return a transform callback for use within PHP's `usort`
 * functions. Multiple `$fns` can be provided and on sort will be applied in
 * order until comparison values no longer match. Values returned by `$fn` will
 * be stored for use throughout the sorting algorithm.
 *
 * @link http://www.php.net/manual/en/function.usort.php
 * @link http://www.php.net/manual/en/function.uasort.php
 * @link http://www.php.net/manual/en/function.uksort.php
 *
 * @param callable|callable[] $fn
 * @param integer $order
 * @return Closure
 */
function msort_transform($fn, $order = ASC) {
    return sort_transform(memoize($fn), $order);
};
