<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

class RandomMp3Rru
{
    public function getRandomMp3Rru(): string
    {
        $directory = '/home/royalty-free/mp3s';
        $files     = scandir($directory);
        $mp3Files  = array_diff($files, ['..', '.']);
        $randomKey = array_rand($mp3Files);

        return $directory . '/' . $mp3Files[$randomKey];
    }
}
