<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Metas;

class MetaRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Metas::class;
    }
    // END

}