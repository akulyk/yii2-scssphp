
Yii2 bindings for SCSS-PHP
==========================

This library provides some improvments of
[lucidtaz/yii2scssphp](https://github.com/LucidTaZ/yii2-scssphp) into
[Yii2](https://github.com/yiisoft/yii2). Scssphp is a native PHP SCSS (SASS)
compiler. This improvment enables you to set destination folder for compiled file or use the 
same folder.

USAGE
-----

Configure `web.php` to disable Yii's built-in asset converter and use the new
one:

```php
$config = [
    ...
    'components' => [
        'assetManager' => [
            'converter' => 'akulyk\yii2scssphp\ScssAssetConverter',
        ],
        ...
    ],
    ...
];
```

If the `AppAsset` is placed in `/assets` and the scss file in
`/assets/source/site.scss`, your `AppAsset.php` could look like:


```
