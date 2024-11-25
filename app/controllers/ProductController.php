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
        $_PRODUCT = filter_input_array(INPUT_POST);

        // Process product data
        $data = [
            'name' => trim($_PRODUCT['name']),
            'quantity' => trim($_PRODUCT['quantity']),
            'price' => trim($_PRODUCT['price']),
            'type' => trim($_PRODUCT['type']),
            'category_id' => trim($_PRODUCT['category_id']),
            'name_err' => '',
            'quantity_err' => '',
            'price_err' => '',
            'type_err' => '',
            'category_err' => ''
        ];

        // Validate input
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

        // Check for validation errors
        if (empty($data['name_err']) && empty($data['quantity_err']) && empty($data['price_err']) && empty($data['type_err']) && empty($data['category_err'])) {
            // Add product to the database
            $productId = $this->product->add($data);
            if ($productId) {
                $target_dir = getcwd() . "/img/";
                $uploadedFiles = $_FILES['images']; // Assuming multiple files are uploaded under "images"
                $fileCount = count($uploadedFiles['name']);

                for ($i = 0; $i < $fileCount; $i++) {
                    $imageFileType = strtolower(pathinfo($uploadedFiles['name'][$i], PATHINFO_EXTENSION));
                    $uniqueImageName = $productId . "_image" . ($i + 1) . "." . $imageFileType; // Use product ID with an index for uniqueness
                    $target_file = $target_dir . $uniqueImageName;

                    $uploadOk = 1;
                    $check = getimagesize($uploadedFiles['tmp_name'][$i]);
                    if ($check === false) {
                        flash('product_message', 'File ' . $uploadedFiles['name'][$i] . ' is not an image.', 'alert alert-danger');
                        $uploadOk = 0;
                        continue;
                    }

                    if ($uploadedFiles['size'][$i] > 5000000) {
                        flash('product_message', 'File ' . $uploadedFiles['name'][$i] . ' is too large.', 'alert alert-danger');
                        $uploadOk = 0;
                        continue;
                    }

                    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        flash('product_message', 'File ' . $uploadedFiles['name'][$i] . ' has an invalid format.', 'alert alert-danger');
                        $uploadOk = 0;
                        continue;
                    }

                    if ($uploadOk == 1) {
                        if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $target_file)) {
                            $imagePath = "img/" . $uniqueImageName;
                            $this->product->addImage($productId, $imagePath); // Add the image path to the database
                        } else {
                            flash('product_message', 'Error uploading file ' . $uploadedFiles['name'][$i], 'alert alert-danger');
                        }
                    }
                }

                flash('product_message', 'Product and images added successfully!');
                redirect('productController');
            } else {
                flash('product_message', 'Something went wrong while adding the product.', 'alert alert-danger');
            }
        } else {
            // Load the form with validation errors
            $this->view('product/add', $data);
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
            'name_err' => '',
            'quantity_err' => '',
            'price_err' => '',
            'type_err' => '',
            'category_err' => ''
        ];
        $this->view('product/add', $data);
    }
}


    

public function show($id) {
    // Get the product by its ID
    $product = $this->product->getProductById($id);
    
    // Get the images associated with the product
    $images = $this->product->getImagesByProductId($id);

    // Prepare the data array to pass to the view
    $data = [
        'product' => $product,
        'images' => $images // Include images in the data array
    ];

    // Load the view and pass the data
    $this->view('product/show', $data);
}




