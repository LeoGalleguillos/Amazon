<?php
namespace LeoGalleguillos\Amazon;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\String\Model\Service as StringService;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                    'productModifiedFeature'  => AmazonHelper\Product\ModifiedFeature::class,
                    'productModifiedFeatures' => AmazonHelper\Product\ModifiedFeatures::class,
                    'productModifiedTitle'    => AmazonHelper\Product\ModifiedTitle::class,
                    'productRootRelativeUrl'  => AmazonHelper\Product\RootRelativeUrl::class,
                ],
                'factories' => [
                    AmazonHelper\Product\ModifiedFeature::class => function ($serviceManager) {
                        return new AmazonHelper\Product\ModifiedFeature();
                    },
                    AmazonHelper\Product\ModifiedFeatures::class => function ($serviceManager) {
                        $viewHelperManager = $serviceManager->get('ViewHelperManager');
                        return new AmazonHelper\Product\ModifiedFeatures(
                            $viewHelperManager->get(AmazonHelper\Product\ModifiedFeature::class)
                        );
                    },
                    AmazonHelper\Product\ModifiedTitle::class => function ($serviceManager) {
                        return new AmazonHelper\Product\ModifiedTitle(
                            $serviceManager->get(AmazonService\Product\ModifiedTitle::class)
                        );
                    },
                    AmazonHelper\Product\RootRelativeUrl::class => function ($serviceManager) {
                        return new AmazonHelper\Product\RootRelativeUrl(
                            $serviceManager->get(AmazonService\Product\RootRelativeUrl::class)
                        );
                    },
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AmazonFactory\Binding::class => function ($serviceManager) {
                    return new AmazonFactory\Binding();
                },
                AmazonFactory\Brand::class => function ($serviceManager) {
                    return new AmazonFactory\Brand();
                },
                AmazonFactory\Product::class => function ($serviceManager) {
                    return new AmazonFactory\Product(
                        $serviceManager->get(AmazonFactory\Binding::class),
                        $serviceManager->get(AmazonFactory\Brand::class),
                        $serviceManager->get(AmazonFactory\Product\EditorialReview::class),
                        $serviceManager->get(AmazonFactory\ProductGroup::class),
                        $serviceManager->get(ImageFactory\Image::class),
                        $serviceManager->get(AmazonTable\Product::class),
                        $serviceManager->get(AmazonTable\Product\EditorialReview::class),
                        $serviceManager->get(AmazonTable\Product\Feature::class),
                        $serviceManager->get(AmazonTable\Product\Image::class)
                    );
                },
                AmazonFactory\Product\EditorialReview::class => function ($serviceManager) {
                    return new AmazonFactory\Product\EditorialReview();
                },
                AmazonFactory\ProductGroup::class => function ($serviceManager) {
                    return new AmazonFactory\ProductGroup(
                        $serviceManager->get(AmazonTable\ProductGroup::class)
                    );
                },
                AmazonService\Api::class => function ($serviceManager) {
                    return new AmazonService\Api(
                        $serviceManager->get(AmazonTable\Api::class)
                    );
                },
                AmazonService\Product\ModifiedTitle::class => function ($serviceManager) {
                    return new AmazonService\Product\ModifiedTitle();
                },
                AmazonService\Product\RootRelativeUrl::class => function ($serviceManager) {
                    return new AmazonService\Product\RootRelativeUrl(
                        $serviceManager->get(AmazonService\Product\ModifiedTitle::class),
                        $serviceManager->get(StringService\UrlFriendly::class)
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
                AmazonTable\Product::class => function ($serviceManager) {
                    return new AmazonTable\Product(
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
                AmazonTable\Product\Image::class => function ($serviceManager) {
                    return new AmazonTable\Product\Image(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Review::class => function ($serviceManager) {
                    return new AmazonTable\Product\Review(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Search::class => function ($serviceManager) {
                    return new AmazonTable\Product\Search(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Similar::class => function ($serviceManager) {
                    return new AmazonTable\Product\Similar(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\SimilarRetrieved::class => function ($serviceManager) {
                    return new AmazonTable\Product\SimilarRetrieved(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\ProductGroup::class => function ($serviceManager) {
                    return new AmazonTable\ProductGroup(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Products::class => function ($serviceManager) {
                    return new AmazonTable\Products(
                        $serviceManager->get('amazon')
                    );
                },
            ],
        ];
    }
}
