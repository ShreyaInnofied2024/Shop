<?php
class CategoryController extends Controller{
    private $category;
    private $product;
    public function __construct(){
        if(!isLoggedIn()){
            redirect('userController/login');
        }
        $this->category=$this->model('CategoryModel');

        $this->product=$this->model('ProductModel');
    }
    
    public function index(){
        $category=$this->category->getCategory();
        $data=[
            'category'=>$category
        ];
        $this->view('category/index',$data);
    }

    public function add(){
        if(!isAdmin()){
            redirect('categoryController/index');
        }

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_CATEGORY=filter_input_array(INPUT_POST);
        $data=[
            'name'=>trim($_CATEGORY['name']),
            'name_err'=>''
        ];

        if(empty($data['name'])){
            $data['name_err']='Please enter name of category';
        }
        if(empty($data['name_err'])){

        if($this->category->add($data)){
            flash('category_message',"Category Added");
            redirect('categoryController');
        }else{
            die('Something went wrong');
        }
        }else{
            $this->view('category/add',$data);
        }
    }
        else{
            $data=[
                'name'=>''
            ];
            $this->view('category/add',$data);
        }
    }

public function show($id){
    $category=$this->category->getCategoryById($id);
    $data=[
        'category'=>$category
    ];
    $this->view('category/show',$data);
}



public function delete($id){
    if(!isAdmin()){
        redirect('categoryController/index');
    }else{
        $category=$this->category->getCategoryById($id);
        if($this->category->delete($id)){
            if($this->product->deleteBycategory($category['id']))
            flash('category_message','Category deleted');
            redirect('categoryController');
        }else{
            die("Something went wrong");
        }
    }
    }
}

