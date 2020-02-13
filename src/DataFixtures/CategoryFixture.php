<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{

    public const CATEGORIES = [
        'World',
        'Sport',
        'IT',
        'Science',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $category) {
//            $slug = $this->get('slugify')->slugify($category)
            $category = new Category($category, new Slugify());
            $this->addReference('category_' . $key, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
