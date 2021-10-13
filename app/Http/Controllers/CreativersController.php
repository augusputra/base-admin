<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreativersModel;
use DataTables;
use Validator;
use Session;
use URL;
use DB;

class CreativersController extends Controller
{
    public function index(Request $request){
        $table_header = [
            'No',
            'Name',
            'Description',
            'City',
            'Category',
            'Status',
            'Created At',
            'Action'
        ];
        if($request->ajax()){
            $filtered = $request->search;
            
            DB::statement(DB::raw('set @rownum=0'));
            $data = CreativersModel::select(['*', DB::raw('@rownum  := @rownum  + 1 AS rownum')])
                ->with(['category', 'city'])
                ->when($filtered['name'], function($q) use($filtered) {
                    $q->where('name', 'like', '%'.$filtered['name'].'%');
                });

            return DataTables::of($data)
                ->addColumn('status',function($data){
                    $html = '';
                    if($data->status == 0){
                        $html = '<span class="badge badge-danger font-size-13">Unverified</span>';
                    }else{
                        $html = '<span class="badge badge-success font-size-13">Verified</span>';
                    }
                    return $html;
                })
                ->addColumn('action',function($data){
                    return '<div class="btn-group">
                    <a href="'.route('admin.creativers.detail', $data->id).'" class="btn btn-sm btn-warning btn-flat"><i class="fas fa-eye"></i></a>
                    <a href="'.route('admin.creativers.form_update', $data->id).'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-fw fa-pencil-alt"></i></a>
                    <a onclick="delete_confirmation(\''.route('admin.creativers.delete', $data->id).'\')" class="btn btn-sm btn-danger btn-flat btn-delete"><i class="fa fa-fw fa-trash"></i></a>
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        $page_title = 'Creativers';
        $page_description = '';
        $sess = Session::get('auth');
        $setFilter = [
            ['title'=>'Name', 'name'=>'name', 'class'=>null, 'type'=>'text'],
        ];
        $setFilter = json_encode($setFilter);
        return view('admin.pages.creativers.index', compact('page_title', 'page_description', 'table_header', 'setFilter'));
    }

    public function form(Request $request, $param = null, $is_detail = null)
    {
        $page_title = 'Creativers';
        $page_description = '';
        $type = 'Insert';
        $action = '';
        $data = array();
        $sess = Session::get('auth')->toArray();
        $category = $this->getCategory(0, true);
        $province = $this->getProvince(0, true);
        $city = [];
        $district = [];

        if($param!=null)
        {
            $data = @CreativersModel::find($param);
            $city = $this->getCity($data->province_id);
            $district = $this->getDistrict($data->city_id);
            $action = route('admin.creativers.update', $param);
            $type = 'Update';
        }
        if($is_detail)
        {
            $type = 'Detail';
        }
        return view('admin.pages.creativers.form', compact('page_title', 'type', 'page_description', 'action', 
            'data', 'category', 'province', 'city', 'district'));
    }

    public function detail(Request $request, $param = null)
    {
        return $this->form($request, $param, true);
    }

    public function update(Request $request, $param = null){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id',
                'thumbnail' => '',
                'province_id' => 'required|exists:provinces,id',
                'city_id' => 'required|exists:regencies,id',
                'district_id' => 'required|exists:districts,id',
                'postal_code' => 'required',
                'address' => 'required',
                'latitude' => '',
                'longitude' => '',
            ],  [
                'required' => ':attribute is required',
                'exists' => 'The selected :attribute is invalid.',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                return $this->set_response(false,'Failed create new record because '.$errors);
            }
            
            $data = $validator->validated();

            $detail = CreativersModel::find($param);

            if(isset($data['thumbnail'])){
                $data['thumbnail'] = $this->upload($data['thumbnail'], config('standard.upload_image_path.creativers'), null, @$detail['thumbnail']);
            }

            $result = $detail->update($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was updated', 'success']);
            return $this->set_response(true,'creativers was updated',['id'=>$param],route('admin.creativers.detail',$param));
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }

    public function delete(Request $request, $param = null)
    {
        DB::beginTransaction();
        try{
            $data = explode(',',$param);
    
            if(count($data)>0)
            {
                foreach ($data as $key => $row) {
                    $data[$key] = $row;
                }
            }
            
            CreativersModel::whereIn('id', $data)->delete();

            DB::commit();
            Session::put('flash_message',['Success','record was deleted', 'success']);
            return redirect()->route('admin.creativers');
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }
}
