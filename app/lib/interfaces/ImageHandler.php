<?php


namespace TestWork\lib\interfaces;


interface ImageHandler
{

    public function resize($originalFile, $targetFile, $targetWidth, $targetHeight, $options = []);

} 