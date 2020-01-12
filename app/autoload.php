<?php

require_once(PROJECT_PATH . '/features.php');
require_once(PROJECT_PATH . '/settings.php');

class projectAutoloader
{
    public static function autoload($className)
    {
        // loading all app "model" classes
        $inApp = PROJECT_PATH . '/model/' . str_replace('_', '/', $className) . '.php';
        if (file_exists($inApp)) {
            require_once $inApp;
        }

        // loading classes of a lib to integrate with images / videos metadata
        $id3LibPath = PROJECT_PATH . 'lib/getID3/getid3';
        require_once $id3LibPath . '/getid3.php';
        require_once $id3LibPath . '/write.php';

        // loading helping classes
        require_once(PROJECT_PATH . 'lib/helper/index.php');
    }
}
