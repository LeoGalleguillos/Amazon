<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\{
    Model\Table as AmazonTable,
    Model\Service as AmazonService
};
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    protected function setUp(): void
    {
        $this->apiTable = $this->createMock(AmazonTable\Api::class);
        $this->apiService = new AmazonService\Api(
            $this->apiTable
        );
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $this->assertNull(
            $this->apiService->insertOnDuplicateKeyUpdate('foo', 'bar')
        );
    }

    public function testWasAmazonApiCalledRecently()
    {
        $this->apiTable->method('selectValueWhereKey')->will(
            $this->onConsecutiveCalls(
                null,
                microtime(true),
                microtime(true) - 1,
                microtime(true) - 2,
                9999999999,
                1000000000
            )
        );

        $this->AssertFalse(
            $this->apiService->wasAmazonApiCalledRecently()
        );
        $this->AssertTrue(
            $this->apiService->wasAmazonApiCalledRecently()
        );
        $this->AssertTrue(
            $this->apiService->wasAmazonApiCalledRecently()
        );
        $this->AssertFalse(
            $this->apiService->wasAmazonApiCalledRecently()
        );
        $this->AssertTrue(
            $this->apiService->wasAmazonApiCalledRecently()
        );
        $this->AssertFalse(
            $this->apiService->wasAmazonApiCalledRecently()
        );
    }
}
