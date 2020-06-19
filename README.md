# symfony-standard-headers-csrf-bundle

![CI](https://github.com/marein/symfony-standard-headers-csrf-bundle/workflows/CI/badge.svg?branch=master)

__Table of contents__

* [Overview](#overview)
* [Installation and requirements](#installation-and-requirements)
* [Configuration](#configuration)

## Overview

Protect symfony applications against CSRF attacks with the help of standard headers.

## Installation and requirements

Add the bundle to your project.

```
composer require marein/symfony-standard-headers-csrf-bundle
```

Add the bundle in the kernel. This can be different for your setup.

```php
public function registerBundles()
{
    return [
        // ...
        new \Marein\StandardHeadersCsrfBundle\MareinStandardHeadersCsrfBundle(),
        // ...
    ];
}
```

## Configuration

This is an example of all configurations in yaml format.

```yaml
marein_standard_headers_csrf:
    # A list of regular expressions that are tested against the URL path.
    # If a match is found, the request is considered unsafe and must be checked against CSRF attacks.
    #
    # Note:
    # If you manage an api that is not called from a browser and has
    # an authentication mechanism other than cookies, you can also negate
    # the regular expression and protect everything except the specific api
    # path. For example with ['^(?!/api)'] as the value.
    #
    # Type: Array of strings
    # Default: ['^/']
    protected_paths:
        - '^/me'
        - '^/user'

    # A list of origins that are trusted.
    #
    # Type: Array of strings
    # Default: []
    allowed_origins:
        - 'http://my-domain.com'
        - 'https://my-domain.com'
        - 'http://my-other-domain.com'
        - 'https://my-other-domain.com'

    # Allowed origins are also compared to the referer header if there is no origin header.
    #
    # Type: Boolean
    # Default: true
    fallback_to_referer: true

    # Allows 'null' as the origin value. This covers some edge cases described by OWASP.
    #
    # Type: Boolean
    # Default: false
    allow_null_origin: false
```
