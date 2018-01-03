<?php
namespace LeoGalleguillos\Amazon;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AmazonService\Api::class => function ($serviceManager) {
                    return new AmazonService\Api(
                        $serviceManager->get(AmazonTable\Api::class)
                    );
                },
                AmazonTable\Api::class => function ($serviceManager) {
                    return new AmazonTable\Api(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Binding::class => function ($serviceManager) {
                    return new AmazonTable\Binding(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Brand::class => function ($serviceManager) {
                    return new AmazonTable\Brand(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\EditorialReview::class => function ($serviceManager) {
                    return new AmazonTable\Product\EditorialReview(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Feature::class => function ($serviceManager) {
                    return new AmazonTable\Product\Feature(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Hashtag::class => function ($serviceManager) {
                    return new AmazonTable\Product\Hashtag(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Search::class => function ($serviceManager) {
                    return new AmazonTable\Product\Search(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
            ],
        ];
    }
}
