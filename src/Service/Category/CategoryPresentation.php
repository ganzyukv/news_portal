<?php
declare(strict_types=1);

namespace App\Service\Category;

use App\Mapper\CategoryMapper;
use App\Model\Category;
use App\Repository\Category\CategoryRepositoryInterface;

final class CategoryPresentation implements CategoryPresentationInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getBySlug(string $slug): Category
    {
        $entity = $this->categoryRepository->findBySlug($slug);

        return CategoryMapper::entityToModel($entity);
    }
}