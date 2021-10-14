<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\RolesModel;
use Illuminate\Support\Facades\Auth;
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
    
    public function permissionCheck($permission)
    {        
        if(Auth::user()->can($permission)){
            return;
        }else{
            abort(403);
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

    public function getRole($id = 0, $is_all = false){
        if ($is_all) {
            $data = RolesModel::all();
        } else {
            $data = RolesModel::where('id', $id)->get();
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
