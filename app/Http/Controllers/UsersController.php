<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        $this->permissionCheck('view-user-list');

        $table_header = [
            'No',
            'First Name',
            'Last Name',
            'Email',
            'Role',
            'Created At',
            'Action'
        ];
        if($request->ajax()){
            $filtered = $request->search;
            
            DB::statement(DB::raw('set @rownum=0'));
            $data = UsersModel::select(['*', DB::raw('@rownum  := @rownum  + 1 AS rownum')])
                ->with(['role'])
                ->when($filtered['name'], function($q) use($filtered) {
                    $q->where('first_name', 'like', '%'.$filtered['name'].'%')
                    ->orWhere('last_name', 'like', '%'.$filtered['name'].'%');
                })
                ->when($filtered['email'], function($q) use($filtered) {
                    $q->where('email', 'like', '%'.$filtered['email'].'%');
                })
                ->when($filtered['role_id'], function($q) use($filtered) {
                    $q->where('role_id', $filtered['role_id']);
                })->get();

            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $action = '';
                    if(Auth::user()->can('view-user-list')){
                        $action = '<a href="'.route('users.detail', $data->id).'" class="btn btn-sm btn-warning btn-flat"><i class="fas fa-eye"></i></a>';
                    }
                    if(Auth::user()->can('edit-user')){
                        $action .= '<a href="'.route('users.form_update', $data->id).'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-fw fa-pencil-alt"></i></a>';
                    }
                    if(Auth::user()->can('delete-user')){
                        $action .= '<a onclick="delete_confirmation(\''.route('users.delete', $data->id).'\')" class="btn btn-sm btn-danger btn-flat btn-delete"><i class="fa fa-fw fa-trash"></i></a>';
                    }
                    return '<div class="btn-group">'.$action.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Users';
        $page_description = '';
        $sess = Auth::user();
        $setFilter = [
            ['title'=>'Name', 'name'=>'name', 'class'=>null, 'type'=>'text'],
            ['title'=>'Email', 'name'=>'email', 'class'=>null, 'type'=>'text'],
            ['title'=>'Role', 'name'=>'role_id', 'class'=>'select-role', 'type'=>'select', 'data' => $this->getRole(0, true)],
        ];
        $setFilter = json_encode($setFilter);
        return view('pages.users.index', compact('page_title', 'page_description', 'table_header', 'setFilter'));
    }

    public function form(Request $request, $param = null, $is_detail = null)
    {
        $page_title = 'Users';
        $page_description = '';
        $type = 'Insert';
        $action = route('users.create');
        $data = array();
        $role = $this->getRole(0, true);
        $sess = Auth::user();
        if($param!=null)
        {
            $data = @UsersModel::find($param);
            $action = route('users.update', $param);
            $type = 'Update';
        }
        if($is_detail)
        {
            $type = 'Detail';
        }
        return view('pages.users.form', compact('page_title', 'type', 'page_description', 'action', 'data', 'role'));
    }

    public function detail(Request $request, $param = null)
    {
        return $this->form($request, $param, true);
    }

    public function create(Request $request){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'password' => 'required|min:6|confirmed',
                'role_id' => 'required|exists:roles,id',
            ],  [
                'required' => ':attribute is required',
                'exists' => 'The selected :attribute is invalid',
                'min' => [
                    'numeric' => 'The :attribute must be at least :min',
                    'file' => 'The :attribute must be at least :min kilobytes',
                    'string' => 'The :attribute must be at least :min characters',
                    'array' => 'The :attribute must have at least :min items',
                ],
                'confirmed' => 'The :attribute confirmation does not match',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                Session::put('flash_message','Failed create new record because '.$errors);
                return redirect()->route('users.form');
            }
            
            $data = $validator->validated();

            $data['password'] = bcrypt($data['password']);

            $result = UsersModel::create($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was added', 'success']);
            return $this->set_response(true,'User was created',['id'=>$result->id],route('users.detail',$result->id));
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }

    public function update(Request $request, $param = null){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'role_id' => 'required|exists:roles,id',
            ],  [
                'required' => ':attribute is required',
                'exists' => 'The selected :attribute is invalid',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                Session::put('flash_message','Failed create new record because '.$errors);
                return redirect()->route('users.form', $param);
            }

            $data = $validator->validated();

            if(@$request->password != null){
                $validator = Validator::make($request->all(),[
                    'password' => 'required|min:6|confirmed',
                ],  [
                    'required' => ':attribute is required',
                    'min' => [
                        'numeric' => 'The :attribute must be at least :min',
                        'file' => 'The :attribute must be at least :min kilobytes',
                        'string' => 'The :attribute must be at least :min characters',
                        'array' => 'The :attribute must have at least :min items',
                    ],
                    'confirmed' => 'The :attribute confirmation does not match',
                ]);
        
                if ($validator->fails()) {
                    $errors = $this->parseValidator($validator);
                    Session::put('flash_message','Failed create new record because '.$errors);
                    return redirect()->route('users.form', $param);
                }

                $data += $validator->validated();

                $data['password'] = bcrypt($data['password']);
            }

            $detail = UsersModel::find($param);

            $result = $detail->update($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was updated', 'success']);
            return $this->set_response(true,'users was updated',['id'=>$detail],route('users.detail',$param));
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
            return redirect()->route('users');
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }
}
