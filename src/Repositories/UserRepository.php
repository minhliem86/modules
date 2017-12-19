<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return User::class;
    }
    // END

}