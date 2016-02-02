# modExif

* [PHPExiftool](https://github.com/romainneutron/PHPExiftool)
* [Exiv2 Metadata](http://www.exiv2.org/metadata.html)

## TL;DR
Package allows to modify image's metadata.

## Install
You have to install modExif dependencies via Composer after successful installation at MODX Package Manager.
ModExif uses pThumb for thumb generation. That's why pThumb should be installed too;

## How to:

### write
```
<?php
$path = MODX_CORE_PATH . 'components/modexif/model/';
$modx->getService('exif', 'modExif.modExif', $path);
$image = $modx->runSnippet('exifthumb', array(
    'input' => $imageUrl,
    'options' => array(),
    'exif' => '[{"name":"Nickname","value":"proxyfabio"}]'
));
```

### read
```
$path = MODX_CORE_PATH . 'components/modexif/model/';
$modx->getService('exif', 'modExif.modExif', $path);
$metadata = $modx->exif->exifRead($image);
```
