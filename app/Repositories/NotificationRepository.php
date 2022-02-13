<?php


namespace App\Repositories;

use App\Models\Building;
use App\Models\Notification;
use App\Models\Resident;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;


class NotificationRepository extends BaseRepository
{

 
    public function model()
    {
        return Notification::class;
    }



    /**
     * upload  image
     */
    public function uploadImage(UploadedFile $file, Notification $notification){
        $ext = $file->getClientOriginalExtension();
        $fileName = 'photos/notif/image-'.$notification->id. '.'. $ext;
        $path = $file->storeAs('public', $fileName);

        return '/storage/'.$fileName;
    }

    /**
     * get count notification not read by user
     */
    public function getCountNotRead($type){
        return $this->findWhere(['receiver' => Auth::user()->id, 'type' => $type, 'seen' => Notification::NOT_READ])->count();
    }


    /**
     * insert multi row 
     */
    public function insert(array $data){
        return $this->model()::insert($data);
    }
    /**
     * upload  file
     */
    public function uploadFile(UploadedFile $file, Building $building){
        $ext = $file->getClientOriginalExtension();
        $fileName = 'photos/notification/building-'.$building->id.'/notif-'.time(). '.'. $ext;
        $path = $file->storeAs('public', $fileName);

        return '/storage/'.$fileName;
    }
}
