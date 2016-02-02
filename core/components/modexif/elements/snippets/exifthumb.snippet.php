<?php

if (!$snippetName) {
    $modx->log(xPDO::LOG_LEVEL_ERROR, 'snippetname is not defined');
    return null;
}
# else

$src = $modx->runSnippet($snippetName, array('input' => $input, 'options' => $options));
if (!$src) {
    $modx->log(xPDO::LOG_LEVEL_ERROR, 'can\'t make an image thumb');
    return null;
}
# else
$result = $src;

if (is_string($exif)) {
    $exif = json_decode($exif, 1);
}

if (!$exif) {
    if ($modx->getOption('debug') && $modx->hasPermission('debug')) {
        $modx->log(xPDO::LOG_LEVEL_ERROR, "exif is not defined for {$input}");
    }
    return $result;
}
# else

$modx->getService('modexif', 'modExif.modExif', MODX_CORE_PATH .'components/modexif/model/', array(
    'src' => & $result,
    'exif' => $exif
));

if (!$modx->modexif) {
    $modx->log(xPDO::LOG_LEVEL_ERROR, 'can\'t load exif service');
    return $result;
}
# else

$response = $modx->modexif->run();
return $response->getResponse();
