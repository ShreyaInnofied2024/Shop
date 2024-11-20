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

    public function add()
    {
        if (!isAdmin()) {
            redirect('productController/index');
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle image upload
            $target_dir = getcwd()."/img/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
            // Check if the file is an image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                flash('product_message', 'File is not an image.', 'alert alert-danger');
                $uploadOk = 0;
            }
    
            // Check file size (e.g., limit to 5MB)
            if ($_FILES["image"]["size"] > 5000000) {
                flash('product_message', 'Sorry, your file is too large.', 'alert alert-danger');
                $uploadOk = 0;
            }
    
            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                flash('product_message', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.', 'alert alert-danger');
                $uploadOk = 0;
            }
    
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagePath = $target_file;
    
                    // Process product data
                    $_PRODUCT = filter_input_array(INPUT_POST);
                    $data = [
                        'name' => trim($_PRODUCT['name']),
                        'quantity' => trim($_PRODUCT['quantity']),
                        'price' => trim($_PRODUCT['price']),
                        'type' => trim($_PRODUCT['type']),
                        'category_id' => trim($_PRODUCT['category_id']),
                        'image_path' => $imagePath,
                        'name_err' => '',
                        'quantity_err' => '',
                        'price_err' => '',
                        'type_err' => '',
                        'category_err' => ''
                    ];
    
                    // Validate fields
                    if (empty($data['name'])) {
                        $data['name_err'] = 'Please enter the product name.';
                    }
                    if (empty($data['quantity'])) {
                        $data['quantity_err'] = 'Please enter the product quantity.';
                    }
                    if (empty($data['price'])) {
                        $data['price_err'] = 'Please enter the product price.';
                    }
                    if (empty($data['type'])) {
                        $data['type_err'] = 'Please enter the product type.';
                    }
                    if (empty($data['category_id'])) {
                        $data['category_err'] = 'Please select a category.';
                    }
    
                    if (empty($data['name_err']) && empty($data['quantity_err']) && empty($data['price_err']) && empty($data['type_err']) && empty($data['category_err'])) {
                        // Add product to the database
                        if ($this->product->add($data)) {
                            flash('product_message', 'Product added successfully!');
                            redirect('productController');
                        } else {
                            flash('product_message', 'Something went wrong.', 'alert alert-danger');
                        }
                    } else {
                        // Load the form with validation errors
                        $this->view('product/add', $data);
                    }
                } else {
                    flash('product_message', 'Sorry, there was an error uploading your file.', 'alert alert-danger');
                }
            } else {
                flash('product_message', 'Image upload failed.', 'alert alert-danger');
            }
        } else {
            // Load the form
            $categories = $this->category->getCategory();
            $data = [
                'name' => '',
                'quantity' => '',
                'price' => '',
                'type' => '',
                'category_id' => '',
                'categories' => $categories,
                'image_path' => '',
                'name_err' => '',
                'quantity_err' => '',
                'price_err' => '',
                'type_err' => '',
                'category_err' => ''
            ];
            $this->view('product/add', $data);
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

