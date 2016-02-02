<?php

$snippets = array();

/* course snippets */

$list = array('exifthumb');

if (!$list) {
    $modx->log(modX::LOG_LEVEL_INFO, 'Snippets list is empty');
    return $list;
}

foreach ($list as $v) {
    $snippet_name = $v;
    $content = getSnippetContent($sources['snippets'] . $snippet_name . '.snippet.php');

    if (!empty($content)) {
        $snippet = $modx->newObject('modSnippet');
        $snippet->fromArray(array(
          'name' => $snippet_name,
          'description' => $snippet_name.'_desc',
          'snippet' => $content,
        ), '', true, true);
        $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in '.$snippet_name.' snippet.');
        flush();

        $path = $sources['properties']."{$snippet_name}.snippet.properties.php";
        if (is_file($path)) {
            $properties = include $path;
            $snippet->setProperties($properties);
            $modx->log(modX::LOG_LEVEL_INFO, 'Adding properties for '.$snippet_name.' snippet.');
            flush();
        }

        $snippets[] = $snippet;
    }
}

unset($properties, $snippet, $path, $snippet_name, $content, $list);
return $snippets;