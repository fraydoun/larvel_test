<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

//use Your Model

/**
 * Class AdminRepository.
 */
class AdminRepository extends BaseRepository
{

    public function model()
    {
        // TODO: Implement model() method.
        return Admin::class;
    }

    /**
     * find user by phone_number if not exists create
     * @var $phone_number string
     */
    public function findOrCreate($phone_number):User {
        return $this->model->firstOrCreate(['phone_number' => $phone_number]);
    }

    /**
     * find user by phone_number
     * @var $phone_number string
     * @return User | null
     *
     */
    public function findByPhoneNumber(string $phone_number){
        return $this->model->where('phone_number', $phone_number)->first();
    }


    /**
     * find user by username
     * @var $username string
     * @return User | null
     */
    public function findByUsername(string $username){
        return $this->model->where('username', $username)->first();
    }


    /**
     * upload avatar image
     */
    public function uploadAvatar(UploadedFile $file, int $user_id){
        $ext = $file->getClientOriginalExtension();
        $fileName = 'photos/admin/avatar/admin-'.$user_id. '.'. $ext;
        $path = $file->storeAs('public', $fileName);

        return '/storage/'.$fileName;
    }


}
