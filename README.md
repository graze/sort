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

#### `Graze\Sort\sort(callable $fn, integer $order = Graze\Sort\ASC);`
> Sort
>
This function will return a callback to be used as the callable argument in
any of PHP's built-in `usort` functions.

```php
$list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

usort($list, \Graze\Sort\sort(function ($v) {
    return $v;
});
```

#### `Graze\Sort\sort_stacked(callable[] $fns, integer $order = Graze\Sort\ASC);`
> Stacked sort
>
This function will return a callback to be used as the callable argument in
any of PHPs built-in `usort` functions. The callable `$fns` will be applied
in the order provided until comparing two items returns different results.
This is useful where sorting based on multiple criteria.

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

usort($list, \Graze\Sort\sort_stacked([$byFoo, $byBar]));
```

#### `Graze\Sort\csort(callable $fn, integer $order = Graze\Sort\ASC);`
> Cached sort
>
This function will return a callback to be used as the callable argument in
any of PHP's built-in `usort` functions. The `$fn` callable given to this
function will only every be applied to each item once, and the value will be
cached and reused further through the sort.

```php
$list = [2, 1, 3, 2, 3, 2, 2, 1, 3, 1, 2, 3, 1, 1, 1, 3, 3, 2];

// $fn is called a maximum of one time per value and cached for reuse
usort($list, \Graze\Sort\csort(function ($v) {
    sleep(10);
    return $v;
});
```

#### `Graze\Sort\csort_stacked(callable[] $fns, integer $order = Graze\Sort\ASC);`
> Stacked cache sort
>
This function will return a callback to be used as the callable argument in
any of PHP's built-in `usort` functions. Each callable in the `$fns` array
given to this function will only every be applied to each item once, and the
value will be cached and reused further through the sort. The callable
`$fns` will be applied in the order provided until comparing two items
returns different results. This is useful where sorting based on multiple
criteria.

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

// Each $fn is called a maximum of one time per value and cached for reuse
$byFoo = function ($v) { sleep(10); return $v->foo; };
$byBar = function ($v) { sleep(90); return $v->bar; };

usort($list, \Graze\Sort\csort_stacked([$byFoo, $byBar]));
```


### License ###
The content of this library is released under the **MIT License** by **Nature Delivered Ltd**.<br/>
You can find a copy of this license at http://www.opensource.org/licenses/mit or in [`LICENSE`][license].


<!-- Links -->
[license]: /LICENSE
