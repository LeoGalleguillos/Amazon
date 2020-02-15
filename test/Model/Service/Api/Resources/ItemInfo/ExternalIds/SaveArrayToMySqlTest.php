<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ExternalIds;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->saveEansArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ExternalIds\Eans\SaveArrayToMySql::class
        );
        $this->saveExternalIdsArrayService = new AmazonService\Api\Resources\ItemInfo\ExternalIds\SaveArrayToMySql(
            $this->saveEansArrayToMySqlServiceMock
        );
    }

    public function testSaveArrayToMySqlWithEans()
    {
        $this->saveEansArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with(
                $this->getExternalIdsArrayWithEans()['EANs'],
                12345
            );

        $this->saveExternalIdsArrayService->saveArrayToMySql(
            $this->getExternalIdsArrayWithEans(),
            12345
        );
    }

    public function testSaveArrayToMySqlWithoutEans()
    {
        $this->saveEansArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');

        $this->saveExternalIdsArrayService->saveArrayToMySql(
            $this->getExternalIdsArrayWithoutEans(),
            12345
        );
    }

    protected function getExternalIdsArrayWithEans(): array
    {
      return
        array (
          'EANs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '3609740155567',
              1 => '0647684811968',
              2 => '5033588037965',
              3 => '5033588030737',
            ),
            'Label' => 'EAN',
            'Locale' => 'en_US',
          ),
          'UPCs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '019862511203',
            ),
            'Label' => 'UPC',
            'Locale' => 'en_US',
          ),
      );
    }

    protected function getExternalIdsArrayWithoutEans(): array
    {
      return
        array (
          'UPCs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '123456789012',
            ),
            'Label' => 'UPC',
            'Locale' => 'en_US',
          ),
      );
    }
}
