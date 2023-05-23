<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Multimmedia', null, $manager, 1);

        $this->createCategory('Televiseurs', $parent, $manager, 2);
        $this->createCategory('Portables', $parent, $manager, 3);
        $this->createCategory('Console', $parent, $manager, 4);

        $parent = $this->createCategory('Mode', null, $manager, 5);

        $this->createCategory('Homme', $parent, $manager, 6);
        $this->createCategory('Femme', $parent, $manager, 7);
        $this->createCategory('Enfant', $parent, $manager, 8);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager, int $categoryOrders)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $category->setCategoryOrders($categoryOrders);
        $manager->persist($category);

        $this->addReference('cat-' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}
