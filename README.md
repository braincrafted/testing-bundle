BraincraftedTestingBundle
=========================

Handcrafted in Vienna by [Florian Eckerstorfer](https://florian.ec).


About
-----

This bundle currently provides an abstract class to better isolate functional tests of Symfony2 applications. The
`WebTestCase` class drops the schema, recreates it and loads all fixture files. Currently
[DoctrineFixturesBundle](https://github.com/doctrine/DoctrineFixturesBundle) is a required dependency of this bundle.

At some point this bundle may contain other useful classes, services and helpers related to testing.


Installation
------------

You need to add bundle to your `composer.json` file:

```json
{
    "require-dev": {
        "braincrafted/testing-bundle": "@stable"
    }
}
```

*Tip: You should replace `@stable` with a specific [version](https://github.com/braincrafted/testing-bundle/releases).*

### Compatibility

TestingBundle is developed to always work with the latest version of Symfony. The following table helps you choose the
right version of TestingBundle.

<table>
    <thead>
        <tr>
            <td>Symfony version</td>
            <td>TestingBundle version</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>v2.3.*</code></td>
            <td><code>v0.1.*</code></td>
        </tr>
        <tr>
            <td><code>v2.4.*</code>-<code>v2.5.*</code></td>
            <td><code>v0.2.*</code>-<code>v0.3.*</code></td>
        </tr>
        <tr>
            <td><code>v2.6+</code></td>
            <td><code>v0.4+</code></td>
        </tr>
    </tbody>
</table>

The master branch has been updated to be compatible with Symfony 2.3. If you are using Symfony <2.3 you can use the
`0.1` branch.

Add the bundle to your kernel (only activate the bundle in the dev and test environment, you don't need to have it
activated in the production environment):

```php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        // ...
        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Braincrafted\Bundle\TestingBundle\BraincraftedTestingBundle($this);
            // ...
        }
        // ...
    }
    // ...
}
```

Usage
-----

The test cases that you want isolate must extend `Braincrafted\Bundle\TestingBundle\Test\WebTestCase`.

```php
// AcmeDemoBundle/Tests/DemoTest.php
namespace AcmeDemoBundle\Tests;

use Braincrafted\Bundle\TestingBundle\Test\WebTestCase;

class DemoTest extends WebTestCase
{
    // ...
}
```

By default `WebTestCase` provides a `setUp()` and a `tearDown()` method that boot respectively shut down the kernel.
However, if you have your own `setUp()` and/or `tearDown()` methods in your test case you need to manually do this.

```php
// AcmeDemoBundle/Tests/DemoTest.php
namespace AcmeDemoBundle\Tests;

use Braincrafted\Bundle\TestingBundle\Test\WebTestCase;

class DemoTest extends WebTestCase
{
    public function setUp()
    {
        $this->setUpKernel();
        // ...
    }

    public function tearDown()
    {
        $this->tearDownKernel();
        // ...
    }
}
```

If you require a client in your test case, you can use the `createClient()` method:

```php
$client = $this->createClient();
```

`createClient()` will call `setUpKernel()` when no kernel is available at this point.

You can also access the dependency injection container of the kernel:

```php
$container = $this->getContainer();
```

### Render Crawler HTML

The `WebTestCase` class also has an nice helper method that returns the HTML code of a crawler. You can use it in all
test cases that subclass `Braincrafted\Bundle\TestingBundle\Test\WebTestCase`:

```php
echo $this->renderCrawlerHtml($crawler);
```

### Testing Translation Keys

`BraincraftedTestingBundle` installs an alternative translator that is only activated in the `test` environment. This
translator returns the translation key instead of the translated text. That way you can use the translation keys in your
functional tests instead of the translated text.


Change Log
----------

### Version 0.3.2 (26 October 2014)

- [#10](https://github.com/braincrafted/testing-bundle/pull/10) Try to find `AppKernel.php` in a standard path before falling back to `KERNEL_DIR` constant (by [florianeckerstorfer](https://github.com/florianeckerstorfer))

### Version 0.3.1 (25 August 2014)

- Fixed type hint for `WebTestCase::createClient()` method
- Pass `$options` to `WebTestCase::createKernel()` in `WebTestCase::createClient()`


### Version 0.3 (18 November 2013)

- Changed namespace to `Braincrafted`.


License
-------

### The MIT License (MIT)

Copyright (c) 2012-2014 Florian Eckerstorfer

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
