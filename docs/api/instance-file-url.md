# R2D2::eject()->fileUrl()

[Docs](../index.md) |
[◄ Prev `instance->fileContent()`](instance-file-content.md) | 
[► Next `instance->htmlOpenTag()`](instance-html-open-tag.md)

----

Generate file URL

```php
R2D2::eject()->fileUrl($url, $timestamp = false, $absolute = false) string
```


_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$url**       | _string_  |               | file relative url, from site root, e.q `/assets/css/my.css`  |
| **$timestamp** | _boolean_ | `false`       | set file versioning with query pair `?time=xxx`, if file doesn't exist - query will be empty string |
| **$absolute**  | _boolean_ | `false`       | generate absolute url, with `protocol` and `host` setting (see [#setup section](#setup)) |

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

----

[Docs](../index.md) | 
[▲ Top](#) | 
[◄ Prev `instance->fileContent()`](instance-file-content.md) | 
[► Next `instance->htmlOpenTag()`](instance-html-open-tag.md)
