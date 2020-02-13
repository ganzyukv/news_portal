<?php
declare(strict_types=1);

namespace App\Service\HomePage;

use App\Collection\PostCollection;
use App\Mapper\PostMapper;
use App\Repository\Post\PostRepositoryInterface;

final class HomePresentation implements HomePageServiceInterface
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPosts(): PostCollection
    {
        $posts = $this->postRepository->findAllPublished(20, 0);

        $collection = new PostCollection();

        foreach ($posts as $post) {
            $postModel = PostMapper::entityToModel($post);

            $collection->addPost($postModel);
        }

        return $collection;

    }
}