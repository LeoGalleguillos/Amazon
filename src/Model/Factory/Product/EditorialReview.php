<?php
namespace LeoGalleguillos\Amazon\Model\Factory\Product;

use SimpleXMLElement;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class EditorialReview
{
    public function buildFromArray($array)
    {
        $editorialReviewEntity          = new AmazonEntity\Product\EditorialReview();
        $editorialReviewEntity->source  = $array['source'];
        $editorialReviewEntity->content = $array['content'];
        return $editorialReviewEntity;
    }

    public function buildFromXml(SimpleXMLElement $xml)
    {
        $editorialReviewEntity          = new AmazonEntity\Product\EditorialReview();
        $editorialReviewEntity->source  = (string) $xml->{'Source'};
        $editorialReviewEntity->content = (string) $xml->{'Content'};
        return $editorialReviewEntity;
    }
}
