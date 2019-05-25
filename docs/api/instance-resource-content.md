# R2D2::eject()->resourceContent()

[Docs](../index.md) |
[◄ Prev `instance->nonRepeatingId()`](instance-non-repeating-id.md) | 
[► Next `instance->resourceUrl()`](instance-resource-url.md)

----

This is the same method as [`instance->fileContent()`](instance-file-content.md).  
The only difference is in the relative path that is used to create a full path to the file.

This can be useful for frequently used paths that have a large nesting of directories.   
You can _"save"_ initial part of the path, and specify the rest when calling the method.

```php
R2D2::eject()->resourceContent($path) string
```

_Parameters:_

| Name           | Data type | Default value | Description    |
| :------------- | :-------- | :------------ | :------------- |
| **$path**      | _string_  |               | file relative url, from the `rootPath` (see [`intance->set()`](instance-set.md))  |

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

----

[Docs](../index.md) | 
[▲ Top](#) | 
[◄ Prev `instance->nonRepeatingId()`](instance-non-repeating-id.md) | 
[► Next `instance->resourceUrl()`](instance-resource-url.md)
