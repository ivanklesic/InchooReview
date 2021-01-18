<?php

namespace Inchoo\ReviewPlugin\Page\Review;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BrandDetailPageLoader
 * @package Inchoo\ReviewPlugin\Page\Review
 */
class ReviewPageLoader
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
     * @return ReviewPage
     */
    public function load(Request $request, SalesChannelContext $salesChannelContext): ReviewPage
    {
        $page = $this->genericLoader->load($request, $salesChannelContext);
        $page = ReviewPage::createFrom($page);

        if($salesChannelContext->getCustomer())
        {
            $criteria = new Criteria();

            $criteria->addFilter(
                new EqualsFilter('customerId', $salesChannelContext->getCustomer()->getId())
            )->addFilter(
                new EqualsFilter('languageId', $salesChannelContext->getContext()->getLanguageId())
            )->addFilter(
                new EqualsFilter('salesChannelId', $salesChannelContext->getSalesChannel()->getId())
            );
            $review = $this->reviewRepository->search(
                $criteria, $salesChannelContext->getContext()
            )->getEntities()->first();

            $page->setReview($review);
        }

        return $page;
    }

}