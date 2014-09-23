# Sort

<img src="http://media2.giphy.com/media/fAaAo6SyjVJf2/200.gif" alt="sort" align="right" height=200/>

**Master build:** [![Master branch build status][travis-master]][travis]

This library provides a few useful functions used for sorting large arrays or
sorting where comparing array values is expensive to perform. The intention is
to provide these functions while remaining interoperable with PHP's built-in
`usort` functions where possible.

It can be installed in whichever way you prefer, but we recommend [Composer][packagist].
```json
{
    "require": {
        "graze/sort": "*"
    }
}
```

## Documentation
```php
<?php

$unsorted = [
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

$foo = function ($v) { return $v->foo; };
$bar = function ($v) { return $v->bar; };

// Using comparison sorting
$sorted = \Graze\Sort\comparison($unsorted, [$foo, $bar]);

// Using schwartzian sorting
$sorted = \Graze\Sort\schwartzian($unsorted, [$foo, $bar]);

// Using comparison sorting with usort
$sorted = $unsorted;
usort($sorted, \Graze\Sort\comparison_fn($unsorted, [$foo, $bar]));
```

## Contributing
Contributions are accepted via Pull Request, but passing unit tests must be
included before it will be considered for merge.
```bash
$ composer install
$ vendor/bin/phpunit
```

If you have [Vagrant][vagrant] installed, you can build our dev environment to
assist development. The repository will be mounted in `/srv`.
```bash
$ vagrant up
$ vagrant ssh

Welcome to Ubuntu 12.04 LTS (GNU/Linux 3.2.0-23-generic x86_64)
$ cd /srv
```

### License
The content of this library is released under the **MIT License** by
**Nature Delivered Ltd**.<br/> You can find a copy of this license at
http://www.opensource.org/licenses/mit or in [`LICENSE`][license].

<!-- Links -->
[travis]: https://travis-ci.org/graze/sort
[travis-master]: https://travis-ci.org/graze/sort.png?branch=master
[packagist]: https://packagist.org/packages/graze/sort
[vagrant]: http://vagrantup.com
[license]: LICENSE
[schwartz]: http://en.wikipedia.org/wiki/Schwartzian_transform
