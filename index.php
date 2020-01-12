<?php

require_once 'app/bootstrap.php';
require_once(PROJECT_PATH . '/lib/helper/index.php');


$actualCollectionDirPath = fixDirSeparatorsToTheLeft(PROJECT_PATH . '/test/data/input/');
$outputCollectionDirPath = fixDirSeparatorsToTheLeft(PROJECT_PATH . '/test/data/output/');
$resultCollectionDirPath = fixDirSeparatorsToTheLeft('H:\Alisa\photoalbum/');

foreach (getDirFilesList($actualCollectionDirPath) as $fileName) {
    $actualFilePath = $actualCollectionDirPath . $fileName;

    $fileData = exif_read_data($actualFilePath);
    if ($fileData === false) {
        $fileData = strval(filemtime($actualFilePath));
        if ($fileData === false) {
            throw new Exception('EXCEPTION_A');
        }

        $date = new DateTime();
        $date->setTimestamp($fileData);

        $allowedExt = ['mp4'];

    } else {
        $date = new DateTime($fileData['DateTimeOriginal']);

        $allowedExt = ['jpg'];
    }
    $d = $date->format('Y-m-d');

    $extension = strtolower(pathinfo($actualFilePath, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExt)) {
        throw new Exception('EXCEPTION_B');
    }

    for ($i = 1, $done = false; $done !== true && $i < 88; $i++) {
        $format = sprintf('%s.%02d.%s', $d, $i, $extension);

        $resultFilePath = $resultCollectionDirPath . $format;
        if (file_exists($resultFilePath)) {
            continue;
        }
        $outputFilePath = $outputCollectionDirPath . $format;
        if (file_exists($outputFilePath)) {
            continue;
        }

        $done = copy($actualFilePath, $outputFilePath);
    }
//    echo ".";
};

echo "\nfinished.";

