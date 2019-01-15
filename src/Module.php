<?php
namespace LeoGalleguillos\Amazon;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Hashtag\Model\Service as HashtagService;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\String\Model\Service as StringService;
use LeoGalleguillos\Video\Model\Service as VideoService;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                    'productAffiliateUrl'     => AmazonHelper\Product\AffiliateUrl::class,
                    'productModifiedFeature'  => AmazonHelper\Product\ModifiedFeature::class,
                    'getModifiedTitle'        => AmazonHelper\Product\ModifiedTitle::class,
                    'getProductAffiliateUrl'  => AmazonHelper\Product\AffiliateUrl::class,
                    'getProductFirstImageEntity'  => AmazonHelper\Product\FirstImageEntity::class,
                    'getProductModifiedFeatures' => AmazonHelper\Product\ModifiedFeatures::class,
                    'getProductRootRelativeUrl'  => AmazonHelper\Product\RootRelativeUrl::class,
                    'getProductVideoSchemaOrgArray'  => AmazonHelper\ProductVideo\SchemaOrgArray::class,
                ],
                'factories' => [
                    AmazonHelper\Product\AffiliateUrl::class => function ($serviceManager) {
                        return new AmazonHelper\Product\AffiliateUrl();
                    },
                    AmazonHelper\Product\FirstImageEntity::class => function ($serviceManager) {
                        return new AmazonHelper\Product\FirstImageEntity(
                            $serviceManager->get(AmazonService\Product\FirstImageEntity::class)
                        );
                    },
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
                    AmazonHelper\ProductVideo\SchemaOrgArray::class => function ($sm) {
                        return new AmazonHelper\ProductVideo\SchemaOrgArray(
                            $sm->get(AmazonService\Product\ModifiedTitle::class),
                            $sm->get(AmazonService\Product\Slug::class)
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
                AmazonFactory\BrowseNode::class => function ($serviceManager) {
                    return new AmazonFactory\BrowseNode(
                        $serviceManager->get(AmazonTable\BrowseNode::class)
                    );
                },
                AmazonFactory\Product::class => function ($serviceManager) {
                    return new AmazonFactory\Product(
                        $serviceManager->get(AmazonFactory\Binding::class),
                        $serviceManager->get(AmazonFactory\Brand::class),
                        $serviceManager->get(AmazonFactory\ProductGroup::class),
                        $serviceManager->get(ImageFactory\Image::class),
                        $serviceManager->get(AmazonTable\Product::class),
                        $serviceManager->get(AmazonTable\ProductFeature::class),
                        $serviceManager->get(AmazonTable\ProductImage::class),
                        $serviceManager->get(AmazonTable\ProductHiResImage::class)
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
                AmazonFactory\ProductVideo::class => function ($sm) {
                    return new AmazonFactory\ProductVideo(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\Api::class => function ($serviceManager) {
                    return new AmazonService\Api(
                        $serviceManager->get(AmazonTable\Api::class)
                    );
                },
                AmazonService\Api\ItemLookup\BrowseNodes\Xml::class => function ($sm) {
                    $amazonConfig = $sm->get('Config')['amazon'];
                    return new AmazonService\Api\ItemLookup\BrowseNodes\Xml(
                        $amazonConfig['access_key_id'],
                        $amazonConfig['associate_tag'],
                        $amazonConfig['secret_access_key']
                    );
                },
                AmazonService\Api\ItemLookup\BrowseNodes\Xml\DownloadToMySql::class => function ($sm) {
                    return new AmazonService\Api\ItemLookup\BrowseNodes\Xml\DownloadToMySql(
                        $sm->get(AmazonTable\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class),
                        $sm->get(AmazonTable\Product\Asin::class)
                    );
                },
                AmazonService\Api\Product\Xml::class => function ($serviceManager) {
                    $config = $serviceManager->get('Config');
                    return new AmazonService\Api\Product\Xml(
                        $config['amazon']['access_key_id'],
                        $config['amazon']['associate_tag'],
                        $config['amazon']['secret_access_key']
                    );
                },
                AmazonService\Api\Product\Xml\DownloadToMySql::class => function ($sm) {
                    return new AmazonService\Api\Product\Xml\DownloadToMySql(
                        $sm->get(AmazonTable\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class),
                        $sm->get(AmazonTable\Product::class),
                        $sm->get(AmazonTable\ProductFeature::class),
                        $sm->get(AmazonTable\ProductImage::class)
                    );
                },
                AmazonService\Api\SimilarProducts\Xml::class => function ($serviceManager) {
                    $config = $serviceManager->get('Config');
                    return new AmazonService\Api\SimilarProducts\Xml(
                        $config['amazon']['access_key_id'],
                        $config['amazon']['associate_tag'],
                        $config['amazon']['secret_access_key']
                    );
                },
                AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class => function ($sm) {
                    return new AmazonService\Api\Xml\BrowseNode\DownloadToMySql(
                        $sm->get(AmazonTable\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class)
                    );
                },
                AmazonService\Binding::class => function ($serviceManager) {
                    return new AmazonService\Binding(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonTable\Binding::class)
                    );
                },
                AmazonService\Brand::class => function ($serviceManager) {
                    return new AmazonService\Brand(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonTable\Brand::class)
                    );
                },
                AmazonService\BrowseNode\BrowseNodes::class => function ($serviceManager) {
                    return new AmazonService\BrowseNode\BrowseNodes(
                        $serviceManager->get(AmazonFactory\BrowseNode::class),
                        $serviceManager->get(AmazonTable\BrowseNode::class)
                    );
                },
                AmazonService\BrowseNode\BrowseNodes\BrowseNodeIds::class => function ($serviceManager) {
                    return new AmazonService\BrowseNode\BrowseNodes\BrowseNodeIds(
                        $serviceManager->get(AmazonService\BrowseNode\BrowseNodes::class)
                    );
                },
                AmazonService\Hashtag\Products\ProductGroup::class => function ($serviceManager) {
                    return new AmazonService\Hashtag\Products\ProductGroup(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonTable\ProductHashtag::class)
                    );
                },
                AmazonService\Product::class => function ($serviceManager) {
                    return new AmazonService\Product(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonService\Api::class),
                        $serviceManager->get(AmazonService\Api\Product\Xml::class),
                        $serviceManager->get(AmazonService\Api\Product\Xml\DownloadToMySql::class),
                        $serviceManager->get(AmazonTable\Product::class)
                    );
                },
                AmazonService\Product\FirstImageEntity::class => function ($serviceManager) {
                    return new AmazonService\Product\FirstImageEntity();
                },
                AmazonService\Product\Hashtags::class => function ($serviceManager) {
                    return new AmazonService\Product\Hashtags(
                        $serviceManager->get(AmazonService\Product\Hashtags\ProductEntity::class)
                    );
                },
                AmazonService\Product\Hashtags\Insert::class => function ($serviceManager) {
                    return new AmazonService\Product\Hashtags\Insert(
                        $serviceManager->get(AmazonTable\ProductHashtag::class),
                        $serviceManager->get(HashtagService\Hashtag::class)
                    );
                },
                AmazonService\Product\Hashtags\ProductEntity::class => function ($serviceManager) {
                    return new AmazonService\Product\Hashtags\ProductEntity();
                },
                AmazonService\Product\HasImage::class => function ($sm) {
                    return new AmazonService\Product\HasImage();
                },
                AmazonService\Product\ModifiedTitle::class => function ($serviceManager) {
                    return new AmazonService\Product\ModifiedTitle();
                },
                AmazonService\Product\SimilarProducts::class => function ($serviceManager) {
                    return new AmazonService\Product\SimilarProducts(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonService\Api::class),
                        $serviceManager->get(AmazonService\Api\Product\Xml\DownloadToMySql::class),
                        $serviceManager->get(AmazonService\Api\SimilarProducts\Xml::class),
                        $serviceManager->get(AmazonService\Product::class),
                        $serviceManager->get(AmazonTable\Product::class),
                        $serviceManager->get(AmazonTable\Product\Similar::class),
                        $serviceManager->get(AmazonTable\Product\SimilarRetrieved::class)
                    );
                },
                AmazonService\Product\RootRelativeUrl::class => function ($serviceManager) {
                    return new AmazonService\Product\RootRelativeUrl(
                        $serviceManager->get(AmazonService\Product\ModifiedTitle::class),
                        $serviceManager->get(StringService\UrlFriendly::class)
                    );
                },
                AmazonService\Product\Slug::class => function ($serviceManager) {
                    return new AmazonService\Product\Slug(
                        $serviceManager->get(AmazonService\Product\ModifiedTitle::class),
                        $serviceManager->get(StringService\UrlFriendly::class)
                    );
                },
                AmazonService\Product\SourceCode::class => function ($serviceManager) {
                    return new AmazonService\Product\SourceCode();
                },
                AmazonService\Product\Tweet::class => function ($serviceManager) {
                    return new AmazonService\Product\Tweet(
                        $serviceManager->get(AmazonService\Product\Hashtags::class),
                        $serviceManager->get(AmazonService\Product\Url::class)
                    );
                },
                AmazonService\Product\Url::class => function ($serviceManager) {
                    return new AmazonService\Product\Url(
                        $serviceManager->get(AmazonService\Product\RootRelativeUrl::class)
                    );
                },
                AmazonService\ProductGroup::class => function ($serviceManager) {
                    return new AmazonService\ProductGroup(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonTable\ProductGroup::class)
                    );
                },
                AmazonService\ProductGroup\RelatedProductEntities::class => function ($serviceManager) {
                    return new AmazonService\ProductGroup\RelatedProductEntities(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonService\Product\ModifiedTitle::class),
                        $serviceManager->get(AmazonTable\Search\ProductGroup::class)
                    );
                },
                AmazonService\ProductGroup\RelatedProductEntities\NumberOfPages::class => function ($serviceManager) {
                    return new AmazonService\ProductGroup\RelatedProductEntities\NumberOfPages(
                        $serviceManager->get(AmazonService\Product\ModifiedTitle::class),
                        $serviceManager->get(AmazonTable\Search\ProductGroup::class)
                    );
                },
                AmazonService\ProductGroup\RandomProductEntity::class => function ($serviceManager) {
                    return new AmazonService\ProductGroup\RandomProductEntity(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonTable\Product\ProductId::class)
                    );
                },
                AmazonService\ProductImage\DownloadFile::class => function ($sm) {
                    return new AmazonService\ProductImage\DownloadFile();
                },
                AmazonService\ProductImage\ProductImages\DownloadFiles::class => function ($sm) {
                    return new AmazonService\ProductImage\ProductImages\DownloadFiles(
                        $sm->get(AmazonService\ProductImage\DownloadFile::class)
                    );
                },
                AmazonService\ProductHiResImage\ArrayFromSourceCode::class => function ($serviceManager) {
                    return new AmazonService\ProductHiResImage\ArrayFromSourceCode();
                },
                AmazonService\ProductHiResImage\DownloadHiResImages::class => function ($sm) {
                    return new AmazonService\ProductHiResImage\DownloadHiResImages();
                },
                AmazonService\ProductHiResImage\DownloadUrls::class => function ($sm) {
                    return new AmazonService\ProductHiResImage\DownloadUrls(
                        $sm->get(AmazonService\Product\SourceCode::class),
                        $sm->get(AmazonService\ProductHiResImage\ArrayFromSourceCode::class),
                        $sm->get(AmazonTable\ProductHiResImage::class)
                    );
                },
                AmazonService\ProductHiResImage\HiResImagesDownloaded::class => function ($sm) {
                    return new AmazonService\ProductHiResImage\HiResImagesDownloaded();
                },
                AmazonService\ProductVideo\Command::class => function ($sm) {
                    return new AmazonService\ProductVideo\Command();
                },
                AmazonService\ProductVideo\Everything::class => function ($sm) {
                    return new AmazonService\ProductVideo\Everything(
                        $sm->get(AmazonService\Product\HasImage::class),
                        $sm->get(AmazonService\ProductImage\ProductImages\DownloadFiles::class),
                        $sm->get(AmazonService\ProductVideo\Generate::class),
                        $sm->get(AmazonService\ProductVideo\Thumbnail\Generate::class),
                        $sm->get(AmazonTable\Product\VideoGenerated::class),
                        $sm->get(AmazonTable\ProductVideo::class),
                        $sm->get(VideoService\DurationMilliseconds::class)
                    );
                },
                AmazonService\ProductVideo\Generate::class => function ($sm) {
                    return new AmazonService\ProductVideo\Generate(
                        $sm->get(AmazonService\ProductVideo\Command::class),
                        $sm->get(AmazonService\ProductVideo\Generated::class)
                    );
                },
                AmazonService\ProductVideo\Generated::class => function ($sm) {
                    return new AmazonService\ProductVideo\Generated();
                },
                AmazonService\ProductVideo\ProductVideos::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos(
                        $sm->get(AmazonFactory\ProductVideo::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\Newest::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\Newest(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\NumberOfPages::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\NumberOfPages(
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\Similar::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\Similar(
                        $sm->get(AmazonFactory\ProductVideo::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\Thumbnail\Exists::class => function ($sm) {
                    return new AmazonService\ProductVideo\Thumbnail\Exists();
                },
                AmazonService\ProductVideo\Thumbnail\Generate::class => function ($sm) {
                    return new AmazonService\ProductVideo\Thumbnail\Generate();
                },
                AmazonService\Search\ProductGroup::class => function ($serviceManager) {
                    return new AmazonService\Search\ProductGroup(
                        $serviceManager->get(AmazonFactory\Product::class),
                        $serviceManager->get(AmazonFactory\ProductGroup::class),
                        $serviceManager->get(AmazonTable\ProductGroup::class),
                        $serviceManager->get(AmazonTable\Search\ProductGroup::class)
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
                AmazonTable\BrowseNode::class => function ($serviceManager) {
                    return new AmazonTable\BrowseNode(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\BrowseNodeProduct::class => function ($serviceManager) {
                    return new AmazonTable\BrowseNodeProduct(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product::class => function ($serviceManager) {
                    return new AmazonTable\Product(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\Asin::class => function ($serviceManager) {
                    return new AmazonTable\Product\Asin(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\EditorialReview::class => function ($serviceManager) {
                    return new AmazonTable\Product\EditorialReview(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\ProductFeature::class => function ($serviceManager) {
                    return new AmazonTable\ProductFeature(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\HashtagsRetrieved::class => function ($serviceManager) {
                    return new AmazonTable\Product\HashtagsRetrieved(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\HiResImagesRetrieved::class => function ($serviceManager) {
                    return new AmazonTable\Product\HiResImagesRetrieved(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\ProductGroupSimilarRetrievedCreated::class => function ($serviceManager) {
                    return new AmazonTable\Product\ProductGroupSimilarRetrievedCreated(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\ProductGroupVideoGeneratedCreated::class => function ($serviceManager) {
                    return new AmazonTable\Product\ProductGroupVideoGeneratedCreated(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\ProductId::class => function ($serviceManager) {
                    return new AmazonTable\Product\ProductId(
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
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\SimilarRetrieved::class => function ($serviceManager) {
                    return new AmazonTable\Product\SimilarRetrieved(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\SimilarRetrievedCreated::class => function ($serviceManager) {
                    return new AmazonTable\Product\SimilarRetrievedCreated(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Product\VideoGenerated::class => function ($serviceManager) {
                    return new AmazonTable\Product\VideoGenerated(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\ProductGroup::class => function ($serviceManager) {
                    return new AmazonTable\ProductGroup(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\ProductHashtag::class => function ($serviceManager) {
                    return new AmazonTable\ProductHashtag(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\ProductHiResImage::class => function ($sm) {
                    return new AmazonTable\ProductHiResImage(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductImage::class => function ($serviceManager) {
                    return new AmazonTable\ProductImage(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\Products::class => function ($serviceManager) {
                    return new AmazonTable\Products(
                        $serviceManager->get('amazon')
                    );
                },
                AmazonTable\ProductVideo::class => function ($sm) {
                    return new AmazonTable\ProductVideo(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductVideo\DurationMilliseconds::class => function ($sm) {
                    return new AmazonTable\ProductVideo\DurationMilliseconds(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Search\ProductGroup::class => function ($serviceManager) {
                    return new AmazonTable\Search\ProductGroup(
                        $serviceManager->get(MemcachedService\Memcached::class),
                        $serviceManager->get('amazon')
                    );
                },
            ],
        ];
    }
}
