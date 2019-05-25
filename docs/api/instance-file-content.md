# R2D2::eject()->fileContent()

[Docs](../index.md) |
[◄ Prev `instance->cssRules()`](instance-css-rules.md) | 
[► Next `instance->fileUrl()`](instance-file-url.md)

----

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

----

[Docs](../index.md) | 
[▲ Top](#) | 
[◄ Prev `instance->cssRules()`](instance-css-rules.md) | 
[► Next `instance->fileUrl()`](instance-file-url.md)
