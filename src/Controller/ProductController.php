<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/{page?1}", name="products", requirements={"page"="^[1-9]\d*"})
     * @param ProductRepository $repository
     * @param PaginatorInterface $paginator
     * @param int $page
     * @return Response
     */
    public function index(ProductRepository $repository, PaginatorInterface $paginator, int $page) : Response
    {
        $queryBuilder = $repository->getProductListQueryBuilder();

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            10,
            [
                'defaultSortFieldName' => 'p.createdAt',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render(
            'product/index.html.twig',
            [
                'pagination' => $pagination,
            ]
        );
    }
}
