<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class AwsV4Test extends TestCase
{
    protected function setUp()
    {
        $this->awsV4Entity = new AmazonEntity\Api\AwsV4(
            'access key',
            'secret key'
        );
    }

    public function testSetters()
    {
        $reflectionClass = new ReflectionClass($this->awsV4Entity);

        $path = 'path';
        $this->assertNull(
            $this->awsV4Entity->setPath($path)
        );
        $reflectionProperty = $reflectionClass->getProperty('path');
        $reflectionProperty->setAccessible(true);
        $this->assertSame(
            $path,
            $reflectionProperty->getValue($this->awsV4Entity)
        );
    }
}
