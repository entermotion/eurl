# eURL

This package aims to deliver a good way to easily escape URLs that will be used on HTML attributes.

You should not use this package to generate URLs, ideally the URLs received here would already be escaped and safe. 
This project doesn't aim to encode your URL and make it browser compatible. 
 
## Goals:

- Prevent XSS attacks
- Avoid at maximum changing and therefore possibly break the URLs

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
vendor/bin/phpunit
```
