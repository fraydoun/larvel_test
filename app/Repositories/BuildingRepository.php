<?php


namespace App\Repositories;

use App\Models\Building;
use App\Models\Resident;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;


class BuildingRepository extends BaseRepository
{

    public function model()
    {
        return Building::class;
    }

    public function create(array $attributes):Building
    {
        $attributes['manager'] = Auth::user()->id;
        $model = parent::create($attributes);
        $code = Building::Flag . substr(microtime(), -2) . $model->id;

        $model->update(['code' => $code]);

        // insert manager to resident table for better select in my bulding action.
        $model->relResidents()->attach(Auth::user()->id, ['type' => Resident::TYPE_MANAGER]);
        return $model;
    }

    public function findByCode($code){
        return $this->findByField('code', $code)->first();
    }

    public function findById($id){
        return $this->model->find($id);
    }

    /**
     * upload  image
     */
    public function uploadImage(UploadedFile $file, Building $building){
        $ext = $file->getClientOriginalExtension();
        $fileName = 'photos/building/image-'.$building->id. '.'. $ext;
        $path = $file->storeAs('public', $fileName);

        return '/storage/'.$fileName;
    }
}
