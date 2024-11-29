<?php
class UserController extends Controller{
    private $user;
    public function __construct()
    {
        $this->user=$this->model('UserModel');
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_USER=filter_input_array(INPUT_POST);
            $data=[
                'name'=>trim($_USER['name']),
                'email'=>trim($_USER['email']),
                'password'=>trim($_USER['password']),
                'name_err'=>'',
                'email_err' =>'',
                'password_err'=>''
            ];

            if(empty($data['email'])){
                $data['email_err']='Please enter email';
            }else{
                if($this->user->findUserByEmail($data['email'])){
                    $data['email_err']='Email is already taken';
                }
            }
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter name';
              }
      
              if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
              } elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 characters';
              }
              if(empty($data['email_err']) && empty($data['password_err']) && empty($data['name_err'])){
                $data['password']=password_hash($data['password'],PASSWORD_DEFAULT);
                if($this->user->register($data)){
                    flash('Register_Success','You are registered and can log in');
                    redirect('userController/login');
                }else{
                    die('something went wrong');
                }
            }else{
                    $this->view('user/register',$data);
                }
              }
        else{
            $data=[
                'name'=>'',
                'email' =>'',
                'password' =>'',
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>''
            ];
            $this->view('user/register',$data);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_USER = filter_input_array(INPUT_POST);
            $data = [
                'email' => trim($_USER['email']),
                'password' => trim($_USER['password']),
                'email_err' => '',
                'password_err' => ''
            ];
    
            // Validate email and password
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if (!$this->user->findUserByEmail($data['email'])) {
                    $data['email_err'] = "No user found";
                }
            }
    
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
    
            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->user->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    // Pass query parameters to createUserSession
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('user/login', $data);
                }
            } else {
                $this->view('user/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
    
            // Handle query parameters (if any)
            if (isset($_GET['redirect'], $_GET['product_id'])) {
                $data['redirect'] = $_GET['redirect'];
                $data['product_id'] = $_GET['product_id'];
            }
    
            $this->view('user/login', $data);
        }
    }
    

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->user_role;
    
        // Check for redirect context
        if (isset($_GET['redirect'], $_GET['product_id']) && $_GET['redirect'] == 'cart') {
            // Redirect to add product to cart
            redirect('cartController/add/' . $_GET['product_id']);
        } else {
            // Default redirect
            redirect('pageController/choose');
        }
    }
    
    
    

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect(URLROOT);
    }

    public function list(){
        $users=$this->user->getUsers();
        $data=[
            'users'=>$users
        ];
        $this->view('user/list',$data);
    }


    public function changePassword($email){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_USER=filter_input_array(INPUT_POST);
        $data=[
            'email'=>trim($_USER['email']),
            'password' =>trim($_USER['password']),
            'email_err'=>'',
            'password_err'=>''
        ];

        if(empty($data['email'])){
            $data['email_err'] = 'Please enter email';
        }else{
            if($this->user->findUserByEmail($data['email'])){

            }else{
                $data['email_err']="No user found";
            }
        }

        if(empty($data['password'])){
            $data['password_err'] = 'Please enter password';
          } elseif(strlen($data['password']) < 6){
            $data['password_err'] = 'Password must be at least 6 characters';
          }
    
        
        if(empty($data['email_err']) && empty($data['password_err'])){
        $data['password']=password_hash($data['password'],PASSWORD_DEFAULT);
        if($this->user->changePassword($data)){
            flash('user_message',"Password Changed");

        redirect('userController/login');
        }else{
            die('Something went wrong');
        }
        }else{
            $this->view('user/change_password',$data);
        }
    }
        else{
            $user=$this->user->findUserByEmail($email);
            $data=[
                'email'=>$email,
                'password' =>$user->password,
                'email_err'=>'',
                'password_err'=>''
            ];
            $this->view('user/change_password',$data);
        }
    }

    // AdminController.php or the relevant controller
public function deleteUser($id)
{
    // Check if the user is logged in and is an admin
    if ($_SESSION['user_role'] !== 'Admin') {
        header('Location: ' . URLROOT . '/userController');
        exit();
    }

    // Call the model to delete the user
    if ($this->user->deleteUserById($id)) {
        // Redirect to the users list page with success message
        redirect(URLROOT);
    } else {
        // Redirect with error message
        redirect(URLROOT);
    }
}

public function addAddress() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST);

        // Combine address fields
        $fullAddress = trim($_POST['line1']);
        if (!empty($_POST['line2'])) {
            $fullAddress .= ', ' . trim($_POST['line2']);
        }
        $fullAddress .= ', ' . trim($_POST['city']) . ', ' . trim($_POST['state']);
        $fullAddress .= ', ' . trim($_POST['zip']) . ', ' . trim($_POST['country']);

        // Prepare data for the model
        $addressData = [
            'user_id' => $_SESSION['user_id'], // Assuming user_id is stored in session
            'address' => $fullAddress,
        ];

        // Save address using the model
        if ($this->user->addAddress($addressData)) {
            flash('address_message', 'Address added successfully!');
            redirect('orderController/checkout');
        } else {
            flash('address_message', 'Something went wrong. Please try again.', 'alert alert-danger');
            redirect('orderController/checkout');
        }
    } else {
        redirect('orderController/checkout');
    }
}



}