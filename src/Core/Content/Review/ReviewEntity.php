<?php
declare(strict_types=1);
namespace Inchoo\ReviewPlugin\Core\Content\Review;

use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\Language\LanguageEntity;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;

class ReviewEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var string
     */
    protected $salesChannelId;

    /**
     * @var string
     */
    protected $customerId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $reviewText;

    /**
     * @var int
     */
    protected $rating;

    /**
     * @var bool
     */
    protected $display;

    /**
     * @var LanguageEntity
     */
    protected $language;

    /**
     * @var SalesChannelEntity
     */
    protected $salesChannel;

    /**
     * @var CustomerEntity
     */
    protected $customer;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    /**
     * @param string $languageId
     */
    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    /**
     * @return string
     */
    public function getSalesChannelId(): string
    {
        return $this->salesChannelId;
    }

    /**
     * @param string $salesChannelId
     */
    public function setSalesChannelId(string $salesChannelId): void
    {
        $this->salesChannelId = $salesChannelId;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getReviewText(): string
    {
        return $this->reviewText;
    }

    /**
     * @param string $reviewText
     */
    public function setReviewText(string $reviewText): void
    {
        $this->reviewText = $reviewText;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return bool
     */
    public function isDisplay(): bool
    {
        return $this->display;
    }

    /**
     * @param bool $display
     */
    public function setDisplay(bool $display): void
    {
        $this->display = $display;
    }

    /**
     * @return LanguageEntity
     */
    public function getLanguage(): LanguageEntity
    {
        return $this->language;
    }

    /**
     * @param LanguageEntity $language
     */
    public function setLanguage(LanguageEntity $language): void
    {
        $this->language = $language;
    }

    /**
     * @return SalesChannelEntity
     */
    public function getSalesChannel(): SalesChannelEntity
    {
        return $this->salesChannel;
    }

    /**
     * @param SalesChannelEntity $salesChannel
     */
    public function setSalesChannel(SalesChannelEntity $salesChannel): void
    {
        $this->salesChannel = $salesChannel;
    }

    /**
     * @return CustomerEntity
     */
    public function getCustomer(): CustomerEntity
    {
        return $this->customer;
    }

    /**
     * @param CustomerEntity $customer
     */
    public function setCustomer(CustomerEntity $customer): void
    {
        $this->customer = $customer;
    }


}