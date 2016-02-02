<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Monolog\Logger;
use PHPExiftool\Reader;
use PHPExiftool\Driver\Value\ValueInterface;

class ExifReader{
    
    public $target = null;    
    protected $output = "";
    
    public function __construct(modX & $modx){
        $this->modx = $modx;
    }
    
    public function process(){                
        
        if(!$this->target){
            $this->modx->log(1, 'target is empty');
            return false;
        }
        
        $logger = new Logger('exiftool');
        $reader = Reader::create($logger);
        
        $metadatas = $reader->files($this->target)->first();
                
        foreach ($metadatas as $metadata) {
            if (ValueInterface::TYPE_BINARY === $metadata->getValue()->getType()) {                
                $this->output .= sprintf("\t--> Field %s has binary datas" . PHP_EOL, $metadata->getTag()); 
            } else {                
                $this->output .= sprintf("\t--> Field %s has value(s) %s" . PHP_EOL, $metadata->getTag(), $metadata->getValue()->asString());
            }
        }        
        
        return $this->output;
    }
    
}
