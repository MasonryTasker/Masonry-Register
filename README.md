# Masonry Register

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.5-8892BF.svg)]
(https://php.net/)
[![License](https://img.shields.io/packagist/l/foundry/masonry-register.svg)]
(https://raw.githubusercontent.com/TheFoundryVisionmongers/Masonry-Register/master/LICENSE.txt)
[![Version](https://img.shields.io/packagist/vpre/foundry/masonry-register.svg)]
(https://packagist.org/packages/foundry/masonry-register)
[![Build Status](https://img.shields.io/travis/TheFoundryVisionmongers/Masonry-Register/master.svg)]
(https://travis-ci.org/TheFoundryVisionmongers/Masonry-Register/branches)

Masonry Register is a plugin for Composer. It allows Masonry modules to be registered whenever the Composer dumps the
autoloader (this happens on `install`, `update` and `dump-autoload`). It looks for and registers all the modules
to allow Masonry to discover descriptions of work and the workers to process them.

## Installation

Masonry Register comes with (and is pretty useless without) Masonry. It was included as a separate repository to allow
users of Masonry to provide their own Registry package.

However, to install it independently via composer, use the following command from the command line:

```bash
composer require foundry/masonry-register -n
```

Note: This will still install Masonry as it is a required component

## Overriding

This package is separated from the main Masonry package to allow it to be easily overridden by a package of your own.

To do so, you must use the `"replace"` property in your composer.json

It would look something like this:

```json
"replace" : {
  "foundry/masonry-register" : "self.version"
}
```

## Contributing

Contributions are very welcome! Please use the [Issue tracker]
(https://github.com/TheFoundryVisionmongers/Masonry-Register/issues) to make any feature requests, report bugs, etc.

If you'd like to contribute code:
 * Fork the project.
 * Write some code.
 * Add tests.
 * Send a pull request to the `develop` branch.
