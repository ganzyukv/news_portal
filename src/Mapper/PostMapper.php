<?php
declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Post;
use App\Form\Dto\PostCreateDto;
use App\Model\Category;
use App\Model\Post as PostModel;

final class PostMapper
{
    public static function entityToModel(Post $entity): PostModel
    {
        $category = $entity->getCategory();

        $model = new PostModel(
            $entity->getId(),
            new Category($category->getId(), $category->getTitle(), $category->getSlug()),
            $entity->getTitle());

        $model->setPublicationDate($entity->getPublicationDate())
            ->setImage($entity->getImage())
            ->setBody($entity->getBody())
            ->setShortDescription($entity->getShortDescription());

        return $model;
    }

    public static function dtoToEntity(PostCreateDto $dto): Post
    {
        $entity = new Post($dto->title);
        $entity
            ->setShortDescription($dto->shortDescription)
            ->setBody($dto->body)
            ->setImage($dto->image)
            ->setCategory($dto->category);

        return $entity;
    }
}