# symfony-standard-headers-csrf-bundle

![CI](https://github.com/marein/symfony-standard-headers-csrf-bundle/workflows/CI/badge.svg?branch=master)

__Table of contents__

* [Overview](#overview)
  * [How it works?](#how-it-works)
* [Installation and requirements](#installation-and-requirements)
* [Configuration](#configuration)
* [Public api](#public-api)

## Overview

Protect symfony applications against CSRF attacks with the help of standard headers.

The mechanism to prevent CSRF attacks which is used by this bundle can best be read under
[OWASP](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html#verifying-origin-with-standard-headers).
The technique is named "Verifying Origin With Standard Headers".

### How it works?

This bundle is based on the headers `Host`, `Origin` and `Referer`. They're part of the
[forbidden headers](https://developer.mozilla.org/en-US/docs/Glossary/Forbidden_header_name)
and cannot be changed programmatically with a standard browser. Please read the
[OWASP](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html#verifying-origin-with-standard-headers)
page carefully as this technique may not work in all cases.

This bundle returns a status code `403` if the request isn't safe.
A request is safe if at least one of the following criteria is met:
* the http method is a safe http method.
* the request path matches one of the `allowed_paths` from the configuration.
* the origin header matches the `Host` header or one of the `allowed_origins` from the configuration.
* `fallback_to_referer` is enabled and the `Referer` header matches the `Host`
header or one of the `allowed_origins` from the configuration.
* `allow_null_origin` is enabled and the `Origin` header is equal to `"null"`.

If there're trusted proxies configured in your symfony application,
`X-Forwarded-Host` is used instead of `Host`.

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
    # List of regular expressions that are used to check for allowed request paths.
    # Each entry is automatically surrounded by the delimiter #.
    #
    # Type: string[]
    # Default: []
    allowed_paths:
        - '^/api'

    # List of regular expressions that are used to check for allowed origins.
    # Each entry is automatically surrounded by the delimiter #.
    #
    # Type: string[]
    # Default: []
    allowed_origins:
        - '^https?://my-domain\.com$'
        - '^https?://.*\.my-other-domain-including-subdomains\.com$'

    # Switch to enable the comparison of the host header and allowed_origins with the referer header.
    #
    # Type: bool
    # Default: true
    fallback_to_referer: true

    # Switch to allow "null" as a valid origin header value.
    #
    # Type: bool
    # Default: false
    allow_null_origin: false
```

## Public api

Only the bundle configuration is part of the public api. Everything else can change and
is not considered a breaking change. Please don't use classes or services directly.
