<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Monolog\Logger;
use PHPExiftool\Writer;
use PHPExiftool\Driver\Metadata\Metadata;
use PHPExiftool\Driver\Metadata\MetadataBag;

class ExifWriter
{

    public $target = null;
    public $exif = array();

    public function __construct(modX & $modx)
    {
        $this->modx = $modx;
    }

    public function process()
    {
        if (!$this->target) {
            $this->modx->log(1, 'target is empty');
            return false;
        }

        $logger = new Logger('exiftool');
        $Writer = Writer::create($logger);
        $bag = new MetadataBag();


        $this->modx->invokeEvent('OnModExifMetaTagAdd', array(
            'writer' => &$this,
            'metadataBag' => & $bag,
            'tags' => $this->exif
        ));

        $ok = $Writer->write($this->target, $bag);

        if (is_null($ok)) {
            $this->modx->log(1, 'Metadata bag is empty');
            return true;
        } elseif (!$ok) {
            return false;
        }

        return true;
    }

    public function tagGet($tagName, $tagValue)
    {
        return new Metadata($tagName, $tagValue);
    }
}
