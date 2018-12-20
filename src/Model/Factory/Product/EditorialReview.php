<?php
namespace LeoGalleguillos\Amazon\Model\Factory\Product;

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
}
