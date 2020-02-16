<?php

namespace App\Repository\Post;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\QueryException;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param int $id
     * @return Post|null
     * @throws QueryException
     */
    public function findById(int $id): ?Post
    {
        try {
            return $this->createQueryBuilder('p')
                ->addCriteria(self::createPublishedCriteria())
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->innerJoin('p.category', 'c')
                ->addSelect('c')
                ->getQuery()
                ->getOneOrNullResult();

        } catch (NonUniqueResultException $e) {
            //if result not unique
            return null;
        }
    }

    /**
     * @param int $limit
     * @param int|null $offset
     * @return mixed|null
     * @throws QueryException
     */
    public function findAllPublished(int $limit = 0, int $offset = null): ?array
    {
        try {
            return $this->createQueryBuilder('p')
                ->addCriteria(self::createPublishedCriteria())
                ->innerJoin('p.category', 'c')
                ->addSelect('c')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getQuery()
                ->getResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function save(Post $post): void
    {
        $em = $this->getEntityManager();
        $em->persist($post);
        $em->flush();
    }

    /**
     * @return Criteria
     */
    public static function createPublishedCriteria(): Criteria
    {
        return Criteria::create()->andWhere(
            Criteria::expr()->neq('p.publicationDate', null)
        );
    }
}
