<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\BrowseNodeInfo;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->saveBrowseNodeArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\BrowseNodes\BrowseNode\SaveArrayToMySql::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\BrowseNodeInfo\SaveArrayToMySql(
            $this->saveBrowseNodeArrayToMySqlServiceMock,
            $this->browseNodeProductTableMock
        );
    }

    public function testSaveArrayToMySql()
    {
        $this->saveBrowseNodeArrayToMySqlServiceMock
            ->expects($this->exactly(2))
            ->method('saveArrayToMySql')
            ->withConsecutive(
                [$this->getArray()['BrowseNodes'][0]],
                [$this->getArray()['BrowseNodes'][1]]
            );

        $this->browseNodeProductTableMock
            ->expects($this->exactly(2))
            ->method('insertOnDuplicateKeyUpdate')
            ->withConsecutive(
                [493964, 12345, null, 1],
                [17386948011, 12345, 7, 2]
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getArray(),
            12345
        );
    }

    protected function getArray(): array
    {
        return array (
          'BrowseNodes' =>
          array (
            0 =>
            array (
              'Ancestor' =>
              array (
                'ContextFreeName' => 'Electronics',
                'DisplayName' => 'Electronics',
                'Id' => '172282',
              ),
              'ContextFreeName' => 'Electronics',
              'DisplayName' => 'Categories',
              'Id' => '493964',
              'IsRoot' => false,
            ),
            1 =>
            array (
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
            ),
          ),
        );
    }
}
