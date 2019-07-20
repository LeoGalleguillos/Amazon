<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class RandomMp3RruTest extends TestCase
{
    protected function setUp()
    {
        $this->randomMp3RruService = new AmazonService\ProductVideo\RandomMp3Rru();
    }

    public function testGetRandomMp3Rru()
    {
        $randomMp3Rru = $this->randomMp3RruService->getRandomMp3Rru();
        $this->assertInternalType(
            'string',
            $randomMp3Rru
        );
    }
}
