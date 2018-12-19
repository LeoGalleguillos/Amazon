<?php
namespace LeoGalleguillos\Amazon\View\Helper\ProductVideo;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use Zend\View\Helper\AbstractHelper;

class SchemaOrgArray extends AbstractHelper
{
    public function __construct(
        AmazonService\Product\ModifiedTitle $modifiedTitleService,
        AmazonService\Product\Slug $slugService
    ) {
        $this->modifiedTitleService = $modifiedTitleService;
        $this->slugService          = $slugService;
    }

    public function __invoke(AmazonEntity\ProductVideo $productVideoEntity): array
    {
        $array = [
            [
                '@context' => 'https://schema.org',
                '@type' => 'VideoObject',
                'url' => $this->getUrl($productVideoEntity),
                'name' => $this->modifiedTitleService->getModifiedTitle($productVideoEntity->getProduct()),

                'duation' => $this->getDuration($productVideoEntity),
                'thumbnailUrl' => $this->getThumbnailUrl($productVideoEntity),
                'playerType' => 'HTML5',
                'width' => '1280',
                'height' => '720',
                'isFamilyFriendly' => 'https://schema.org/True',
                'genre' => 'Shopping',
                'datePublished' => $productVideoEntity->getCreated()->format('Y-m-d'),
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
        return "PT{$minutes}M{$seconds}S";
    }

    protected function getThumbnailUrl(AmazonEntity\ProductVideo $productVideoEntity): string
    {
        return 'https://'
            . $_SERVER['HTTP_HOST']
            . '/videos/products/thumbnails/'
            . $productVideoEntity->getProduct()->getAsin()
            . '.jpg';
    }

    protected function getUrl(AmazonEntity\ProductVideo $productVideoEntity): string
    {
        return 'https://'
            . $_SERVER['HTTP_HOST']
            . '/watch/'
            . $productVideoEntity->getProduct()->getAsin()
            . '/'
            . $this->slugService->getSlug($productVideoEntity->getProduct());
    }
}
