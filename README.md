# R2D2

![working in progress](https://img.shields.io/badge/Status-WIP-red.svg)
[![license](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/dutchenkoOleg/node-w3c-validator/blob/master/LICENSE)
[![WezomAgency](https://img.shields.io/badge/composer-require-orange.svg)](https://packagist.org/packages/wezom-agency/r2d2)
[![WezomAgency](https://img.shields.io/badge/Wezom-Agency-red.svg)](https://github.com/WezomAgency)

> R2D2 tiny helper

<img src="https://raw.githubusercontent.com/dutchenkoOleg/storage/master/img/r2d2/r2d2.gif" alt>

---

### *Table of contents*

- [Install](#install)
- [Setup](#setup)
- [API](#api)
	- [eject](#eject)
	- [instance::set](#instanceset)
	- [instance::fileUrl](#instancefileurl)
	- [instance::fileContent](#instancefilecontent)

---



# Install

```bash
composer require wezom-agency/browserizr
```

---

# Setup

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

# API

## eject

```php
R2D2::eject() instance
```

Ejecting R2D2 instance.
Below a list of instance methods


---

### instance::set

```php
R2D2::eject()->set($key, $value) instance
```

_Parameters:_

| Name       | Data type | Default value | Description    |
| :--------- | :-------- | :------------ | :------------- |
| **$name**  | _string_  |               | settings name  |
| **$value** | _any_     |               | settings value |

List of available settings and their values, see above ([#setup section](#setup))



---

### instance::fileUrl

Generate file url.

```php
R2D2::eject()->fileUrl($url, $timestamp = false, $absolute = false) string
```


_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$url**       | _string_  |               | file relative url, from site root, e.q `/assets/css/my.css`  |
| **$timestamp** | _booleab_ | `false`       | set file versioning with query pair `?time=xxx`, if file doesn't exist - query will be empty string |
| **$absolute**  | _booleab_ | `false`       | generate absolute url, with `protocol` and `host` setting (see [#setup section](#setup)) |

_Returns:_ URL 


#### Usage example

```php
<?php
 
use WezomAgency\R2D2;

// in core app file:
// R2D2::eject()
//       ->set('host', 'my-site.com')
//       ->set('protocol', 'https://')

?>
<link rel="stylesheet" href="<?= R2D2::eject()->fileUrl('/assets/css/style1.css'); ?>">
<link rel="stylesheet" href="<?= R2D2::eject()->fileUrl('/assets/css/style2.css', true); ?>">
<link rel="stylesheet" href="<?= R2D2::eject()->fileUrl('/assets/css/style3.css', true, true); ?>">
```
#### Result

```html
<link rel="stylesheet" href="/assets/css/style1.css">
<link rel="stylesheet" href="/assets/css/style2.css?time=1545054627">
<link rel="stylesheet" href="https://my-site.com/assets/css/style3.css?time=1545054627">
```


---

### instance::fileContent

Get file content.

```php
R2D2::eject()->fileContent($path) string
```

_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$path**      | _string_  |               | file relative url, from the `rootPath` (see [#setup section](#setup))  |

_Returns:_ file content


#### Usage example

```php
<?php
 
use WezomAgency\R2D2;

// in core app file:
// R2D2::eject()
//       ->set('rootPath', './')

?>
<style><?= R2D2::eject()->fileContent('/assets/css/critical.css'); ?></style>
```
#### Result

```html
<style>html{font:14px/1.3em Arial;color:#222}h1{color:red;font-size:2em}.wysiswyg{font-size:16px;line-height:normal}</style>
```



