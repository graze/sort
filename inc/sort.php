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
require $srcDir . 'csort_callback.php';
require $srcDir . 'csort_stacked_callback.php';
require $srcDir . 'sort_callback.php';
require $srcDir . 'sort_stacked_callback.php';
