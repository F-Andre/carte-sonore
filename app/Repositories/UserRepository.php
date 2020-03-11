<?php

namespace App\Repositories;

use App\User;

class UserRepository extends DataRepository
{
  public function __construct(User $user)
  {
    $this->model = $user;
  }
}
