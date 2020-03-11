<?php

namespace App\Repositories;

use App\Group;

class GroupRepository extends DataRepository
{
  public function __construct(Group $group)
  {
    $this->model = $group;
  }
}
