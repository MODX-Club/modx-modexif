<?php
require_once __DIR__ . '/exifwriter.php';
require_once __DIR__ . '/exifreader.php';

class modExif extends modProcessor
{
    public function __construct(modX &$modx, array $config = array())
    {
        parent::__construct($modx, $config);

        // using system settings instead of namespace for lightweight def. settings request
        $basePath = $this->modx->getOption('modexif.core_path', $config, $this->modx->getOption('core_path').'components/modexif/');
        $assetsUrl = $this->modx->getOption('modexif.assets_url', $config, $this->modx->getOption('assets_url').'components/modexif/');
        $managerUrl = $this->modx->getOption('modexif.manager_url', $config, $this->modx->getOption('manager_url').'components/modexif/');

        $this->config = array_merge(array(
          'corePath' => $basePath,
          'modelPath' => $basePath.'model/',
          'processorsPath' => $basePath.'processors/',
          'templatesPath' => $basePath.'templates/',
          'elementsPath' => $basePath.'elements/',
          'jsUrl' => $managerUrl.'js/',
          'cssUrl' => $managerUrl.'css/',
          'assetsUrl' => $assetsUrl,
          'managerUrl' => $managerUrl,
          'connectorsUrl' => $managerUrl.'connectors/',
        ), $config);

        $this->publicConfig = array(
          'jsUrl' => $this->config['jsUrl'],
          'cssUrl' => $this->config['cssUrl'],
          'assetsUrl' => $this->config['assetsUrl'],
          'managerUrl' => $this->config['managerUrl'],
          'connectorsUrl' => $this->config['connectorsUrl'],
        );
    }

    public function process()
    {
        return $this->exifWrite($this->getProperty('src'));
    }

    public function exifRead($target)
    {
        $reader = new ExifReader($this->modx);
        $reader->target = $this->getTargetPath($target);
        return $reader->process();
    }

    public function exifWrite($target, array $exif = array())
    {
        if (!$exif) {
            $exif = $this->getProperty('exif');
        }

        $writer = new ExifWriter($this->modx);
        $writer->target = $this->getTargetPath($target);
        $writer->exif = $exif;

        if (!$writer->process()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'can\'t process the image:' . $target);
        }

        return $target;
    }

    private function getTargetPath($target)
    {
        return MODX_BASE_PATH . ($target[0] == '/' ? substr($target, 1) : $target);
    }
}
