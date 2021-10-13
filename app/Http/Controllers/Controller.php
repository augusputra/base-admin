<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\CategoriesModel;
use App\Models\ProvincesModel;
use App\Models\RegenciesModel;
use App\Models\DistrictsModel;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function parseValidator($validator) {
        if ($validator->fails()) {
            $messages = $validator->errors()->toArray();
            $errors = [];
            foreach ($messages as $key => $value) {
                $errors[$key] = $value[0];
            }
            $error = implode(', ', $errors);
            return $error;
        } else {
            return null;
        }
    }

    function set_response($status=false,$message=null,$data=null,$redirect=null,$callback=null)
    {   
        $return_data=array();
        if($status==true)
        {
            $return_data['status']="SUCCESS";
        }
        else
        {
            $return_data['status']='FAILED';
        }
        if($data==null)
        {
            $return_data['message']='There is no data';
        }
        if(is_array($data) || is_object($data))
        {
            if(!is_array($data))
            {
                $data=$data->toArray();
            }
            
            if(count($data) > 0)
            {
                if(!empty(@$data['password']))
                {
                    unset($data['password']);                    
                }
                $return_data['data']=$data;
                $return_data['message']=count($data).' data was found';
            }
            else
            {
                $return_data['data']=array();
                $return_data['message']='There is no data';
            }
        }
        else
        {
            $return_data['data']=array();
        }
        if(!empty($redirect))
        {
            $return_data['redirect']=$redirect;
        }
        if(!empty($message))
        {
            $return_data['message']=$message;
        }
        if(!empty($callback))
        {
            $return_data['callback']=$callback;
        }
        return json_encode($return_data);
    }

    public function upload($file, $upload_location, $name = null, $old_file_path = null){
        if($name == null)
          $name = time().'_'.pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      
        if($old_file_path)
          if(strpos($old_file_path, 'http') === false)
            unlink($old_file_path);
      
        $file_name = $name.'.'.$file->getClientOriginalExtension();
        $file->move($upload_location, $file_name);
        return $upload_location.'/'.$file_name;
    }

    public function getCategory($id = 0, $is_all = false){
        if ($is_all) {
            $data = CategoriesModel::all();
        } else {
            $data = CategoriesModel::findByField('id', $id);
        }

        $response = array();
        foreach ($data as $key => $value) {
            $response[] = array(
                'id' => $value->id,
                'text' => $value->name,
            );
        } 
        return $response;
    }

    public function getProvince($id = 0, $is_all = false){
        if ($is_all) {
            $data = ProvincesModel::all();
        } else {
            $data = ProvincesModel::findByField('id', $id);
        }

        $response = array();
        foreach ($data as $key => $value) {
            $response[] = array(
                'id' => $value->id,
                'text' => $value->name,
            );
        } 
        return $response;
    }

    public function getCity($province_id = 0){
        if($province_id != 0){
            $data = RegenciesModel::where('province_id', $province_id)->get();
        }else{
            $data = RegenciesModel::all();
        }

        $response = array();
        foreach ($data as $key => $value) {
            $response[] = array(
                'id' => $value->id,
                'text' => $value->name,
            );
        } 
        return $response;
    }

    public function getDistrict($regency_id = 0){
        if($regency_id != 0){
            $data = DistrictsModel::where('regency_id', $regency_id)->get();
        }else{
            $data = DistrictsModel::all();
        }

        $response = array();
        foreach ($data as $key => $value) {
            $response[] = array(
                'id' => $value->id,
                'text' => $value->name,
            );
        } 
        return $response;
    }
}
