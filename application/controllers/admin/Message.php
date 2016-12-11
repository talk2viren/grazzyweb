<?php

class Message extends Admin_Controller { 
    
    function __construct()
    {       
        parent::__construct();
        
        $this->auth->check_access('Admin', true);
        $this->load->model('Message_model');
    }
	
    function index($id){
		$this->load->model('Restaurant_model');
		$restaurant = $this->Restaurant_model->get_restaurant($id);
		$data['page_title'] = 'Message to '.$restaurant->restaurant_name;
        $data['messages'] = $this->Message_model->get_restmessage($id);
        $this->view($this->config->item('admin_folder').'/restmessage', $data);
	}
    function restmessage()
    {       
		$data['page_title'] = 'Message to restaurants';
        $data['messages'] = $this->Message_model->get_restmessages();
		$data['restaurants'] = $this->Message_model->get_restaurants();
        $this->view($this->config->item('admin_folder').'/restmessage', $data);
    }
   
   function messagerest(){
	   $data = $this->input->post();
	    $id = $this->Message_model->get_messagerest($data);
		if($id > 0){
			redirect('admin/message/restmessage');
		}
   }
}