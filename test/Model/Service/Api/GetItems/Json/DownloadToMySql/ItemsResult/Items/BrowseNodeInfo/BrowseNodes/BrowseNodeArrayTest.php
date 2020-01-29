<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};
use PHPUnit\Framework\TestCase;

class BrowseNodeArrayTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeTableMock = $this->createMock(
            AmazonTable\BrowseNode::class
        );
        $this->browseNodeHierarchyTableMock = $this->createMock(
            AmazonTable\BrowseNodeHierarchy::class
        );
        $this->browseNodeArrayService = new AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes\BrowseNodeArray(
            $this->browseNodeTableMock,
            $this->browseNodeHierarchyTableMock
        );
    }

    public function testDownloadToMySql()
    {
        $this->browseNodeTableMock
            ->expects($this->exactly(4))
            ->method('insertIgnore')
            ->withConsecutive(
                [17386948011, 'Home Security from Amazon'],
                [2102313011, 'Amazon Devices'],
                [16333373011, 'Categories'],
                [16333372011, 'Amazon Devices & Accessories']
            );

        $this->browseNodeHierarchyTableMock
            ->expects($this->exactly(3))
            ->method('insertIgnore')
            ->withConsecutive(
                [2102313011, 17386948011],
                [16333373011, 2102313011],
                [16333372011, 16333373011]
            );

        $this->browseNodeArrayService->downloadToMySql(
            $this->getArray()
        );
    }

    protected function getArray(): array
    {
        return array (
          'Ancestor' =>
          array (
            'Ancestor' =>
            array (
              'Ancestor' =>
              array (
                'ContextFreeName' => 'Amazon Devices & Accessories',
                'DisplayName' => 'Amazon Devices & Accessories',
                'Id' => '16333372011',
              ),
              'ContextFreeName' => 'Categories',
              'DisplayName' => 'Categories',
              'Id' => '16333373011',
            ),
            'ContextFreeName' => 'Amazon Devices',
            'DisplayName' => 'Amazon Devices',
            'Id' => '2102313011',
          ),
          'ContextFreeName' => 'Home Security from Amazon',
          'DisplayName' => 'Home Security from Amazon',
          'Id' => '17386948011',
          'IsRoot' => false,
          'SalesRank' => 7,
        );
    }
}
