<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class BreadcrumbsHtmlTest extends TestCase
{
    protected function setUp()
    {
        $this->breadcrumbsServiceMock = $this->createMock(
            AmazonService\BrowseNode\BrowseNodes\Breadcrumbs::class
        );
        $this->productServiceMock = $this->createMock(
            AmazonService\BrowseNode\BrowseNodes\Product::class
        );
        $this->domain = 'www.example.com';
        $this->escapeService = new StringService\Escape();
        $this->urlFriendlyService = new StringService\UrlFriendly();

        $this->breadcrumbsHtmlHelper = new AmazonHelper\Product\BreadcrumbsHtml(
            $this->breadcrumbsServiceMock,
            $this->productServiceMock,
            $this->domain,
            $this->escapeService,
            $this->urlFriendlyService
        );
    }

    public function testInvoke()
    {
        $productEntity = new AmazonEntity\Product();

        try {
            $breadcrumbsHtml = $this->breadcrumbsHtmlHelper->__invoke(
                $productEntity
            );
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'No browse nodes found for product.',
                $exception->getMessage()
            );
        }

        $this->assertTrue(true);
    }
}
