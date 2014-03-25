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
$srcDir = dirname(__DIR__) . '/src/';

require $srcDir . 'lib/Store.php';
require $srcDir . 'constants.php';
require $srcDir . 'memoize.php';
require $srcDir . 'sort_transform.php';
require $srcDir . 'msort_transform.php';
require $srcDir . 'sort.php';
require $srcDir . 'msort.php';
require $srcDir . 'schwartzian_sort.php';
require $srcDir . 'mschwartzian_sort.php';
