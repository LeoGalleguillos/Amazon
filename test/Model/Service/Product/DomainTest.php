<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    protected function setUp()
    {
        $this->nameServiceMock = $this->createMock(
            AmazonService\Product\BrowseNode\First\Name::class
        );
        $this->browseNodeNameDomainArray = [
            'default' => 'www.example.com',
            'Rich'    => 'product.tube',
            'Wealth'  => 'www.monthlybasis.com',
        ];

        $this->domainService = new AmazonService\Product\Domain(
            $this->nameServiceMock,
            $this->browseNodeNameDomainArray
        );
    }

    public function test_getDomain_nameServiceThrowsException_defaultDomain()
    {
        $this->nameServiceMock
            ->method('getFirstBrowseNodeName')
            ->willThrowException(new Exception());

        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            $this->browseNodeNameDomainArray['default'],
            $this->domainService->getDomain($productEntity)
        );
    }

    public function test_getDomain_nameExistsInArray_returnNonDefaultDomain()
    {
        $this->nameServiceMock
            ->method('getFirstBrowseNodeName')
            ->willReturn('Wealth');

        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            $this->browseNodeNameDomainArray['Wealth'],
            $this->domainService->getDomain($productEntity)
        );
    }

    public function test_getDomain_nameDoesNotExistInArray_returnDefaultDomain()
    {
        $this->nameServiceMock
            ->method('getFirstBrowseNodeName')
            ->willReturn('Innovation');

        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            $this->browseNodeNameDomainArray['default'],
            $this->domainService->getDomain($productEntity)
        );
    }
}
