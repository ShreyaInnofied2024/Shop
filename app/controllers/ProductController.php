<?php
class ProductController extends Controller{
    private $product;
    private $category;
    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
        $this->product=$this->model('ProductModel');
        $this->category=$this->model('CategoryModel');
    }

    public function index(){
        $products=$this->product->getProducts();
        $data=[
            'products'=>$products
        ];
        $this->view('product/index',$data);
    }


    public function add(){
        if(!isAdmin()){
            redirect('productController/index');
        }

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_PRODUCT=filter_input_array(INPUT_POST);
        $data=[
            'name'=>trim($_PRODUCT['name']),
            'quantity'=>trim($_PRODUCT['quantity']),
            'price' =>trim($_PRODUCT['price']),
            'type'=>trim($_PRODUCT['type']),
            'category'=>trim($_PRODUCT['category_id']),
            'name_err'=>'',
            'quantity_err'=>'',
            'price_err'=>'',
            'type_err'=>'',
            'category_err'=>''
        ];

        if(empty($data['name'])){
            $data['name_err']='Please enter name of product';
        }
        if(empty($data['quantity'])){
            $data['quantity_err']='Please enter quantity of product';
        }
        if(empty($data['price'])){
            $data['price_err']='Please enter price of product';
        }
        if(empty($data['type'])){
            $data['type_err']='Please enter type of product';
        }
        if(empty($data['category'])){
            $data['category_err']='Please enter category of product';
        }
        if(empty($data['name_err']) && empty($data['quantity_err']) && empty($data['price_err']) && empty($data['type_err']) && empty($data['category_err'])){

        if($this->product->add($data)){
            if($this->category->updateCategoryQuantityOnAdd($data['category'], $data['quantity'])) {
            flash('product_message',"Product Added");
            redirect('productController');
        }
    }
    else{
            die('Something went wrong');
        }
        }else{
            $this->view('product/add',$data);
        }
    }
        else{
            $category=$this->category->getCategory();
            $data=[
                'name'=>'',
                'quantity'=>'',
                'price' =>'',
                'type'=>'',
                'category'=>$category,
                'name_err'=>'',
                'quantity_err'=>'',
                'price_err'=>'',
                'type_err'=>'',
                'category_err'=>''
            ];
            $this->view('product/add',$data);
        }
    }



public function show($id){
    $product=$this->product->getProductById($id);
    $data=[
        'product'=>$product
    ];
    $this->view('product/show',$data);
}



public function edit($id){
    if(!isAdmin()){
        redirect('productController/index');
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $_PRODUCT=filter_input_array(INPUT_POST);
    $data=[
        'id'=>$id,
        'name'=>trim($_PRODUCT['name']),
        'quantity'=>trim($_PRODUCT['quantity']),
        'price' =>trim($_PRODUCT['price']),
        'type' =>trim($_PRODUCT['type']),
        'category'=>trim($_PRODUCT['category_id']),
        'name_err'=>'',
        'quantity_err'=>'',
        'price_err'=>'',
        'type_err'=>'',
        'category_err'=>''
    ];
    if(empty($data['name'])){
        $data['name_err']='Please enter name of product';
    }
    if(empty($data['quantity'])){
        $data['quantity_err']='Please enter quantity of product';
    }
    if(empty($data['price'])){
        $data['price_err']='Please enter price of product';
    }
    if(empty($data['type'])){
        $data['type_err']='Please enter type of product';
    }
    if(empty($data['category'])){
        $data['category_err']='Please enter category of product';
    }
    if(empty($data['name_err']) && empty($data['quantity_err']) && empty($data['price_err']) && empty($data['type_err']) && empty($data['category_err'])){
    if($this->product->edit($data)){
        if($this->category->updateCategoryQuantityOnAdd($data['category'], $data['quantity'])) {
        flash('product_message',"Product Updated");
        redirect('productController');
    }
}else{
        die('Something went wrong');
    }
    }else{
        $this->view('product/edit',$data);
    }
}
    else{
        $product=$this->product->getProductById($id);
        $category=$this->category->getCategory();
        $data=[
            'id' =>$id,
            'name'=>$product->name,
            'quantity'=>$product->quantity,
            'price' =>$product->price,
            'type'=>$product->type,
            'category'=>$product->category_id,
            'categories'=>$category,
            'name_err'=>'',
            'quantity_err'=>'',
            'price_err'=>'',
            'type_err'=>'',
            'category_err'=>''
        ];
        $this->view('product/edit',$data);
    }
}

public function delete($id){
    if(!isAdmin()){
        redirect('productController/index');
    }else{
        $product=$this->product->getProductById($id);
        if($this->product->delete($id)){
            if($this->category->updateCategoryQuantityOnDelete($product->category_id, $product->quantity)) {
            flash('product_message','Product deleted');
            redirect('productController');
        }else{
            die("Something went wrong");
        }
    }
    }
}

    public function digital(){
        $products=$this->product->getProductByType('Digital');
        $data=[
            'products'=>$products
        ];
        $this->view('product/digital',$data);
    }

    public function physical(){
        $products=$this->product->getProductByType('Physical');
        $data=[
            'products'=>$products
        ];
        $this->view('product/physical',$data);
    }
}

