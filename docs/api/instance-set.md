# R2D2::eject()->set()

[Docs](../index.md) |
[◄ Prev `instance->resourceUrl()`](instance-resource-url.md) | 
[► Next `instance->str2number()`](instance-str2number.md)

----

Setup instance

```php
R2D2::eject()->set($key, $value): instance
```

_Parameters:_

| Name       | Data type | Default value | Description    |
| :--------- | :-------- | :------------ | :------------- |
| **$name**  | _string_  |               | settings name  |
| **$value** | _any_     |               | settings value |

List of available settings:

- `debug: bool = false`
- `host: string = ''`
- `protocol: string = 'http://'`
- `rootPath: string = ''`
- `resourceRelativePath: string = ''` - _"shortcut"_ to your resources/assets directory
- `svgSpritemapPath: string = ''` - default path to svg sprite map file


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

----

[Docs](../index.md) | 
[▲ Top](#) | 
[◄ Prev `instance->resourceUrl()`](instance-resource-url.md) | 
[► Next `instance->str2number()`](instance-str2number.md)
