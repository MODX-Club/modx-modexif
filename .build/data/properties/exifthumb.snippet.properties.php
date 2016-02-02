<?php
include_once dirname(dirname(__DIR__)) . '/package.php';
$snippetName = $pkgName;

$properties = array(
  array(
    'name' => "snippetName",
    'desc' => "prop_{$pkgName}.snippetName_prop_desc",
    'type' => 'textfield',
    'options' => '',
    'value' => "pThumb",
    'lexicon' => "{$pkgName}:properties",
  ),
);

return $properties;
