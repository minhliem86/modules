<?php
namespace App\Repositories;

use App\Repositories\Contract\RestfulInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Config;

class ConfigRepository extends BaseRepository implements RestfulInterface{

    public function getModel()
    {
        return Config::class;
    }
    // END

}