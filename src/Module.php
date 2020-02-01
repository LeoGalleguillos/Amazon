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
                    'productAffiliateUrl'           => AmazonHelper\Product\AffiliateUrl::class,
                    'productModifiedFeature'        => AmazonHelper\Product\ModifiedFeature::class,
                    'getBreadcrumbsHtml'            => AmazonHelper\Product\BreadcrumbsHtml::class,
                    'getBrowseNodeBreadcrumbsHtml'  => AmazonHelper\BrowseNode\BreadcrumbsHtml::class,
                    'getBrowseNodeRootRelativeUrl'  => AmazonHelper\BrowseNode\RootRelativeUrl::class,
                    'getModifiedTitle'              => AmazonHelper\Product\ModifiedTitle::class,
                    'getProductAffiliateUrl'        => AmazonHelper\Product\AffiliateUrl::class,
                    'getProductFirstImageEntity'    => AmazonHelper\Product\FirstImageEntity::class,
                    'getProductImages'              => AmazonHelper\ProductImage\ProductImages::class,
                    'getProductModifiedFeatures'    => AmazonHelper\Product\ModifiedFeatures::class,
                    'getProductRootRelativeUrl'     => AmazonHelper\Product\RootRelativeUrl::class,
                ],
                'factories' => [
                    AmazonHelper\BrowseNode\BreadcrumbsHtml::class => function ($sm) {
                        return new AmazonHelper\BrowseNode\BreadcrumbsHtml(
                            $sm->get(AmazonService\BrowseNode\BrowseNodes\Breadcrumbs::class),
                            $sm->get(StringService\Escape::class),
                            $sm->get(StringService\UrlFriendly::class)
                        );
                    },
                    AmazonHelper\BrowseNode\RootRelativeUrl::class => function ($sm) {
                        return new AmazonHelper\BrowseNode\RootRelativeUrl(
                            $sm->get(AmazonService\BrowseNode\RootRelativeUrl::class)
                        );
                    },
                    AmazonHelper\Product\AffiliateUrl::class => function ($sm) {
                        return new AmazonHelper\Product\AffiliateUrl();
                    },
                    AmazonHelper\Product\BreadcrumbsHtml::class => function ($sm) {
                        return new AmazonHelper\Product\BreadcrumbsHtml(
                            $sm->get('Config')['amazon']['browse-node-name-domain'],
                            $sm->get(AmazonService\Product\Breadcrumbs::class),
                            $sm->get(StringService\Escape::class),
                            $sm->get(StringService\UrlFriendly::class)
                        );
                    },
                    AmazonHelper\Product\FirstImageEntity::class => function ($sm) {
                        return new AmazonHelper\Product\FirstImageEntity(
                            $sm->get(AmazonService\Product\FirstImageEntity::class)
                        );
                    },
                    AmazonHelper\Product\ModifiedFeature::class => function ($sm) {
                        return new AmazonHelper\Product\ModifiedFeature();
                    },
                    AmazonHelper\Product\ModifiedFeatures::class => function ($sm) {
                        $viewHelperManager = $sm->get('ViewHelperManager');
                        return new AmazonHelper\Product\ModifiedFeatures(
                            $viewHelperManager->get(AmazonHelper\Product\ModifiedFeature::class)
                        );
                    },
                    AmazonHelper\Product\ModifiedTitle::class => function ($sm) {
                        return new AmazonHelper\Product\ModifiedTitle(
                            $sm->get(AmazonService\Product\ModifiedTitle::class)
                        );
                    },
                    AmazonHelper\Product\RootRelativeUrl::class => function ($sm) {
                        return new AmazonHelper\Product\RootRelativeUrl(
                            $sm->get(AmazonService\Product\RootRelativeUrl::class)
                        );
                    },
                    AmazonHelper\ProductImage\ProductImages::class => function ($sm) {
                        return new AmazonHelper\ProductImage\ProductImages(
                            $sm->get(AmazonService\ProductImage\ProductImages::class)
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
                AmazonFactory\Binding::class => function ($sm) {
                    return new AmazonFactory\Binding();
                },
                AmazonFactory\Brand::class => function ($sm) {
                    return new AmazonFactory\Brand();
                },
                AmazonFactory\BrowseNode::class => function ($sm) {
                    return new AmazonFactory\BrowseNode(
                        $sm->get(AmazonTable\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeHierarchy::class)
                    );
                },
                AmazonFactory\Product::class => function ($sm) {
                    return new AmazonFactory\Product(
                        $sm->get(AmazonFactory\Binding::class),
                        $sm->get(AmazonFactory\Brand::class),
                        $sm->get(AmazonFactory\ProductGroup::class),
                        $sm->get(ImageFactory\Image::class),
                        $sm->get(AmazonTable\Product::class),
                        $sm->get(AmazonTable\ProductFeature::class),
                        $sm->get(AmazonTable\ProductImage::class),
                        $sm->get(AmazonTable\ProductHiResImage::class)
                    );
                },
                AmazonFactory\Product\EditorialReview::class => function ($sm) {
                    return new AmazonFactory\Product\EditorialReview();
                },
                AmazonFactory\ProductGroup::class => function ($sm) {
                    return new AmazonFactory\ProductGroup(
                        $sm->get(AmazonTable\ProductGroup::class),
                        $sm->get(StringService\UrlFriendly::class)
                    );
                },
                AmazonFactory\ProductVideo::class => function ($sm) {
                    return new AmazonFactory\ProductVideo(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\Api::class => function ($sm) {
                    return new AmazonService\Api(
                        $sm->get(AmazonTable\Api::class)
                    );
                },
                AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class => function ($sm) {
                    return new AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray(
                        $sm->get(AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes\BrowseNodeArray::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class),
                        $sm->get(AmazonTable\Product\Asin::class)
                    );
                },
                AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes\BrowseNodeArray::class => function ($sm) {
                    return new AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes\BrowseNodeArray(
                        $sm->get(AmazonTable\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeHierarchy::class)
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
                        $sm->get(AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class),
                        $sm->get(AmazonTable\Product\Asin::class)
                    );
                },
                AmazonService\Api\Operations\GetItems\DownloadJsonToMySql::class => function ($sm) {
                    return new AmazonService\Api\Operations\GetItems\DownloadJsonToMySql(
                        $sm->get(AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class)
                    );
                },
                AmazonService\Api\Operations\GetItems\GetJsonAndDownloadJsonToMySql::class => function ($sm) {
                    return new AmazonService\Api\Operations\GetItems\GetJsonAndDownloadJsonToMySql(
                        $sm->get(AmazonService\Api\Operations\GetItems\DownloadJsonToMySql::class),
                        $sm->get(AmazonService\Api\Operations\GetItems\Json::class)
                    );
                },
                AmazonService\Api\Operations\GetItems\Json::class => function ($sm) {
                    $amazonConfig = $sm->get('Config')['amazon'];
                    return new AmazonService\Api\Operations\GetItems\Json(
                        $amazonConfig['associate_tag'],
                        $amazonConfig['access_key_id'],
                        $amazonConfig['secret_access_key']
                    );
                },
                AmazonService\Api\Product\Xml::class => function ($sm) {
                    $config = $sm->get('Config');
                    return new AmazonService\Api\Product\Xml(
                        $config['amazon']['access_key_id'],
                        $config['amazon']['associate_tag'],
                        $config['amazon']['secret_access_key']
                    );
                },
                AmazonService\Api\Product\Xml\DownloadToMySql::class => function ($sm) {
                    return new AmazonService\Api\Product\Xml\DownloadToMySql(
                        $sm->get(AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class),
                        $sm->get(AmazonTable\Product::class),
                        $sm->get(AmazonTable\ProductFeature::class),
                        $sm->get(AmazonTable\ProductImage::class)
                    );
                },
                AmazonService\Api\SimilarProducts\Xml::class => function ($sm) {
                    $config = $sm->get('Config');
                    return new AmazonService\Api\SimilarProducts\Xml(
                        $config['amazon']['access_key_id'],
                        $config['amazon']['associate_tag'],
                        $config['amazon']['secret_access_key']
                    );
                },
                AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class => function ($sm) {
                    return new AmazonService\Api\Xml\BrowseNode\DownloadToMySql(
                        $sm->get(AmazonTable\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeHierarchy::class)
                    );
                },
                AmazonService\Binding::class => function ($sm) {
                    return new AmazonService\Binding(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\Binding::class)
                    );
                },
                AmazonService\Brand::class => function ($sm) {
                    return new AmazonService\Brand(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\Brand::class)
                    );
                },
                AmazonService\BrowseNode\Name\NumberOfVideosNotGenerated::class => function ($sm) {
                    return new AmazonService\BrowseNode\Name\NumberOfVideosNotGenerated(
                        $sm->get(AmazonTable\ProductBrowseNodeProductBrowseNode::class)
                    );
                },
                AmazonService\BrowseNode\BrowseNodes::class => function ($sm) {
                    return new AmazonService\BrowseNode\BrowseNodes(
                        $sm->get(AmazonFactory\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNode::class)
                    );
                },
                AmazonService\BrowseNode\BrowseNodes\Breadcrumbs::class => function ($sm) {
                    return new AmazonService\BrowseNode\BrowseNodes\Breadcrumbs();
                },
                AmazonService\BrowseNode\BrowseNodes\BrowseNodeIds::class => function ($sm) {
                    return new AmazonService\BrowseNode\BrowseNodes\BrowseNodeIds(
                        $sm->get(AmazonService\BrowseNode\BrowseNodes::class)
                    );
                },
                AmazonService\BrowseNode\BrowseNodes\Product::class => function ($sm) {
                    return new AmazonService\BrowseNode\BrowseNodes\Product(
                        $sm->get(AmazonFactory\BrowseNode::class),
                        $sm->get(AmazonTable\BrowseNodeProduct::class)
                    );
                },
                AmazonService\BrowseNode\RootRelativeUrl::class => function ($sm) {
                    return new AmazonService\BrowseNode\RootRelativeUrl(
                        $sm->get(AmazonService\BrowseNode\BrowseNodes\Breadcrumbs::class),
                        $sm->get(StringService\UrlFriendly::class)
                    );
                },
                AmazonService\BrowseNodeNameDomain\Names::class => function ($sm) {
                    return new AmazonService\BrowseNodeNameDomain\Names(
                        $sm->get('Config')['amazon']['browse-node-name-domain']
                    );
                },
                AmazonService\Hashtag\Products\ProductGroup::class => function ($sm) {
                    return new AmazonService\Hashtag\Products\ProductGroup(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\ProductHashtag::class)
                    );
                },
                AmazonService\Product::class => function ($sm) {
                    return new AmazonService\Product(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonService\Api::class),
                        $sm->get(AmazonService\Api\Product\Xml::class),
                        $sm->get(AmazonService\Api\Product\Xml\DownloadToMySql::class),
                        $sm->get(AmazonTable\Product::class)
                    );
                },
                AmazonService\Product\Breadcrumbs::class => function ($sm) {
                    return new AmazonService\Product\Breadcrumbs(
                        $sm->get(AmazonService\BrowseNode\BrowseNodes\Breadcrumbs::class),
                        $sm->get(AmazonService\BrowseNode\BrowseNodes\Product::class)
                    );
                },
                AmazonService\Product\FirstImageEntity::class => function ($sm) {
                    return new AmazonService\Product\FirstImageEntity();
                },
                AmazonService\Product\Hashtags::class => function ($sm) {
                    return new AmazonService\Product\Hashtags(
                        $sm->get(AmazonService\Product\Hashtags\ProductEntity::class)
                    );
                },
                AmazonService\Product\Hashtags\Insert::class => function ($sm) {
                    return new AmazonService\Product\Hashtags\Insert(
                        $sm->get(AmazonTable\ProductHashtag::class),
                        $sm->get(HashtagService\Hashtag::class)
                    );
                },
                AmazonService\Product\Hashtags\ProductEntity::class => function ($sm) {
                    return new AmazonService\Product\Hashtags\ProductEntity();
                },
                AmazonService\Product\HasImage::class => function ($sm) {
                    return new AmazonService\Product\HasImage();
                },
                AmazonService\Product\ModifiedTitle::class => function ($sm) {
                    return new AmazonService\Product\ModifiedTitle();
                },
                AmazonService\Product\SimilarProducts::class => function ($sm) {
                    return new AmazonService\Product\SimilarProducts(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonService\Api::class),
                        $sm->get(AmazonService\Api\Product\Xml\DownloadToMySql::class),
                        $sm->get(AmazonService\Api\SimilarProducts\Xml::class),
                        $sm->get(AmazonService\Product::class),
                        $sm->get(AmazonTable\Product::class),
                        $sm->get(AmazonTable\Product\Similar::class),
                        $sm->get(AmazonTable\Product\SimilarRetrieved::class)
                    );
                },
                AmazonService\Product\RootRelativeUrl::class => function ($sm) {
                    return new AmazonService\Product\RootRelativeUrl(
                        $sm->get(AmazonService\Product\ModifiedTitle::class),
                        $sm->get(StringService\UrlFriendly::class)
                    );
                },
                AmazonService\Product\Slug::class => function ($sm) {
                    return new AmazonService\Product\Slug(
                        $sm->get(AmazonService\Product\ModifiedTitle::class),
                        $sm->get(StringService\UrlFriendly::class)
                    );
                },
                AmazonService\Product\SourceCode::class => function ($sm) {
                    return new AmazonService\Product\SourceCode();
                },
                AmazonService\Product\Tweet::class => function ($sm) {
                    return new AmazonService\Product\Tweet(
                        $sm->get(AmazonService\Product\Hashtags::class),
                        $sm->get(AmazonService\Product\Url::class)
                    );
                },
                AmazonService\Product\Url::class => function ($sm) {
                    return new AmazonService\Product\Url(
                        $sm->get(AmazonService\Product\RootRelativeUrl::class)
                    );
                },
                AmazonService\ProductGroup::class => function ($sm) {
                    return new AmazonService\ProductGroup(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\ProductGroup::class)
                    );
                },
                AmazonService\ProductGroup\RelatedProductEntities::class => function ($sm) {
                    return new AmazonService\ProductGroup\RelatedProductEntities(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonService\Product\ModifiedTitle::class),
                        $sm->get(AmazonTable\Search\ProductGroup::class)
                    );
                },
                AmazonService\ProductGroup\RelatedProductEntities\NumberOfPages::class => function ($sm) {
                    return new AmazonService\ProductGroup\RelatedProductEntities\NumberOfPages(
                        $sm->get(AmazonService\Product\ModifiedTitle::class),
                        $sm->get(AmazonTable\Search\ProductGroup::class)
                    );
                },
                AmazonService\ProductGroup\RandomProductEntity::class => function ($sm) {
                    return new AmazonService\ProductGroup\RandomProductEntity(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonTable\Product\ProductId::class)
                    );
                },
                AmazonService\ProductImage\DownloadFile::class => function ($sm) {
                    return new AmazonService\ProductImage\DownloadFile();
                },
                AmazonService\ProductImage\ProductImages::class => function ($sm) {
                    return new AmazonService\ProductImage\ProductImages();
                },
                AmazonService\ProductImage\ProductImages\DownloadFiles::class => function ($sm) {
                    return new AmazonService\ProductImage\ProductImages\DownloadFiles(
                        $sm->get(AmazonService\ProductImage\DownloadFile::class)
                    );
                },
                AmazonService\ProductHiResImage\ArrayFromSourceCode::class => function ($sm) {
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
                    return new AmazonService\ProductVideo\Command(
                        $sm->get(AmazonService\ProductVideo\RandomMp3Rru::class)
                    );
                },
                AmazonService\ProductVideo\Everything::class => function ($sm) {
                    return new AmazonService\ProductVideo\Everything(
                        $sm->get(AmazonService\Product\HasImage::class),
                        $sm->get(AmazonService\ProductImage\ProductImages\DownloadFiles::class),
                        $sm->get(AmazonService\ProductVideo\Generate::class),
                        $sm->get(AmazonService\ProductVideo\ProductGroupExcluded::class),
                        $sm->get(AmazonService\ProductVideo\Thumbnail\Generate::class),
                        $sm->get(AmazonTable\Product\VideoGenerated::class),
                        $sm->get(AmazonTable\ProductFeature::class),
                        $sm->get(AmazonTable\ProductVideo::class),
                        $sm->get(VideoService\DurationMilliseconds::class)
                    );
                },
                AmazonService\ProductVideo\Generate::class => function ($sm) {
                    return new AmazonService\ProductVideo\Generate(
                        $sm->get(AmazonService\ProductVideo\Command::class)
                    );
                },
                AmazonService\ProductVideo\ProductGroupExcluded::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductGroupExcluded();
                },
                AmazonService\ProductVideo\ProductVideos::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos(
                        $sm->get(AmazonFactory\ProductVideo::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode(
                        $sm->get(AmazonFactory\ProductVideo::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode\NumberOfVideos::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode\NumberOfVideos(
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode\Name::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode\Name(
                        $sm->get(AmazonFactory\ProductVideo::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NumberOfPages::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NumberOfPages(
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotIn::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotIn(
                        $sm->get(AmazonFactory\ProductVideo::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotInBrowseNodeNameDomainArray::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotInBrowseNodeNameDomainArray(
                        $sm->get(AmazonService\BrowseNodeNameDomain\Names::class),
                        $sm->get(AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotIn::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotInBrowseNodeNameDomainArray\NumberOfPages::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotInBrowseNodeNameDomainArray\NumberOfPages(
                        $sm->get(AmazonService\BrowseNodeNameDomain\Names::class),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonService\ProductVideo\ProductVideos\Newest::class => function ($sm) {
                    return new AmazonService\ProductVideo\ProductVideos\Newest(
                        $sm->get(AmazonFactory\ProductVideo::class),
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
                        $sm->get(AmazonTable\ProductVideo::class),
                        $sm->get(StringService\KeepFirstWords::class)
                    );
                },
                AmazonService\ProductVideo\RandomMp3Rru::class => function ($sm) {
                    return new AmazonService\ProductVideo\RandomMp3Rru();
                },
                AmazonService\ProductVideo\Thumbnail\Exists::class => function ($sm) {
                    return new AmazonService\ProductVideo\Thumbnail\Exists();
                },
                AmazonService\ProductVideo\Thumbnail\Generate::class => function ($sm) {
                    return new AmazonService\ProductVideo\Thumbnail\Generate();
                },
                AmazonService\ProductVideo\Views\Increment::class => function ($sm) {
                    return new AmazonService\ProductVideo\Views\Increment(
                        $sm->get(AmazonTable\ProductVideo\ProductVideoId::class)
                    );
                },
                AmazonService\Search\ProductGroup::class => function ($sm) {
                    return new AmazonService\Search\ProductGroup(
                        $sm->get(AmazonFactory\Product::class),
                        $sm->get(AmazonFactory\ProductGroup::class),
                        $sm->get(AmazonTable\ProductGroup::class),
                        $sm->get(AmazonTable\Search\ProductGroup::class)
                    );
                },
                AmazonTable\Api::class => function ($sm) {
                    return new AmazonTable\Api(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Binding::class => function ($sm) {
                    return new AmazonTable\Binding(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Brand::class => function ($sm) {
                    return new AmazonTable\Brand(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\BrowseNode::class => function ($sm) {
                    return new AmazonTable\BrowseNode(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\BrowseNodeHierarchy::class => function ($sm) {
                    return new AmazonTable\BrowseNodeHierarchy(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\BrowseNodeProduct::class => function ($sm) {
                    return new AmazonTable\BrowseNodeProduct(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\BrowseNodeProduct\BrowseNodeId::class => function ($sm) {
                    return new AmazonTable\BrowseNodeProduct\BrowseNodeId(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product::class => function ($sm) {
                    return new AmazonTable\Product(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\Asin::class => function ($sm) {
                    return new AmazonTable\Product\Asin(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\EditorialReview::class => function ($sm) {
                    return new AmazonTable\Product\EditorialReview(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductBrowseNodeProductBrowseNode::class => function ($sm) {
                    return new AmazonTable\ProductBrowseNodeProductBrowseNode(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductFeature::class => function ($sm) {
                    return new AmazonTable\ProductFeature(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\HiResImagesRetrieved::class => function ($sm) {
                    return new AmazonTable\Product\HiResImagesRetrieved(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\ProductGroupSimilarRetrievedCreated::class => function ($sm) {
                    return new AmazonTable\Product\ProductGroupSimilarRetrievedCreated(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\ProductGroupVideoGeneratedCreated::class => function ($sm) {
                    return new AmazonTable\Product\ProductGroupVideoGeneratedCreated(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\ProductId::class => function ($sm) {
                    return new AmazonTable\Product\ProductId(
                        $sm->get('amazon'),
                        $sm->get(AmazonTable\Product::class)
                    );
                },
                AmazonTable\Product\Review::class => function ($sm) {
                    return new AmazonTable\Product\Review(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\Search::class => function ($sm) {
                    return new AmazonTable\Product\Search(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\Similar::class => function ($sm) {
                    return new AmazonTable\Product\Similar(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\SimilarRetrieved::class => function ($sm) {
                    return new AmazonTable\Product\SimilarRetrieved(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\SimilarRetrievedCreated::class => function ($sm) {
                    return new AmazonTable\Product\SimilarRetrievedCreated(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Product\VideoGenerated::class => function ($sm) {
                    return new AmazonTable\Product\VideoGenerated(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductGroup::class => function ($sm) {
                    return new AmazonTable\ProductGroup(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductHashtag::class => function ($sm) {
                    return new AmazonTable\ProductHashtag(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductHiResImage::class => function ($sm) {
                    return new AmazonTable\ProductHiResImage(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductImage::class => function ($sm) {
                    return new AmazonTable\ProductImage(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Products::class => function ($sm) {
                    return new AmazonTable\Products(
                        $sm->get('amazon')
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
                AmazonTable\ProductVideo\Modified::class => function ($sm) {
                    return new AmazonTable\ProductVideo\Modified(
                        $sm->get('amazon'),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonTable\ProductVideo\ProductGroup::class => function ($sm) {
                    return new AmazonTable\ProductVideo\ProductGroup(
                        $sm->get('amazon'),
                        $sm->get(AmazonTable\ProductVideo::class)
                    );
                },
                AmazonTable\ProductVideo\ProductId::class => function ($sm) {
                    return new AmazonTable\ProductVideo\ProductId(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\ProductVideo\ProductVideoId::class => function ($sm) {
                    return new AmazonTable\ProductVideo\ProductVideoId(
                        $sm->get('amazon')
                    );
                },
                AmazonTable\Search\ProductGroup::class => function ($sm) {
                    return new AmazonTable\Search\ProductGroup(
                        $sm->get(MemcachedService\Memcached::class),
                        $sm->get('amazon')
                    );
                },
            ],
        ];
    }
}
