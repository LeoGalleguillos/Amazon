<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class BrowseNodeProductsHtmlTest extends TestCase
{
    protected function setUp()
    {
        $this->breadcrumbsHtmlHelperMock = $this->createMock(
            AmazonHelper\BrowseNodeProduct\BreadcrumbsHtml::class
        );
        $this->browseNodeProductsServiceMock = $this->createMock(
            AmazonService\Product\BrowseNodeProducts::class
        );

        $this->breadcrumbsHtmlHelper = new AmazonHelper\Product\BrowseNodeProductsHtml(
            $this->breadcrumbsHtmlHelperMock,
            $this->browseNodeProductsServiceMock
        );
    }

    /**
     * @todo Update unit test so that meaningful HTML is returned.
     */
    public function testInvoke()
    {
        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            '',
            $this->breadcrumbsHtmlHelper->__invoke($productEntity)
        );
    }
}
