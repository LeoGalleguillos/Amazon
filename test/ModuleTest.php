<?php
namespace LeoGalleguillos\AmazonTest;

use LeoGalleguillos\Amazon\Module;
use PHPUnit\Framework\TestCase;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

class ModuleTest extends TestCase
{
    protected function setUp()
    {
        $this->module = new Module();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Module::class, $this->module);
    }

    public function testGetServiceConfig()
    {
        $applicationConfig = include(__DIR__ . '/../config/application.config.php');
        $this->application = Application::init($applicationConfig);

        $serviceConfig     = $this->module->getServiceConfig();
        $serviceManager    = $this->application->getServiceManager();

        foreach ($serviceConfig['factories'] as $className => $value) {
            $this->assertInstanceOf(
                $className,
                $serviceManager->get($className)
            );
        }
    }
}
