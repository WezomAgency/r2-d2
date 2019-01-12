# R2D2

![working in progress](https://img.shields.io/badge/Status-WIP-red.svg)
[![license](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/dutchenkoOleg/node-w3c-validator/blob/master/LICENSE)
[![WezomAgency](https://img.shields.io/badge/composer-require-orange.svg)](https://packagist.org/packages/wezom-agency/r2d2)
[![WezomAgency](https://img.shields.io/badge/Wezom-Agency-red.svg)](https://github.com/WezomAgency)

> R2D2 tiny helper

<img src="https://raw.githubusercontent.com/dutchenkoOleg/storage/master/img/r2d2/r2d2.gif" alt>

---

***Table of contents***

- [Install](#install)
- [Setup](#setup)
- [API](#api)
	- [eject](#eject)
	- [instance::set](#instanceset)

---



## Install

```bash
composer require wezom-agency/browserizr
```

---

## Setup

in your core app file:

```php
use WezomAgency\R2D2;

R2D2::eject()->set('KEY', VALUE);

```

List of settings:

- `debug: bool = false`
- `host: string = ''`
- `protocol: string = 'http://'`
- `rootPath: string = ''`
- `resourceRelativePath: string = ''` - _"shortcut"_ to your resources/assets directory
- `svgSpritemapPath: string = ''` - default path to svg sprite map file


Example of settings

```php
use WezomAgency\R2D2;

R2D2::eject()
    ->set(debug, true)
    ->set('host', $_SERVER['HTTP_HOST'])
    ->set('protocol', 'https://')
    ->set('rootPath', './')
    ->set('resourceRelativePath', '/my/path/to/resources/')
    ->set(
        'svgSpritemapPath',
        R2D2::eject()->resourceUrl('assets/svg/common.svg', true)
    );
```

---

## API

### eject

```php
R2D2::eject() // => R2D2 instance
```

Ejecting R2D2 instance.
Below a list of instance methods

#### instance::set

```php
R2D2::eject()->set($key, $value) R2D2 instance
```

_Parameters:_

| Name       | Data type | Default value | Description    |
| ---------- | --------- | ------------- | -------------- |
| **$name**  | _string_  |               | settings name  |
| **$value** | _any_     |               | settings value |

List of available settings and their values, see above ([# setup section](#setup))



