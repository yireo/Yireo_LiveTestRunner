# Yireo Live Test Runner for Magento 2

<!-- badges.specs.start -->
![Magento version](https://img.shields.io/badge/Magento-2.4.6%20%7C%202.4.9-orange)
![PHP version](https://img.shields.io/badge/PHP-8.2%E2%80%938.5-777BB4)
![License](https://img.shields.io/badge/License-OSL--3.0-blue)
![Latest Version](https://img.shields.io/packagist/v/yireo/magento2-live-test-runner)
<!-- badges.specs.end -->

This module allows you to run PHPUnit-based *live tests* in Magento 2. Normally, PHPUnit-based code focuses on creating unit tests, integration tests, functional tests and other. But what if you simply want to debug an issue in a copy of a production site? Not a controlled clean environment, but the real deal. To guarantee that certain functionality remains, testing makes sense here as well. Hence the dubbed *live tests*.

A live test is nothing more than a PHPUnit test, but including the Magento application (including database, caching and other) as a bootstrap. With this, you can fetch products from the database and guarantee that their

## Usage
Create your own tests within a folder `Test/Live` (or something else). Next, run the following command, pointing towards your testing folder:

    bin/magento yireo_livetest:run app/code/Foo/Bar/Test/Live

Done.

Tests could be extending upon the parent classes `\Yireo\LiveTestRunner\TestCase\CatalogTestCase` and
`\Yireo\LiveTestRunner\TestCase\GenericTestCase`, but only if you want to: You can make any assertions
using any library out there. This module simply makes sure the Magento bootstrap of your actual dev
environment is run.

## Current status

<!-- badges.test.start -->
![Static Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_LiveTestRunner/static-tests.yml?label=static-tests)
![Unit Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_LiveTestRunner/unit-tests.yml?label=unit-tests)
![Integration Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_LiveTestRunner/integration-tests.yml?label=integration-tests)
![Playwright](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_LiveTestRunner/playwright.yml?label=playwright)
![DI Compilation](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_LiveTestRunner/compile.yml?label=compile)
<!-- badges.test.end -->
