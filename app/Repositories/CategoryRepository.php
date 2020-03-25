<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends DataRepository
{
  public function __construct(Category $category)
  {
    $this->model = $category;
  }
}