public function edit($id)
{
    if (!isAdmin()) {
        redirect('productController/index');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_PRODUCT = filter_input_array(INPUT_POST);
        $data = [
            'id' => $id,
            'name' => trim($_PRODUCT['name']),
            'quantity' => trim($_PRODUCT['quantity']),
            'price' => trim($_PRODUCT['price']),
            'type' => trim($_PRODUCT['type']),
            'category' => trim($_PRODUCT['category_id']),
            'name_err' => '',
            'quantity_err' => '',
            'price_err' => '',
            'type_err' => '',
            'category_err' => '',
            'image_err' => ''
        ];

        // Validate product fields
        if (empty($data['name'])) {
            $data['name_err'] = 'Please enter the name of the product';
        }
        if (empty($data['quantity'])) {
            $data['quantity_err'] = 'Please enter the quantity of the product';
        }
        if (empty($data['price'])) {
            $data['price_err'] = 'Please enter the price of the product';
        }
        if (empty($data['type'])) {
            $data['type_err'] = 'Please enter the type of the product';
        }
        if (empty($data['category'])) {
            $data['category_err'] = 'Please select a category for the product';
        }

        // Validate images (if new images are uploaded)
        $uploadedImages = [];
        if (!empty($_FILES['images']['name'][0])) {
            $target_dir = getcwd() . "/img/";

            // Process each uploaded image
            foreach ($_FILES['images']['name'] as $key => $imageName) {
                $target_file = $target_dir . $id . "_image_" . time() . "_" . $key . "." . pathinfo($imageName, PATHINFO_EXTENSION);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Validate file type
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $data['image_err'] = 'Invalid image file type. Only JPG, JPEG, PNG, and GIF are allowed.';
                    break;
                }

                // Validate file size (e.g., 5MB max)
                if ($_FILES['images']['size'][$key] > 5000000) {
                    $data['image_err'] = 'Image file size must not exceed 5MB.';
                    break;
                }

                // Move uploaded file
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                    // Prepare image data for saving in the database
                    $uploadedImages[] = 'img/' . basename($target_file); // Only store the image path as string
                } else {
                    $data['image_err'] = 'Failed to upload image.';
                    break;
                }
            }
        }

        // If there are no validation errors, proceed with the update
        if (empty($data['name_err']) && empty($data['quantity_err']) && empty($data['price_err']) && empty($data['type_err']) && empty($data['category_err']) && empty($data['image_err'])) {
            // Update the product in the database
            if ($this->product->update($data)) {
                // Update category quantity if necessary
                if ($this->category->updateCategoryQuantityOnAdd($data['category'], $data['quantity'])) {
                    // Save uploaded images to the database
                    foreach ($uploadedImages as $imagePath) {
                        // Make sure only the image path is saved as a string
                        $this->product->addImage($id, $imagePath); // Add image path to the database
                    }

                    flash('product_message', 'Product updated successfully!');
                    redirect('productController');
                }
            } else {
                die('Something went wrong.');
            }
        } else {
            // Load the form with validation errors
            $data['existing_images'] = $this->product->getImagesByProductId($id); // Get existing images
            $data['categories'] = $this->category->getCategory(); // Get categories
            $this->view('product/edit', $data);
        }
    } else {
        // Load product and existing images
        $product = $this->product->getProductById($id);
        $images = $this->product->getImagesByProductId($id);
        $categories = $this->category->getCategory();

        $data = [
            'id' => $id,
            'name' => $product->name,
            'quantity' => $product->quantity,
            'price' => $product->price,
            'type' => $product->type,
            'category' => $product->category_id,
            'categories' => $categories,
            'existing_images' => $images,
            'name_err' => '',
            'quantity_err' => '',
            'price_err' => '',
            'type_err' => '',
            'category_err' => '',
            'image_err' => ''
        ];

        $this->view('product/edit', $data);
    }
}


public function delete($id) {
    if (!isAdmin()) {
        redirect('productController/index');
    } else {
        // Get the product and its associated images
        $product = $this->product->getProductById($id);
        $images = $this->product->getImagesByProductId($id); // Assuming you have a method to get images by product ID

        // Delete all images using the existing deleteImage function
        foreach ($images as $image) {
            $this->deleteImage($image->id); // Call the existing deleteImage method to delete the image
        }

        // Now, delete the product itself from the database
        if ($this->product->delete($id)) {
            // Update category quantity if necessary
            if ($this->category->updateCategoryQuantityOnDelete($product->category_id, $product->quantity)) {
                flash('product_message', 'Product and associated images deleted successfully');
                redirect('productController');
            } else {
                die("Something went wrong with category update");
            }
        } else {
            die("Something went wrong with product deletion");
        }
    }
}


public function digital() {
    // Get digital products with one associated image
    $products = $this->product->getDigitalProductsWithImages();
    
    // Prepare data for the view
    $data = [
        'products' => $products
    ];
    
    // Pass the data to the view
    $this->view('product/digital', $data);
}

public function physical() {
    // Get digital products with one associated image
    $products = $this->product->getPhysicalProductsWithImages();
    
    // Prepare data for the view
    $data = [
        'products' => $products
    ];
    
    // Pass the data to the view
    $this->view('product/physical', $data);
}

public function allProducts($page = 1) {
    $productsPerPage = 4; 
    $offset = ($page - 1) * $productsPerPage;

    $products = $this->product->getPaginatedProductsWithSingleImages($productsPerPage, $offset);
    $totalProducts = $this->product->getTotalProductsCount();
    $totalPages = ceil($totalProducts / $productsPerPage);
    $categories=$this->product->getAllCategories();

    $data = [
        'products' => $products,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'categories'=>$categories
    ];

    if ($this->isAjax()) {
        $this->view('product/product_partial', $data);
    } else {
        $this->view('product/customer_product', $data);
    }
}

private function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}





   
    public function deleteImage($imageId)
    {
        if (!isAdmin()) {
            redirect('productController/index');
        }
    
        // Get the image details from the database
        $image = $this->product->getImageById($imageId);
    
        if ($image) {
            $imagePath = getcwd() . '/' . $image->image_path;
    
            // Delete the image file from the server
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
    
            // Delete the image record from the database
            if ($this->product->deleteImageById($imageId)) {
                flash('product_message', 'Image deleted successfully.');
            } else {
                flash('product_message', 'Failed to delete image from the database.', 'alert alert-danger');
            }
        } else {
            flash('product_message', 'Image not found.', 'alert alert-danger');
        }
    
        // Redirect back to the edit page
        redirect('productController/edit/' . $image->product_id);
    }
    
}

