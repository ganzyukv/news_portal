<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use function mt_rand;

class PostFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post($this->faker->sentence);
            $post->setShortDescription($this->faker->sentence)
                ->setImage($this->faker->imageUrl())
                ->setCategory($this->getReference('category_' . mt_rand(0, 3)));

            $body = '';
            $sentencesNumber = mt_rand(3, 15);

            foreach ($this->provideSentence($sentencesNumber) as $sentance) {
                $body .= $sentance;
            }

            $post->setBody($body);

            if ($this->faker->boolean(80)) {
                $post->setPublicationDate(new DateTime());
            }

            $manager->persist($post);

        }
        $manager->flush();
    }

    private function provideSentence(int $sentencesNumber)
    {
        for ($i = 0; $i < $sentencesNumber; $i++) {
            yield '<p>' . $this->faker->sentences(mt_rand(1, 6), true) . '</p>';
        }
    }

    public function getDependencies()
    {
        return [
            CategoryFixture::class,
        ];
    }
}
