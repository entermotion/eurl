# eURL

This package aims to deliver a good way to easily escape URLs that will be used on HTML attributes.


## Usage:
```php
use eURL\Functions as eurl

$userInput = $_POST['href'];
$href = eurl\e($userInput);
$safeATag = "<a href='".$href."'>".htmlspecialchars($href)."</a>";
echo $safeATag;
```

## Running tests:

To run the tests you must install the composer dependencies and then run:

```
vendor/bin/phpunit tests/TestUrls.php
```
