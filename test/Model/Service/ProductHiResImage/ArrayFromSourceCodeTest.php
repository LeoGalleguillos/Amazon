<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ArrayFromSourceCodeTest extends TestCase
{
    protected function setUp(): void
    {
        $this->arrayFromSourceCodeService = new AmazonService\ProductHiResImage\ArrayFromSourceCode();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductHiResImage\ArrayFromSourceCode::class,
            $this->arrayFromSourceCodeService
        );
    }

    public function testGetArrayFromSourceCode()
    {
        $sourceCode = file_get_contents($_SERVER['PWD'] . '/test/source-code.html');
        $array = [
            'https://images-na.ssl-images-amazon.com/images/I/81hiYI6JdoL._UL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/81yCfOQxeaL._UL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/81kOX6gNkYL._UL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/81Ah3pORmUL._UL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/81sL2Lls7RL._UL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/61WFdzhxGfL._UL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/71ieMBsp3YL._UL1500_.jpg',
        ];
        $this->assertSame(
            $array,
            $this->arrayFromSourceCodeService->getArrayFromSourceCode($sourceCode)
        );

        $sourceCode = file_get_contents($_SERVER['PWD'] . '/test/B07L4FQ9HK.html');
        $array = [
            'https://images-na.ssl-images-amazon.com/images/I/61on2ud7alL._SL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/81P%2B6AUBuML._SL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/710YDiJ9gyL._SL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/712GvhsiBOL._SL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/7175qdjfEzL._SL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/71LHVy67PrL._SL1500_.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/71ua8I6xS9L._SL1500_.jpg',
        ];
        $this->assertSame(
            $array,
            $this->arrayFromSourceCodeService->getArrayFromSourceCode($sourceCode)
        );
    }
}
