<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FrontController extends Controller
{
    //

    public $blog_name = 'MySimpleBlog';

    public function getIndex() {

    	$data['page_title'] = 'Home - Blog';
    	$data['page_description'] = 'This is my simple blog';
    	$data['blog_name'] = $this->blog_name;
    	$data['categories'] = DB::table('categories')->get();

    	$data['result'] = DB::table('posts')
    	->join('categories','categories.id','=','categories_id')
    	->join('cms_users','cms_users.id','=','cms_users_id')
    	->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
    	->orderby('posts.id','desc')
    	->take(5)
    	->get();

    	return view('home',$data);
    }

    public function getArticle($slug) {

    	$row = DB::table('posts')
    	->join('categories','categories.id','=','categories_id')
    	->join('cms_users','cms_users.id','=','cms_users_id')
    	->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
    	->where('posts.slug',$slug)
    	->first();
    	$data['row'] = $row;
    	$data['page_title'] = $row->title.' | MySimpleBlog';
    	$data['page_description'] = str_limit(strip_tags($row->content),155);
    	$data['blog_name'] = $this->blog_name;
    	$data['categories'] = DB::table('categories')->get();

    	return view('detail',$data);
    }

    public function getCategory($id,$slug) {
    	$row = DB::table('categories')->where('id',$id)->first();

    	if(!$row) return redirect('/');

    	$data['result'] = DB::table('posts')
    	->join('categories','categories.id','=','categories_id')
    	->join('cms_users','cms_users.id','=','cms_users_id')
    	->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
    	->orderby('posts.id','desc')
    	->where('posts.categories_id',$id)
    	->paginate(5);

    	$data['row'] = $row;
    	$data['page_title'] = $row->name.' | Category | MySimpleBlog';
    	$data['page_description'] = $data['page_title'];
    	$data['blog_name'] = $this->blog_name;
    	$data['categories'] = DB::table('categories')->get();
    	$data['header_title'] = 'Category: '.$row->name;

    	return view('lists',$data);
    }

    public function getLatest() {    	

    	$data['result'] = DB::table('posts')
    	->join('categories','categories.id','=','categories_id')
    	->join('cms_users','cms_users.id','=','cms_users_id')
    	->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
    	->orderby('posts.id','desc')    	
    	->paginate(5);
    	
    	$data['page_title'] = 'Latest | MySimpleBlog';
    	$data['page_description'] = $data['page_title'];
    	$data['blog_name'] = $this->blog_name;
    	$data['categories'] = DB::table('categories')->get();
    	$data['header_title'] = 'Latest';

    	return view('lists',$data);
    }

    public function getSearch(Request $req) {    	

    	if($req->get('q')=='') return redirect('/');

    	$data['result'] = DB::table('posts')
    	->join('categories','categories.id','=','categories_id')
    	->join('cms_users','cms_users.id','=','cms_users_id')
    	->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
    	->where('posts.title','like','%'.$req->get('q').'%') 	
    	->paginate(5);
    	
    	$data['page_title'] = 'Search '.$req->get('q').' | MySimpleBlog';
    	$data['page_description'] = $data['page_title'];
    	$data['blog_name'] = $this->blog_name;
    	$data['categories'] = DB::table('categories')->get();
    	$data['header_title'] = 'Search: '.$req->get('q');

    	return view('lists',$data);
    }
}
