<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

class ArrayFromSourceCode
{
    public function getArrayFromSourceCode(string $sourceCode): array
    {
        $pattern = '/var data = \{\s+\'colorImages\': \{ \'initial\': (\[\{.*?\}\])\}/s';
        preg_match($pattern, $sourceCode, $matches);

        $jsonString = $matches[1];
        $jsonArray = json_decode($jsonString, true);

        $array = [];
        foreach ($jsonArray as $variants) {
            $array[] = $variants['hiRes'];
        }

        return $array;
    }
}
