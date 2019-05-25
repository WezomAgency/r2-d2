# R2D2::eject()->str2number()

[Docs](../index.md) |
[◄ Prev `instance->set()`](instance-set.md) | 
[► Next `instance->svgPlaceholder()`](instance-svg-placeholder.md)

----

This method is used to convert string attribute values to numbers.

```php
R2D2::eject()->str2number($value = '', $int = false) float|int
```

_Parameters:_

| Name           | Data type  | Default value | Description           |
| :------------- | :--------- | :------------ | :-------------------- |
| **$value**     | _string_   | empty string  | html attr value       |
| **$int**       | _boolean_  | `false`       | returns only integers |

_Returns:_ float / int / 0 - if `$value` includes `%` character

----

[Docs](../index.md) | 
[▲ Top](#) | 
[◄ Prev `instance->set()`](instance-set.md) | 
[► Next `instance->svgPlaceholder()`](instance-svg-placeholder.md)
