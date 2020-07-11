<?php


namespace App\Repository;


use App\Core\Database\Repository\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    public function findCategories(): ?array
    {
        $categoriesAll = $this->findAll();

        foreach($categoriesAll as $category) {
            $categories[$category->getId()] = $category->getCategory();
        }

        return $categories ?? [];
    }
}