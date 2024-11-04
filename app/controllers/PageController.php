<?php
class PageController extends Controller{
    public function __construct()
    {
    }
    
    public function index(){
        if(isLoggedIn()){
            redirect('pageController/choose');
        }       
             $data=[
            'title' => 'Welcome to shop',
            'description'=>'Simple shopping website built on the MVC PHP framework'
        ];
        $this->view('pages/index', $data);
    }
    public function choose(){     
             $data=[];
             $this->view('pages/choose', $data);
    }


    public function about(){
        $data = [
            'title' => 'About Us',
            'description' => 'App to shop anyhing'
          ];
        $this->view('pages/about',$data);
    }
}