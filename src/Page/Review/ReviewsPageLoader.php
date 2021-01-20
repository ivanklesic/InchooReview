<?php

namespace Inchoo\ReviewPlugin\Page\Review;

use Inchoo\ReviewPlugin\Core\Content\Review\ReviewCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReviewsPageLoader
 * @package Inchoo\ReviewPlugin\Page\Review
 */
class ReviewsPageLoader
{
    /**
     * @var GenericPageLoaderInterface
     */
    private $genericLoader;

    /**
     * @var EntityRepositoryInterface
     */
    private $reviewRepository;

    /**
     * BrandDetailPageLoader constructor.
     * @param GenericPageLoaderInterface $genericLoader
     * @param EntityRepositoryInterface $entityRepository
     */
    public function __construct(
        GenericPageLoaderInterface $genericLoader,
        EntityRepositoryInterface $entityRepository
    )
    {
        $this->genericLoader = $genericLoader;
        $this->reviewRepository = $entityRepository;
    }

    /**
     * @param Request $request
     * @param SalesChannelContext $salesChannelContext
     * @return ReviewsPage
     */
    public function load(Request $request, SalesChannelContext $salesChannelContext): ReviewsPage
    {
        $page = $this->genericLoader->load($request, $salesChannelContext);
        $page = ReviewsPage::createFrom($page);

        if($salesChannelContext->getCustomer())
        {
            $criteria = new Criteria();

            $criteria->addFilter(
                new EqualsFilter('display', true)
            )->addFilter(
                new EqualsFilter('languageId', $salesChannelContext->getContext()->getLanguageId())
            )->addFilter(
                new EqualsFilter('salesChannelId', $salesChannelContext->getSalesChannel()->getId())
            );

            /** @var ReviewCollection $reviews */
            $reviews = $this->reviewRepository->search(
                $criteria, $salesChannelContext->getContext()
            )->getEntities();

            $page->setReviews($reviews);
        }

        return $page;
    }

}