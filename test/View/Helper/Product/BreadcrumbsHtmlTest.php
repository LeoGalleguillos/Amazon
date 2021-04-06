<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class BreadcrumbsHtmlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->browseNodeNameDomains = [
            'default' => 'www.example.com',
            'Browse Node Name' => 'www.example.com',
        ];
        $this->breadcrumbsServiceMock = $this->createMock(
            AmazonService\Product\Breadcrumbs::class
        );
        $this->escapeService = new StringService\Escape();
        $this->urlFriendlyServiceMock = $this->createMock(
            StringService\UrlFriendly::class
        );

        $this->breadcrumbsHtmlHelper = new AmazonHelper\Product\BreadcrumbsHtml(
            $this->browseNodeNameDomains,
            $this->breadcrumbsServiceMock,
            $this->escapeService,
            $this->urlFriendlyServiceMock
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
    }
}
