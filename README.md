# Graze/Sort #

<img src="http://media2.giphy.com/media/fAaAo6SyjVJf2/200.gif" alt="sort" align="right" height=200/>

This library provides a collection of functions used for array sorting.

The intention is to provide powerful yet simple tools to sort arrays while
remaining interoperable with PHP's build-in usort functions.

It can be installed in whichever way you prefer, but we recommend Composer.
```json
{
    "repositories": [
        {
            "type": "git",
            "url": "git@github.com:graze/sort.git"
        }
    ],
    "require": {
        "graze/sort": "*"
    }
}
```


## Documentation

#### `sort_transform(callable $fn, integer $order = Graze\Sort\ASC);`
#### `sort_transform(callable[] $fns, integer $order = Graze\Sort\ASC);`
> Sort transform
>
This function will return a transform callback for use within PHP's `usort`
functions. Multiple `$fns` can be provided and on sort will be applied in
order until comparison values no longer match.

```php
$list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

usort($list, \Graze\Sort\sort_transform(function ($v) {
    return $v;
});
```
```php
$list = [
    (object) ['foo' => 1, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 2],
    (object) ['foo' => 2, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 2],
    (object) ['foo' => 3, 'bar' => 3],
    (object) ['foo' => 1, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 1],
    (object) ['foo' => 1, 'bar' => 2]
];

$byFoo = function ($v) { return $v->foo; };
$byBar = function ($v) { return $v->bar; };

usort($list, \Graze\Sort\sort_transform([$byFoo, $byBar]));
```

#### `msort_transform(callable $fn, integer $order = Graze\Sort\ASC);`
#### `msort_transform(callable[] $fns, integer $order = Graze\Sort\ASC);`
> Memoized sort transform
>
This function will return a transform callback for use within PHP's `usort`
functions. Multiple `$fns` can be provided and on sort will be applied in
order until comparison values no longer match. Values returned by `$fn` will
be stored for use throughout the sorting algorithm.

```php
$list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

usort($list, \Graze\Sort\msort_transform(function ($v) {
    sleep(100);
    return $v;
});
```
```php
$list = [
    (object) ['foo' => 1, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 2],
    (object) ['foo' => 2, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 2],
    (object) ['foo' => 3, 'bar' => 3],
    (object) ['foo' => 1, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 1],
    (object) ['foo' => 1, 'bar' => 2]
];

$byFoo = function ($v) { sleep(50); return $v->foo; };
$byBar = function ($v) { sleep(50); return $v->bar; };

usort($list, \Graze\Sort\msort_transform([$byFoo, $byBar]));
```

#### `schwartzian_sort(array $arr, callable $fn, integer $order = Graze\Sort\ASC);`
#### `schwartzian_sort(array $arr, callable[] $fns, integer $order = Graze\Sort\ASC);`
> Schwartzian sort
>
This function applies a [Schwartzian Transform][schwartz] sorting algorithm to
an array of values. Multiple `$fns` can be provided and on sort will be applied
in order until comparison values no longer match.

```php
$list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

$list = \Graze\Sort\schwartzian_sort($list, function ($v) {
    return $v;
});
```
```php
$list = [
    (object) ['foo' => 1, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 2],
    (object) ['foo' => 2, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 2],
    (object) ['foo' => 3, 'bar' => 3],
    (object) ['foo' => 1, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 1],
    (object) ['foo' => 1, 'bar' => 2]
];

$byFoo = function ($v) { return $v->foo; };
$byBar = function ($v) { return $v->bar; };

$list = \Graze\Sort\schwartzian_sort($list, [$byFoo, $byBar]));
```

#### `memoize(callable $fn);`
#### `memoize(callable[] $fns);`
> Memoize
>
This function stores values returned by applying `$fn` or `$fns` to a value.

```php
$list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];
$fn = \Graze\Sort\memoize(function ($v) {
    sleep(100);
    return $v;
});

$out = [];
foreach($list as $item) {
    $out[] = $fn($item);
}
```
```php
$list = [
    (object) ['foo' => 1, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 2],
    (object) ['foo' => 2, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 2],
    (object) ['foo' => 3, 'bar' => 3],
    (object) ['foo' => 1, 'bar' => 1],
    (object) ['foo' => 2, 'bar' => 3],
    (object) ['foo' => 3, 'bar' => 1],
    (object) ['foo' => 1, 'bar' => 2]
];

$getFoo = function ($v) { sleep(50); return $v->foo; };
$getBar = function ($v) { sleep(50); return $v->bar; };
$fns = \Graze\Sort\memoize([$getFoo, $getBar]);

foreach ($list as $item) {
    foreach ($fns as $fn) {
        $out[] = $fn($item);
    }
}
```


### License ###
The content of this library is released under the **MIT License** by **Nature Delivered Ltd**.<br/>
You can find a copy of this license at http://www.opensource.org/licenses/mit or in [`LICENSE`][license].


<!-- Links -->
[license]: /LICENSE
[schwartz]: http://en.wikipedia.org/wiki/Schwartzian_transform
