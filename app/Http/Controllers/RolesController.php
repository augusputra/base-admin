<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RolePermissionsModel;
use App\Models\PermissionsModel;
use App\Models\RolesModel;
use DataTables;
use Validator;
use Session;
use URL;
use DB;

class RolesController extends Controller
{
    public function index(Request $request){
        $this->permissionCheck('view-role-list');

        $table_header = [
            'No',
            'Name',
            'Display Name',
            'Description',
            'Created At',
            'Action'
        ];
        if($request->ajax()){
            $filtered = $request->search;
            
            DB::statement(DB::raw('set @rownum=0'));
            $data = RolesModel::select(['*', DB::raw('@rownum  := @rownum  + 1 AS rownum')])
                ->when($filtered['name'], function($q) use($filtered) {
                    $q->where('name', 'like', '%'.$filtered['name'].'%')
                    ->orWhere('display_name', 'like', '%'.$filtered['name'].'%');
                })
                ->get();

            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $action = '';
                    if(Auth::user()->can('view-role-list')){
                        $action = '<a href="'.route('roles.detail', $data->id).'" class="btn btn-sm btn-warning btn-flat"><i class="fas fa-eye"></i></a>';
                    }
                    if(Auth::user()->can('edit-role')){
                        $action .= '<a href="'.route('roles.form_update', $data->id).'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-fw fa-pencil-alt"></i></a>';
                    }
                    if(Auth::user()->can('delete-role')){
                        $action .= '<a onclick="delete_confirmation(\''.route('roles.delete', $data->id).'\')" class="btn btn-sm btn-danger btn-flat btn-delete"><i class="fa fa-fw fa-trash"></i></a>';
                    }
                    return '<div class="btn-group">'.$action.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $page_title = 'Roles';
        $page_description = '';
        $sess = Auth::user();
        $setFilter = [
            ['title'=>'Name', 'name'=>'name', 'class'=>null, 'type'=>'text'],
        ];
        $setFilter = json_encode($setFilter);
        return view('pages.roles.index', compact('page_title', 'page_description', 'table_header', 'setFilter'));
    }

    public function form(Request $request, $param = null, $is_detail = null)
    {
        $page_title = 'Roles';
        $page_description = '';
        $type = 'Insert';
        $action = route('roles.create');
        $data = array();
        $sess = Auth::user();
        $permissions = PermissionsModel::all();
        $groups = [];
        $role_permissions = [];
        foreach ($permissions as $data_p) {
            if (in_array($data_p->group, $groups)) {
                continue;
            } else {
                array_push($groups, $data_p->group);
            }
        }
        if($param!=null)
        {
            $data = @RolesModel::find($param);
            $role_permissions = RolePermissionsModel::with('permission')
                ->where('role_id', $data->id)->get()->pluck('permission.id');
            $action = route('roles.update', $param);
            $type = 'Update';
        }
        if($is_detail)
        {
            $type = 'Detail';
        }
        return view('pages.roles.form', compact('page_title', 'type', 'page_description', 'action', 'permissions', 'role_permissions', 'groups', 'data'));
    }

    public function detail(Request $request, $param = null)
    {
        return $this->form($request, $param, true);
    }

    public function create(Request $request){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'display_name' => 'required',
                'description' => 'required',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                Session::put('flash_message','Failed create new record because '.$errors);
                return redirect()->route('roles.form');
            }
            
            $data = $validator->validated();

            $result = RolesModel::create($data);

            foreach ($request->permission_ids as $key => $row) {
                $bulk[] = ['role_id'=>$result->id,'permission_id'=>$row,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            }
            RolePermissionsModel::insert($bulk);

            DB::commit();
            Session::put('flash_message',['Success','new record was added', 'success']);
            return $this->set_response(true,'Role was created',['id'=>$result->id],route('roles.detail',$result->id));
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }

    public function update(Request $request, $param = null){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'display_name' => 'required',
                'description' => 'required',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                Session::put('flash_message','Failed create new record because '.$errors);
                return redirect()->route('roles.form', $param);
            }

            $data = $validator->validated();

            $detail = RolesModel::find($param);
            $result = $detail->update($data);

            $delete_permission = RolePermissionsModel::where('role_id', $detail->id)->delete();
            foreach ($request->permission_ids as $key => $row) {
                $bulk[] = ['role_id'=>$detail->id,'permission_id'=>$row,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            }
            RolePermissionsModel::insert($bulk);

            DB::commit();
            Session::put('flash_message',['Success','new record was updated', 'success']);
            return $this->set_response(true,'roles was updated',['id'=>$detail],route('roles.detail',$param));
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
            
            $data = RolesModel::whereIn('id', $data)->get();

            foreach ($data as $key => $row) {
                RolePermissionsModel::where('role_id', $row->id)->delete();
                $row->delete();
            }

            DB::commit();
            Session::put('flash_message',['Success','record was deleted', 'success']);
            return redirect()->route('roles');
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }
}
