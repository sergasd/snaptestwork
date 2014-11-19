<?php

namespace TestWork\lib;

use TestWork\lib\interfaces\ImageHandler;

class ImagicImageHandler implements ImageHandler
{

    private $imagickPath;

    public function __construct($imagickPath = '/usr/bin/convert')
    {
        $this->imagickPath = $imagickPath;
    }

    public function resize($originalFile, $targetFile, $targetWidth, $targetHeight, $options = [])
    {
        $command = sprintf(
            "%s %s -resize %dx%d %s 2>&1",
            escapeshellcmd($this->imagickPath),
            escapeshellarg($originalFile),
            $targetWidth,
            $targetHeight,
            escapeshellarg($targetFile)
        );

        exec($command, $output, $status);

        if ($status !== 0) {
            throw new \Exception('resize failed' . implode("\n", $output));
        }
    }

} 