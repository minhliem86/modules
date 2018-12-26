<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Photo;

class PhotoRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Photo::class;
    }
    // END

}