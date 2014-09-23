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
namespace Graze\Sort;

use Closure;

/**
 * @const integer
 */
const DESC = \Graze\Sort::DESC;
const ASC  = \Graze\Sort::ASC;

/**
 * @see Graze\Sort::comparison
 * @param array $arr
 * @param callable|callable[] $fns
 * @param integer $order
 * @return array
 */
function comparison(array $arr, $fn, $order = ASC) {
    return \Graze\Sort::comparison($arr, $fn, $order);
};

/**
 * @see Graze\Sort::comparisonFn
 * @param callable|callable[] $fns
 * @param integer $order
 * @return Closure
 */
function comparison_fn($fn, $order = ASC) {
    return \Graze\Sort::comparisonFn($fn, $order);
};

/**
 * @see Graze\Sort::schwartzian
 * @param array $arr
 * @param callable|callable[] $fns
 * @param integer $order
 * @return array
 */
function schwartzian(array $arr, $fn, $order = ASC) {
    return \Graze\Sort::schwartzian($arr, $fn, $order);
};
