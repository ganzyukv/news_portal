<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\Category\CategoryPresentationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryController extends AbstractController
{
    /**
     * @param string $slug
     * @param CategoryPresentationInterface $presentationService
     * @return Response
     *
     * @Route("/category/{slug}", name="category_view", requirements={"slug": "^[a-z0-9]+(?:-[a-z0-9]+)*$"})
     */
    public function view(string $slug, CategoryPresentationInterface $presentationService): Response
    {
        $category = $presentationService->getBySlug($slug);

        if (null === $category) {
            throw new NotFoundHttpException('Category not found');
        }
        return $this->render('category/view.html.twig', [
            'category' => $category,
        ]);
    }
}