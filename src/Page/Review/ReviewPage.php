<?php


namespace Inchoo\ReviewPlugin\Page\Review;

use Inchoo\ReviewPlugin\Core\Content\Review\ReviewEntity;
use Shopware\Storefront\Page\Page;

/**
 * Class ReviewPage
 * @package Inchoo\ReviewPlugin\Page\Review
 */
class ReviewPage extends Page
{
    /**
     * @var ReviewEntity
     */
    private $review;

    /**
     * @return ReviewEntity
     */
    public function getReview(): ?ReviewEntity
    {
        return $this->review;
    }

    /**
     * @param ReviewEntity $review
     */
    public function setReview(?ReviewEntity $review): void
    {
        $this->review = $review;
    }
}