<?php


namespace Inchoo\ReviewPlugin\Page\Review;

use Inchoo\ReviewPlugin\Core\Content\Review\ReviewCollection;
use Shopware\Storefront\Page\Page;

/**
 * Class ReviewsPage
 * @package Inchoo\ReviewPlugin\Page\Review
 */
class ReviewsPage extends Page
{
    /**
     * @var ReviewCollection
     */
    private $reviews;

    /**
     * @return ?ReviewCollection
     */
    public function getReviews(): ?ReviewCollection
    {
        return $this->reviews;
    }

    /**
     * @param ?ReviewCollection $reviews
     */
    public function setReviews(?ReviewCollection $reviews): void
    {
        $this->reviews = $reviews;
    }
}