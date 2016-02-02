<?php
include_once dirname(__DIR__) . '/package.php';

//Setup options
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output = "<h2>{$pkgName} Installer</h2>";
        break;
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;
