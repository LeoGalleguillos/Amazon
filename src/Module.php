<?php
namespace LeoGalleguillos\Amazon;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AmazonService\Api::class => function ($serviceManager) {
                    return new AmazonService\Api(
                        $serviceManager->get(AmazonTable\Api::class)
                    );
                },
                AmazonTable\Api::class => function ($serviceManager) {
                    return new AmazonTable\Api(
                        $serviceManager->get('amazon')
                    );
                },
            ],
        ];
    }
}
