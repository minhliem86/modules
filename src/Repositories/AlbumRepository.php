<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Album;

class AlbumRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Album::class;
    }
    // END

}