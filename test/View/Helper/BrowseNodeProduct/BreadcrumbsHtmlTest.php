<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\BrowseNodeProduct;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use Zend\View\Helper\AbstractHelper;
use PHPUnit\Framework\TestCase;

class BreadcrumbsHtmlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->breadcrumbsServiceMock = $this->createMock(
            AmazonService\BrowseNode\BrowseNodes\Breadcrumbs::class
        );
        $this->browseNodeNameDomains = [
            'default' => 'www.example.com',
            'Browse Node Name' => 'www.example.com',
        ];
        $this->escapeService = new StringService\Escape();
        $this->urlFriendlyService = new StringService\UrlFriendly();

        $this->breadcrumbsHtmlHelper = new AmazonHelper\BrowseNodeProduct\BreadcrumbsHtml(
            $this->breadcrumbsServiceMock,
            $this->browseNodeNameDomains,
            $this->escapeService,
            $this->urlFriendlyService
        );
    }

    /**
     * @todo Update unit test so that meaningful HTML is returned.
     */
    public function testInvoke()
    {
        $browseNodeProductEntity = new AmazonEntity\BrowseNodeProduct();
        $browseNodeProductEntity->setBrowseNode(
            new AmazonEntity\BrowseNode()
        );

        $breadcrumbsHtml = $this->breadcrumbsHtmlHelper->__invoke(
            $browseNodeProductEntity
        );

        $this->assertIsString(
            $breadcrumbsHtml
        );
    }
}
