<?php
declare(strict_types=1);

namespace App\Service\Category;

use App\Model\Category;

interface CategoryPresentationInterface
{
    public function getBySlug(string $slug): Category;
}