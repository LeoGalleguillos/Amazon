<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use Exception;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    protected function setUp(): void
    {
        $this->resultHydrator = new TestHydrator\CountableIterator();

        $this->browseNodeTableMock = $this->createMock(
            AmazonTable\BrowseNode::class
        );

        $this->nameService = new AmazonService\Product\BrowseNode\First\Name(
            $this->browseNodeTableMock
        );
    }

    public function test_getFirstBrowseNodeName_emptyProduct_throwException()
    {
        $this->expectException(Exception::class);

        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);

        $resultMock = $this->createMock(
            Result::class
        );
        $this->resultHydrator->hydrate(
            $resultMock,
            []
        );

        $this->browseNodeTableMock
            ->method('selectNameWhereProductIdLimit1')
            ->willReturn($resultMock);

        $this->nameService->getFirstBrowseNodeName($productEntity);
    }

    public function test_getFirstBrowseNodeName_oneResult_name()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);

        $resultMock = $this->createMock(
            Result::class
        );
        $this->resultHydrator->hydrate(
            $resultMock,
            [
                [
                    'name' => 'Browse Node Name',
                ],
            ]
        );

        $this->browseNodeTableMock
            ->method('selectNameWhereProductIdLimit1')
            ->willReturn($resultMock);

        $this->assertSame(
            'Browse Node Name',
            $this->nameService->getFirstBrowseNodeName($productEntity)
        );
    }

    public function test_getFirstBrowseNodeName_emptyBrowseNodeProducts_throwException()
    {
        $this->expectException(Exception::class);

        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);
        $productEntity->setBrowseNodeProducts([]);

        $this->nameService->getFirstBrowseNodeName($productEntity);
    }

    public function test_getFirstBrowseNodeName_browseNodeProducts_name()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);

        $browseNodeProductEntity1 = new AmazonEntity\BrowseNodeProduct();
        $browseNodeProductEntity1->setBrowseNode(
            (new AmazonEntity\BrowseNode())->setName('First Browse Node')
        );
        $browseNodeProductEntity2 = new AmazonEntity\BrowseNodeProduct();
        $browseNodeProductEntity2->setBrowseNode(
            (new AmazonEntity\BrowseNode())->setName('Second Browse Node')
        );

        $productEntity->setBrowseNodeProducts([
            $browseNodeProductEntity1,
            $browseNodeProductEntity2,
        ]);

        $this->assertSame(
            'First Browse Node',
            $this->nameService->getFirstBrowseNodeName($productEntity)
        );
    }
}
