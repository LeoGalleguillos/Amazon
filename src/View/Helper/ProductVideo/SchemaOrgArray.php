<?php
namespace LeoGalleguillos\Amazon\View\Helper\ProductVideo;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use Zend\View\Helper\AbstractHelper;

class SchemaOrgArray extends AbstractHelper
{
    public function __construct(
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->urlFriendlyService = $urlFriendlyService;
    }

    public function __invoke(AmazonEntity\ProductVideo $productVideoEntity): array
    {
        $array = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'VideoObject',
                'url' => $this->getUrl($productVideoEntity),
                'name' => $productVideoEntity->getTitle(),
                'description' => $productVideoEntity->getTitle(),

                'duration' => $this->getDuration($productVideoEntity),
                'thumbnailUrl' => $this->getThumbnailUrl($productVideoEntity),
                'playerType' => 'HTML5 Flash',
                'width' => '1280',
                'height' => '720',
                'isFamilyFriendly' => 'https://schema.org/True',
                'genre' => 'Shopping',
                'datePublished' => $productVideoEntity->getCreated()->format('Y-m-d'),
                'uploadDate' => $productVideoEntity->getCreated()->format('Y-m-d'),
                'thumbnail' => [
                    '@type' => 'ImageObject',
                    'url' => $this->getThumbnailUrl($productVideoEntity),
                    'width' => '1280',
                    'height' => '720',
                ],

            ]
        ];
        return $array;
    }

    protected function getDuration(AmazonEntity\ProductVideo $productVideoEntity): string
    {
        $durationMilliseconds = $productVideoEntity->getDurationMilliseconds();
        $durationSeconds      = round($durationMilliseconds / 1000);

        $minutes = floor($durationSeconds / 60);
        $seconds = $durationSeconds - $minutes * 60;

        if ($minutes) {
            return "PT{$minutes}M{$seconds}S";
        } else {
            return "PT{$seconds}S";
        }
    }

    protected function getThumbnailUrl(AmazonEntity\ProductVideo $productVideoEntity): string
    {
        return 'https://'
            . $_SERVER['HTTP_HOST']
            . '/videos/products/thumbnails/'
            . $productVideoEntity->getAsin()
            . '.jpg';
    }

    protected function getUrl(AmazonEntity\ProductVideo $productVideoEntity): string
    {
        return 'https://'
            . $_SERVER['HTTP_HOST']
            . '/watch/'
            . $productVideoEntity->getAsin()
            . '/'
            . $this->urlFriendlyService->getUrlFriendly(
                $productVideoEntity->getTitle()
            );
    }
}
