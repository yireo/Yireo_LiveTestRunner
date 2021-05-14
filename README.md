# Yireo Live Test Runner for Magento 2
This module allows you to run PHPUnit-based *live tests* in Magento 2. Normally, PHPUnit-based code focuses on creating unit tests, integration tests, functional tests and other. But what if you simply want to debug an issue in a copy of a production site? Not a controlled clean environment, but the real deal. To guarantee that certain functionality remains, testing makes sense here as well. Hence the dubbed *live tests*.

A live test is nothing more than a PHPUnit test, but including the Magento application (including database, caching and other) as a bootstrap. With this, you can fetch products from the database and guarantee that their

## Usage
Create your own tests within a folder `Test/Live` (or something else). Next, run the following command, pointing towards your testing folder:

    bin/magento yireo_livetest:run app/code/Foo/Bar/Test/Live

Done.

Tests could be extending upon the parent classes `\Yireo\LiveTestRunner\TestCase\CatalogTestCase` and `\Yireo\LiveTestRunner\TestCase\GenericTestCase`, but only if you want to.