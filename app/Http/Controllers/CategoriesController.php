<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use DataTables;
use Validator;
use Session;
use DB;

class CategoriesController extends Controller
{
    public function index(Request $request){
        $table_header = [
            'No',
            'Name',
            'Description',
            'Action'
        ];
        if($request->ajax()){
            $filtered = $request->search;
            
            DB::statement(DB::raw('set @rownum=0'));
            $data = CategoriesModel::select(['*', DB::raw('@rownum  := @rownum  + 1 AS rownum')])
                ->when($filtered['name'], function($q) use($filtered) {
                    $q->where('name', 'like', '%'.$filtered['name'].'%');
                });

            return DataTables::of($data)
                ->addColumn('action',function($data){
                    return '<div class="btn-group">
                    <a href="'.route('admin.categories.form_update', $data->id).'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-fw fa-pencil-alt"></i></a>
                    <a onclick="delete_confirmation(\''.route('admin.categories.delete', $data->id).'\')" class="btn btn-sm btn-danger btn-flat btn-delete"><i class="fa fa-fw fa-trash"></i></a>
                    </div>';
                })
                ->make(true);
        }
        $page_title = 'Categories';
        $page_description = '';
        $sess = Session::get('auth');
        $setFilter = [
            ['title'=>'Name', 'name'=>'name', 'class'=>null, 'type'=>'text'],
        ];
        $setFilter = json_encode($setFilter);
        return view('admin.pages.categories.index', compact('page_title', 'page_description', 'table_header', 'setFilter'));
    }

    public function form(Request $request, $param = null, $is_detail = null)
    {
        $page_title = 'Categories';
        $page_description = '';
        $type = 'Insert';
        $action = route('admin.categories.create', $param);
        $data = array();
        $sess = Session::get('auth')->toArray();
        if($param!=null)
        {
            $data = @CategoriesModel::find($param);
            $action = route('admin.categories.update', $param);
            $type = 'Update';
        }
        if($is_detail)
        {
            $type = 'Detail';
        }
        return view('admin.pages.categories.form', compact('page_title', 'type', 'page_description', 'action', 'data'));
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
                'description' => 'required',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                return $this->set_response(false,'Failed create new record because '.$errors);
            }
            
            $data = $validator->validated();

            $result = CategoriesModel::create($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was added', 'success']);
            return $this->set_response(true,'Categories was created',['id'=>$result->id],route('admin.categories.detail',$result->id));
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
                'description' => 'required',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                return $this->set_response(false,'Failed create new record because '.$errors);
            }
            
            $data = $validator->validated();

            $category_update = CategoriesModel::find($param)->update($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was updated', 'success']);
            return $this->set_response(true,'Categories was updated',['id'=>$param],route('admin.categories.detail',$param));
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
            
            CategoriesModel::whereIn('id', $data)->delete();

            DB::commit();
            Session::put('flash_message',['Success','record was deleted', 'success']);
            return redirect()->route('admin.categories');
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }
}
