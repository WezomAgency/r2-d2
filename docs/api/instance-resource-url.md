# R2D2::eject()->resourceUrl()

[Docs](../index.md) |
[◄ Prev `instance->resourceContent()`](instance-resource-content.md) | 
[► Next `instance->set()`](instance-set.md)

----

This is the same method as [`instance->fileUrl()`](instance-file-url.md).  
The only difference is in the relative path that is used to create a full URL.

This can be useful for frequently used paths that have a large nesting of directories.   
You can _"save"_ initial part of the path, and specify the rest when calling the method.


```php
R2D2::eject()->resourceUrl($url, $timestamp = false, $absolute = false) string
```


_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$url**       | _string_  |               | file relative url, from the `resourceRelativePath` (see [`intance->set()`](instance-set.md))  |
| **$timestamp** | _boolean_ | `false`       | set file versioning with query pair `?time=xxx`, if file doesn't exist - query will be empty string |
| **$absolute**  | _boolean_ | `false`       | generate absolute url, with `protocol` and `host` setting (see [`intance->set()`](instance-set.md)) |

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

----

[Docs](../index.md) | 
[▲ Top](#) | 
[◄ Prev `instance->resourceContent()`](instance-resource-content.md) | 
[► Next `instance->set()`](instance-set.md)
