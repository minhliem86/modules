<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Example;

class ExampleRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Example::class;
    }
    // END

}