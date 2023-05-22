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
        $parent = $this->createCategory('Cuisine', null, $manager, 1);

        $this->createCategory('Couvert', $parent, $manager, 2);
        $this->createCategory('Verre', $parent, $manager, 3);
        $this->createCategory('Assiette', $parent, $manager, 4);

        $parent = $this->createCategory('Mode', null, $manager, 5);

        $this->createCategory('Homme', $parent, $manager, 6);
        $this->createCategory('Femme', $parent, $manager, 7);
        $this->createCategory('Enfant', $parent, $manager, 8);

        $parent = $this->createCategory('Jouets', null, $manager, 9);

        $this->createCategory('Jeux garcon', $parent, $manager, 10);
        $this->createCategory('Jeux fille', $parent, $manager, 11);
        $this->createCategory('Equipements', $parent, $manager, 12);

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
