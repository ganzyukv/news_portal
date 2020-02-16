<?php
declare(strict_types=1);

namespace App\Service\Management;

use App\Entity\Post;
use App\Form\Dto\PostCreateDto;
use App\Mapper\PostMapper;
use App\Repository\Post\PostRepositoryInterface;

final class PostManagementService implements PostManagementServiceInterface
{
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(PostCreateDto $dto): Post
    {
        $post = PostMapper::dtoToEntity($dto);

        $post->publish();

        $this->postRepository->save($post);

        return $post;

    }
}