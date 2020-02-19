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
        $this->saveIsbnsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ExternalIds\Isbns\SaveArrayToMySql::class
        );
        $this->saveUpcsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ExternalIds\Upcs\SaveArrayToMySql::class
        );
        $this->saveExternalIdsArrayService = new AmazonService\Api\Resources\ItemInfo\ExternalIds\SaveArrayToMySql(
            $this->saveEansArrayToMySqlServiceMock,
            $this->saveIsbnsArrayToMySqlServiceMock,
            $this->saveUpcsArrayToMySqlServiceMock
        );
    }

    public function testSaveEmptyArrayToMySql()
    {
        $productId = rand(1, 1000000);

        $this->saveEansArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql')
            ;
        $this->saveIsbnsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql')
            ;
        $this->saveUpcsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql')
            ;

        $this->saveExternalIdsArrayService->saveArrayToMySql(
            $this->getEmptyExternalIdsArray(),
            $productId
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
        $this->saveIsbnsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql')
            ;
        $this->saveUpcsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql')
            ;

        $this->saveExternalIdsArrayService->saveArrayToMySql(
            $this->getExternalIdsArrayWithEans(),
            12345
        );
    }

    public function testSaveArrayToMySqlWithIsbnsAndUpcs()
    {
        $this->saveEansArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');
        $this->saveIsbnsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with(
                $this->getExternalIdsArrayWithIsbnsAndUpcs()['ISBNs'],
                12345
            );
        $this->saveUpcsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with(
                $this->getExternalIdsArrayWithIsbnsAndUpcs()['UPCs'],
                12345
            );

        $this->saveExternalIdsArrayService->saveArrayToMySql(
            $this->getExternalIdsArrayWithIsbnsAndUpcs(),
            12345
        );
    }

    public function testSaveArrayToMySqlWithEansAndUpcs()
    {
        $productId = rand(1, 1000000);

        $this->saveEansArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with(
                $this->getExternalIdsArrayWithEansAndUpcs()['EANs'],
                $productId
            );
        $this->saveIsbnsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');
        $this->saveUpcsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with(
                $this->getExternalIdsArrayWithEansAndUpcs()['UPCs'],
                $productId
            );

        $this->saveExternalIdsArrayService->saveArrayToMySql(
            $this->getExternalIdsArrayWithEansAndUpcs(),
            $productId
        );
    }

    protected function getEmptyExternalIdsArray(): array
    {
        return array();
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
      );
    }

    protected function getExternalIdsArrayWithEansAndUpcs(): array
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
              0 => '123456789012',
              1 => '123456789013',
            ),
            'Label' => 'UPC',
            'Locale' => 'en_US',
          ),
      );
    }

    protected function getExternalIdsArrayWithIsbnsAndUpcs(): array
    {
      return
        array (
          'ISBNs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '0060935464',
              1 => '0037485960',
            ),
            'Label' => 'UPC',
            'Locale' => 'en_US',
          ),
          'UPCs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '123456789012',
              1 => '123456789013',
            ),
            'Label' => 'UPC',
            'Locale' => 'en_US',
          ),
      );
    }
}
