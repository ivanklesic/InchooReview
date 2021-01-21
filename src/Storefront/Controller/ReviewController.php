<?php

namespace Inchoo\ReviewPlugin\Storefront\Controller;

use Inchoo\ReviewPlugin\Core\Content\Review\ReviewEntity;
use Inchoo\ReviewPlugin\Page\Review\ReviewPageLoader;
use Inchoo\ReviewPlugin\Page\Review\ReviewsPageLoader;
use Inchoo\ReviewPlugin\Storefront\Validator\ReviewValidator;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
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

    private $reviewValidator;

    /**
     * @var EntityRepositoryInterface
     */
    private $reviewRepository;

    public function __construct(
        ReviewPageLoader $reviewPageLoader,
        ReviewsPageLoader $reviewsPageLoader,
        EntityRepositoryInterface $entityRepository,
        ReviewValidator $reviewValidator
    )
    {
        $this->reviewPageLoader = $reviewPageLoader;
        $this->reviewsPageLoader = $reviewsPageLoader;
        $this->reviewRepository = $entityRepository;
        $this->reviewValidator = $reviewValidator;
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
            'errors' => $request->get('errors')
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
            'title' => trim($request->get('title')),
            'reviewText' => trim($request->get('reviewText')),
            'rating' => (int)$request->get('rating'),
            'customerId' => $context->getCustomer()->getId(),
            'languageId' => $context->getContext()->getLanguageId(),
            'salesChannelId' => $context->getSalesChannel()->getId(),
            'display' => false
            ];

        $errors = $this->reviewValidator->validate($data);

        if(!empty($errors))
        {
            return $this->redirectToRoute('frontend.review.index', ['errors' => $errors]);
        }

        if($review = $page->getReview())
        {
            $data['id'] = $review->getId();
        }

        $this->reviewRepository->upsert(
            [$data]
            ,
            $context->getContext()
        );

        return $this->redirectToRoute('frontend.review.index');
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

    /**
     * @Route("/review/delete", name="frontend.review.delete", methods={"POST"})
     * @param Request $request
     * @param SalesChannelContext $context
     * @return Response
     */
    public function deleteAction(Request $request, SalesChannelContext $context): Response
    {
        if(!$context->getCustomer())
        {
            return $this->redirectToRoute('frontend.account.login');
        }

        if(!$reviewId = $request->request->get('reviewId'))
        {
            return $this->redirectToRoute('frontend.review.index');
        }

        $criteria = new Criteria();

        $criteria->addFilter(
            new EqualsFilter('id', $reviewId)
        );

        /** @var ReviewEntity $review */
        $review = $this->reviewRepository->search(
            $criteria, $context->getContext()
        )->getEntities()->first();

        if(!$review)
        {
            return $this->redirectToRoute('frontend.review.index');
        }

        if($review->getCustomerId() !== $context->getCustomer()->getId())
        {
            return $this->redirectToRoute('frontend.review.index');
        }

        $this->reviewRepository->delete(
            [
                [
                    'id' => $reviewId
                ]
            ]
        , $context->getContext());

        return $this->redirectToRoute('frontend.review.index');
    }
}