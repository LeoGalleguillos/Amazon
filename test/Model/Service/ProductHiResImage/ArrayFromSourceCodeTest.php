<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ArrayFromSourceCodeTest extends TestCase
{
    protected function setUp()
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
    }
}
