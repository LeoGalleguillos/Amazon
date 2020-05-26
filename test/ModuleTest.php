<?php
namespace LeoGalleguillos\AmazonTest;

use LeoGalleguillos\Amazon\Module;
use LeoGalleguillos\Test\ModuleTestCase;

class ModuleTest extends ModuleTestCase
{
    protected function setUp(): void
    {
        $this->module = new Module();
    }
}
