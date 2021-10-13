<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersModel;
use DataTables;
use Validator;
use Session;
use URL;
use DB;

class UsersController extends Controller
{
    public function index(Request $request){
        $table_header = [
            'No',
            'Name',
            'Phone',
            'Email',
            'Status',
            'Created At',
            'Action'
        ];
        if($request->ajax()){
            $filtered = $request->search;
            
            DB::statement(DB::raw('set @rownum=0'));
            $data = UsersModel::select(['*', DB::raw('@rownum  := @rownum  + 1 AS rownum')])
                ->whereHas('role', function ($q) {
                    $q->where('name', 'user');
                })
                ->when($filtered['name'], function($q) use($filtered) {
                    $q->where('name', 'like', '%'.$filtered['name'].'%');
                })
                ->when($filtered['phone'], function($q) use($filtered) {
                    $q->where('phone', 'like', '%'.$filtered['phone'].'%');
                })
                ->when($filtered['email'], function($q) use($filtered) {
                    $q->where('email', 'like', '%'.$filtered['email'].'%');
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
                    <a href="'.route('admin.users.detail', $data->id).'" class="btn btn-sm btn-warning btn-flat"><i class="fas fa-eye"></i></a>
                    <a href="'.route('admin.users.form_update', $data->id).'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-fw fa-pencil-alt"></i></a>
                    <a onclick="delete_confirmation(\''.route('admin.users.delete', $data->id).'\')" class="btn btn-sm btn-danger btn-flat btn-delete"><i class="fa fa-fw fa-trash"></i></a>
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        $page_title = 'Users';
        $page_description = '';
        $sess = Session::get('auth');
        $setFilter = [
            ['title'=>'Name', 'name'=>'name', 'class'=>null, 'type'=>'text'],
            ['title'=>'Phone', 'name'=>'phone', 'class'=>null, 'type'=>'number'],
            ['title'=>'Email', 'name'=>'email', 'class'=>null, 'type'=>'text'],
        ];
        $setFilter = json_encode($setFilter);
        return view('admin.pages.users.index', compact('page_title', 'page_description', 'table_header', 'setFilter'));
    }

    public function form(Request $request, $param = null, $is_detail = null)
    {
        $page_title = 'Users';
        $page_description = '';
        $type = 'Insert';
        $action = '';
        $data = array();
        $sess = Session::get('auth')->toArray();
        if($param!=null)
        {
            $data = @UsersModel::find($param);
            $action = route('admin.users.update', $param);
            $type = 'Update';
        }
        if($is_detail)
        {
            $type = 'Detail';
        }
        return view('admin.pages.users.form', compact('page_title', 'type', 'page_description', 'action', 'data'));
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
                'phone' => 'required',
                'email' => 'required',
                'username' => 'required',
                'photo' => '',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                return $this->set_response(false,'Failed create new record because '.$errors);
            }
            
            $data = $validator->validated();

            $detail = UsersModel::find($param);

            if(isset($data['photo'])){
                $data['photo'] = $this->upload($data['photo'], config('standard.upload_image_path.users'), null, @$detail['photo']);
            }

            $result = $detail->update($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was updated', 'success']);
            return $this->set_response(true,'users was updated',['id'=>$param],route('admin.users.detail',$param));
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
            
            UsersModel::whereIn('id', $data)->delete();

            DB::commit();
            Session::put('flash_message',['Success','record was deleted', 'success']);
            return redirect()->route('admin.users');
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }
}
