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
	- [instance::resourceUrl](#instanceresourceurl)
	- [instance::resourceContent](#instanceresourcecontent)
	- [instance::str2number](#instancestr2number)

---



# Install

```bash
composer require wezom-agency/r2d2
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

:arrow_up: [_Table of contents_](#table-of-contents)

```php
R2D2::eject() instance
```

Ejecting R2D2 instance.
Below a list of instance methods


---

## instance::set

Setup instance

:arrow_up: [_Table of contents_](#table-of-contents)

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

## instance::fileUrl

:arrow_up: [_Table of contents_](#table-of-contents)

Generate file URL

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

## instance::fileContent

:arrow_up: [_Table of contents_](#table-of-contents)

Get file contents

```php
R2D2::eject()->fileContent($path) string
```

_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$path**      | _string_  |               | file relative url, from the `rootPath` (see [#setup section](#setup))  |

_Returns:_ file contents


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



---

## instance::resourceUrl

:arrow_up: [_Table of contents_](#table-of-contents)

This is the same method as [`instance::fileUrl`](#instancefileurl).  
The only difference is in the relative path that is used to create a full URL.

This can be useful for frequently used paths that have a large nesting of directories.   
You can _"save"_ initial part of the path, and specify the rest when calling the method.


```php
R2D2::eject()->resourceUrl($url, $timestamp = false, $absolute = false) string
```


_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$url**       | _string_  |               | file relative url, from the `resourceRelativePath` (see [#setup section](#setup))  |
| **$timestamp** | _booleab_ | `false`       | set file versioning with query pair `?time=xxx`, if file doesn't exist - query will be empty string |
| **$absolute**  | _booleab_ | `false`       | generate absolute url, with `protocol` and `host` setting (see [#setup section](#setup)) |

_Returns:_ URL 


#### Usage example

```php
<?php
 
use WezomAgency\R2D2;

// in core app file:
// R2D2::eject()
//       ->set('resourceRelativePath', '/my/path/to/resources/folder')

?>
<link rel="stylesheet" href="<?= R2D2::eject()->resourceUrl('css/style1.css'); ?>">
<link rel="stylesheet" href="<?= R2D2::eject()->resourceUrl('css/style2.css', true); ?>">
<link rel="stylesheet" href="<?= R2D2::eject()->resourceUrl('css/style3.css', true, true); ?>">
```
#### Result

```html
<link rel="stylesheet" href="/my/path/to/resources/folder/css/style1.css">
<link rel="stylesheet" href="/my/path/to/resources/folder/css/style2.css?time=1545054627">
<link rel="stylesheet" href="https://my-site.com/my/path/to/resources/folder/css/style3.css?time=1545054627">
```


---

### instance::resourceContent

:arrow_up: [_Table of contents_](#table-of-contents)

This is the same method as [`instance::fileContent`](#instancefilecontent).  
The only difference is in the relative path that is used to create a full path to the file.

This can be useful for frequently used paths that have a large nesting of directories.   
You can _"save"_ initial part of the path, and specify the rest when calling the method.

```php
R2D2::eject()->resourceContent($path) string
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
//       ->set('resourceRelativePath', '/my/path/to/resources/folder')

?>
<style><?= R2D2::eject()->resourceContent('css/critical.css'); ?></style>
<!-- will get content from file ./my/path/to/resources/folder/css/critical.css -->
```
#### Result

```html
<style>html{font:14px/1.3em Arial;color:#222}h1{color:red;font-size:2em}.wysiswyg{font-size:16px;line-height:normal}</style>
```





---

### instance::str2number

:arrow_up: [_Table of contents_](#table-of-contents)

This method is used to convert string attribute values to numbers.

```php
R2D2::eject()->str2number($value) float|int
```

_Parameters:_

| Name           | Data type  | Default value | Description           |
| :------------- | :--------- | :------------ | :-------------------- |
| **$value**     | _string_   | empty string  | html attr value       |
| **$int**       | _boolean_  | `false`       | returns only integers |

_Returns:_ float / int / 0 - if `$value` includes `%` character



