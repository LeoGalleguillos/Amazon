<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Word\Model\Service as WordService;
use Zend\View\Helper\AbstractHelper;

class ModifiedFeature extends AbstractHelper
{
    public function __construct(
        WordService\Capitalization $capitalizationService,
        WordService\Thesaurus $thesaurusService
    ) {
        $this->capitalizationService = $capitalizationService;
        $this->thesaurusService      = $thesaurusService;
    }

    public function __invoke(string $feature)
    {
        // Change unicode spaces to ASCII spaces.
        $feature = preg_replace('/[\pZ\pC]/u', ' ', $feature);

        // Remove HTML tags.
        $feature = strip_tags($feature);

        // Remove double-quotes.
        $feature = preg_replace('/\"/', '', $feature);

        $feature = preg_replace('/^(The |This |\*)/', '', $feature);
        $feature = ucfirst($feature);

        // Remove crazy characters.
        $feature = preg_replace('/Â/', '', $feature);
        $feature = preg_replace('/â/', '', $feature);
        $feature = preg_replace('/ã/', '', $feature);
        $feature = preg_replace('/\(.*\)/', '', $feature);
        $feature = preg_replace('/\[.*\]/', '', $feature);
        $feature = preg_replace('/\s{2,}/', ' ', $feature);

        // Replace words.
        $feature = preg_replace('/ ;/', ';', $feature);
        $feature = preg_replace('/ with /', ', ', $feature);
        $feature = preg_replace('/ and /', ', ', $feature);

        // Replace multiple consecutive characters with one character.
        $feature = preg_replace('/,{2,}/', ',', $feature);
        $feature = preg_replace('/-{2,}/', '-', $feature);

        // Trim.
        $feature = trim($feature);

        return $feature;
    }

    protected function replaceFirstWord($feature)
    {
        if (empty($feature)) {
            return $feature;
        }

        $words = preg_split('/\s+/', $feature);
        if (empty($words)) {
            return $feature;
        }

        $firstWord        = $words[0];
        $synonyms         = $this->thesaurusService->getSynonyms($firstWord);
        if (empty($synonyms)) {
            return $feature;
        }

        $numberOfSynonyms = count($synonyms);
        $synonymIndex     = strlen($feature) % $numberOfSynonyms;
        $synonym          = $synonyms[$synonymIndex];

        $capitalization = $this->capitalizationService->getCapitalization($firstWord);

        $synonym = $this->capitalizationService->setCapitalization(
            $synonym,
            $capitalization
        );

        return $feature;
    }
}
