<?php
declare(strict_types=1);

namespace App\Tests\Service\Category;

use App\Collection\PostCollection;
use App\Entity\Category;
use App\Model\Category as CategoryModel;
use App\Repository\Category\CategoryRepositoryInterface;
use App\Service\Category\CategoryPresentation;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

final class CategoryPresentationTest extends TestCase
{
    private $categoryRepositoryMock;

    public function setUp()
    {
        $this->categoryRepositoryMock = $this->getMockBuilder(CategoryRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['findBySlug'])
            ->getMock();
    }

    public function testGetBySlugNotFound()
    {
        $service = $this->getService();

        self::assertNull($service->getBySlug('slug'));
    }


    public function testGetBySlug()
    {
        $category = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $category->expects(self::once())
            ->method('getId')
            ->will(self::returnValue(23));

        $category->expects(self::once())
            ->method('getSlug')
            ->will(self::returnValue('this-is-test'));

        $category->expects(self::once())
            ->method('getTitle')
            ->will(self::returnValue('Title category'));

        $category->expects(self::once())
            ->method('getPosts')
            ->willReturn(new ArrayCollection());

        $this->categoryRepositoryMock
            ->expects(self::once())
            ->method('findBySlug')
            ->willReturn($category);

        $service = $this->getService();

        $expected = new CategoryModel(23, 'this-is-test', 'Title category');
        $expected->setPosts(new PostCollection());

        self::assertEquals($expected, $service->getBySlug('this-is-test'));
    }

    private function getService(): CategoryPresentation
    {
        return new CategoryPresentation($this->categoryRepositoryMock);
    }
}