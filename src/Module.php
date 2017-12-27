<?php
namespace LeoGalleguillos\Amazon;

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
                AmazonTable\Api::class => function ($serviceManager) {
                    return new AmazonTable\Api(
                        $serviceManager->get('amazon')
                    );
                },
            ],
        ];
    }
}
