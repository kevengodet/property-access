# keven/property-access

## Installation

```sh
$ composer require keven/property-access
```

## Usage

```php
<?php

use Keven\PropertyAccess\Accessor;

$accessor = new Accessor();

echo $accessor->read($myArr, 'status');
$accessor->write($myObj, 'title', 'This is a good title');
```
