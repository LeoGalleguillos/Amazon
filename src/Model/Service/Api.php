<?php
namespace LeoGalleguillos\Amazon\Model\Service;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Api
{
    /**
     * @var bool
     */
    const GET_NEW_PRODUCTS = true;

    public function __construct(AmazonTable\Api $amazonApiTable)
    {
        $this->amazonApiTable = $amazonApiTable;
    }

    /**
     * Insert on duplicate key update.
     */
    public function insertOnDuplicateKeyUpdate($key, $value)
    {
        $this->amazonApiTable->insertOnDuplicateKeyUpdate($key, $value);
    }

    /**
     * Was Amazon API called recently.
     *
     * @return bool
     */
    public function wasAmazonApiCalledRecently()
    {
        $lastCallMicrotime = $this->amazonApiTable->selectValueWhereKey('last_call_microtime');

        return (microtime(true) - $lastCallMicrotime) < 1.5;
    }
}
