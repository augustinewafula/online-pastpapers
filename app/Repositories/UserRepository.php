<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Pastpaper;
/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }
}
