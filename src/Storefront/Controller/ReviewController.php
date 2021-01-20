<?php

namespace Inchoo\ReviewPlugin\Storefront\Controller;

use Inchoo\ReviewPlugin\Page\Review\ReviewPageLoader;
use Inchoo\ReviewPlugin\Page\Review\ReviewsPageLoader;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Routing\Annotation\LoginRequired;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class ReviewController extends StorefrontController
{

    private $reviewPageLoader;

    private $reviewsPageLoader;

    /**
     * @var EntityRepositoryInterface
     */
    private $reviewRepository;

    public function __construct(ReviewPageLoader $reviewPageLoader, ReviewsPageLoader $reviewsPageLoader, EntityRepositoryInterface $entityRepository)
    {
        $this->reviewPageLoader = $reviewPageLoader;
        $this->reviewsPageLoader = $reviewsPageLoader;
        $this->reviewRepository = $entityRepository;
    }

    /**
     * @Route("/review/index", name="frontend.review.index", methods={"GET"})
     * @param Request $request
     * @param SalesChannelContext $context
     * @return Response
     */
    public function indexAction(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->reviewPageLoader->load($request, $context);

        if(!$context->getCustomer())
        {
            return $this->redirectToRoute('frontend.account.login');
        }

        return $this->renderStorefront('@Inchoo/storefront/component/review/index.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/review/create", name="frontend.review.create", methods={"POST"})
     * @param Request $request
     * @param SalesChannelContext $context
     * @return Response
     */
    public function createAction(Request $request, SalesChannelContext $context): Response
    {
        if(!$context->getCustomer())
        {
            return $this->redirectToRoute('frontend.account.login');
        }

        $page = $this->reviewPageLoader->load($request, $context);

        $data = [
            'title' => $request->get('title'),
            'reviewText' => $request->get('reviewText'),
            'rating' => (int)$request->get('rating'),
            'customerId' => $context->getCustomer()->getId(),
            'languageId' => $context->getContext()->getLanguageId(),
            'salesChannelId' => $context->getSalesChannel()->getId(),
            'display' => false
            ]
        ;

        if($review = $page->getReview())
        {
            $data['id'] = $review->getId();
        }

        $this->reviewRepository->upsert(
            [$data]
            ,
            $context->getContext()
        );

        return $this->forwardToRoute('frontend.review.index');
    }

    /**
     * @Route("/reviews", name="frontend.review.list", methods={"GET"})
     * @param Request $request
     * @param SalesChannelContext $context
     * @return Response
     */
    public function listAction(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->reviewsPageLoader->load($request, $context);

        if(!$context->getCustomer())
        {
            return $this->redirectToRoute('frontend.account.login');
        }

        return $this->renderStorefront('@Inchoo/storefront/component/review/list.html.twig', [
            'page' => $page,
        ]);
    }

}