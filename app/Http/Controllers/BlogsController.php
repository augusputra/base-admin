<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogsModel;
use DataTables;
use Validator;
use Session;
use URL;
use DB;

class BlogsController extends Controller
{
    public function index(Request $request){
        $table_header = [
            'No',
            'Title',
            'Short Description',
            'Is Public',
            'Created At',
            'Action'
        ];
        if($request->ajax()){
            $filtered = $request->search;
            
            DB::statement(DB::raw('set @rownum=0'));
            $data = BlogsModel::select(['*', DB::raw('@rownum  := @rownum  + 1 AS rownum')])
                ->when($filtered['title'], function($q) use($filtered) {
                    $q->where('title', 'like', '%'.$filtered['title'].'%');
                })
                ->when($filtered['is_public'] != null, function($q) use($filtered) {
                    $q->where('is_public', $filtered['is_public']);
                })
                ->when($filtered['date_start'] != null, function($q) use($filtered) {
                    $q->where('created_at', '>=', $filtered['date_start']);
                })
                ->when($filtered['date_end'] != null, function($q) use($filtered) {
                    $q->where('created_at', '<=', $filtered['date_end']);
                });

            return DataTables::of($data)
                // ->addColumn('thumbnail',function($data){
                //     return '<div class="img_dt_table" style="background-image: url(\''.URL::to(@$data->thumbnail).'\');"">
                //     </div>';
                // })
                ->addColumn('is_public',function($data){
                    $html = '';
                    if($data->is_public == 0){
                        $html = '<span class="badge badge-danger font-size-13">Unactive</span>';
                    }else{
                        $html = '<span class="badge badge-success font-size-13">Active</span>';
                    }
                    return $html;
                })
                ->addColumn('action',function($data){
                    return '<div class="btn-group">
                    <a href="'.route('admin.blogs.detail', $data->id).'" class="btn btn-sm btn-warning btn-flat"><i class="fas fa-eye"></i></a>
                    <a href="'.route('admin.blogs.form_update', $data->id).'" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-fw fa-pencil-alt"></i></a>
                    <a onclick="delete_confirmation(\''.route('admin.blogs.delete', $data->id).'\')" class="btn btn-sm btn-danger btn-flat btn-delete"><i class="fa fa-fw fa-trash"></i></a>
                    </div>';
                })
                ->rawColumns(['is_public', 'action'])
                ->make(true);
        }
        $page_title = 'Blogs';
        $page_description = '';
        $sess = Session::get('auth');
        $setFilter = [
            ['title'=>'Title', 'name'=>'title', 'class'=>null, 'type'=>'text'],
            ['title'=>'Is Public', 'name'=>'is_public', 'class'=>'select-is-public', 'type'=>'select', 'data' => getDataIsPublic()],
            ['title'=>'Date Start', 'name'=>'date_start', 'class'=>'date', 'type'=>'text'],
            ['title'=>'Date End', 'name'=>'date_end', 'class'=>'date', 'type'=>'text'],
        ];
        $setFilter = json_encode($setFilter);
        return view('admin.pages.blogs.index', compact('page_title', 'page_description', 'table_header', 'setFilter'));
    }

    public function form(Request $request, $param = null, $is_detail = null)
    {
        $page_title = 'Blogs';
        $page_description = '';
        $type = 'Insert';
        $action = route('admin.blogs.create', $param);
        $data = array();
        $sess = Session::get('auth')->toArray();
        if($param!=null)
        {
            $data = @BlogsModel::find($param);
            $action = route('admin.blogs.update', $param);
            $type = 'Update';
        }
        if($is_detail)
        {
            $type = 'Detail';
        }
        return view('admin.pages.blogs.form', compact('page_title', 'type', 'page_description', 'action', 'data'));
    }

    public function detail(Request $request, $param = null)
    {
        return $this->form($request, $param, true);
    }

    public function create(Request $request){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'short_description' => 'required',
                'description' => 'required',
                'is_public' => '',
                'thumbnail' => 'required',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                return $this->set_response(false,'Failed create new record because '.$errors);
            }
            
            $data = $validator->validated();

            if(!empty(@$data['is_public'])){
                $data['is_public'] = 1;
            }else{
                $data['is_public'] = 0;
            }

            if(isset($data['thumbnail'])){
                $data['thumbnail'] = $this->upload($data['thumbnail'], config('standard.upload_image_path.blogs'));
            }

            $result = BlogsModel::create($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was added', 'success']);
            return $this->set_response(true,'blogs was created',['id'=>$result->id],route('admin.blogs.detail',$result->id));
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }

    public function update(Request $request, $param = null){
        DB::beginTransaction();
        try{
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'short_description' => 'required',
                'description' => 'required',
                'is_public' => '',
                'thumbnail' => '',
            ],  [
                'required' => ':attribute is required',
            ]);
    
            if ($validator->fails()) {
                $errors = $this->parseValidator($validator);
                return $this->set_response(false,'Failed create new record because '.$errors);
            }
            
            $data = $validator->validated();

            $detail = BlogsModel::find($param);

            if(!empty(@$data['is_public'])){
                $data['is_public'] = 1;
            }else{
                $data['is_public'] = 0;
            }

            if(isset($data['thumbnail'])){
                $data['thumbnail'] = $this->upload($data['thumbnail'], config('standard.upload_image_path.blogs'), null, @$detail['thumbnail']);
            }

            $result = $detail->update($data);

            DB::commit();
            Session::put('flash_message',['Success','new record was updated', 'success']);
            return $this->set_response(true,'blogs was updated',['id'=>$param],route('admin.blogs.detail',$param));
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
            
            BlogsModel::whereIn('id', $data)->delete();

            DB::commit();
            Session::put('flash_message',['Success','record was deleted', 'success']);
            return redirect()->route('admin.blogs');
        }catch(Exception $exception){
            DB::rollback();
            return $this->set_response(false,'Failed create new record because '.$exception->getMessage());
        }
    }
}
