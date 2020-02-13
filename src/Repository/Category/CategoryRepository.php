<?php

namespace App\Repository\Category;

use App\Entity\Category;
use App\Repository\Post\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findBySlug(string $slug): ?Category
    {
        try {
            return $this->createQueryBuilder('c')
                ->where('c.slug = :slug')
                ->setParameter('slug', $slug)
                ->leftJoin('c.posts', 'p')
                ->addCriteria(PostRepository::createPublishedCriteria())
                ->addSelect('p')
                ->getQuery()
                ->getOneOrNullResult();

        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
