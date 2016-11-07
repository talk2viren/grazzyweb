<?php

class Menus extends Admin_Controller {	
	
	private $use_inventory = false;
	
	function __construct()
	{		
		parent::__construct();
        
		$this->auth->check_access('Admin', true);
		
		$this->load->model(array('Menu_model'));
		$this->load->helper('form');
		$this->lang->load('product');
	}

	function index($res_id){
		
		$data['menus'] = $this->Menu_model->GetMenus($res_id);
		$this->view($this->config->item('admin_folder').'/menu', $data);
	}
	
	function form($menu_id=false){
		$config['upload_path']      = 'uploads/images/full';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = $this->config->item('size_limit');
        $config['max_width']        = '1024';
        $config['max_height']       = '768';
        $config['encrypt_name']     = true;
        $this->load->library('upload', $config);
        
        
      
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        $data['categories']     = $this->Category_model->get_categories_tiered();
		
		$data['menu_id']         = '';
		$data['menu']		= '';
        $data['price']      = '';
        $data['enabled']     = '';
		$data['image']          = '';
		$data['photos']     = array();
		$data['product_categories']	= array();
		
		if($menu_id){
			$menu       = $this->Menu_model->GetMenu($menu_id);

            //if the category does not exist, redirect them to the category list with an error
            if (!$menu)
            {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder').'/menus');
            }
			$data['menu']		= $menu->menu;
			$data['price']      = $menu->price;
			$data['enabled']       = $menu->enabled;
			$data['image']          = $menu->image;
			$data['menu'] = $this->Menu_model->GetMenu($menu_id);
			$data['menu_id'] =$menu_id;
			if(!$this->input->post('submit'))
			{
				
				$data['product_categories']	= array();
				foreach($menu->categories as $product_category)
				{
					$data['product_categories'][] = $product_category->id;
				}
				
			}
		}
		
		if(!is_array($data['product_categories']))
		{
			$data['product_categories']	= array();
		}
		
        $this->form_validation->set_rules('menu', 'lang:menu', 'trim|required|max_length[64]');
        $this->form_validation->set_rules('price', 'lang:price', 'trim');
		$this->form_validation->set_rules('image', 'lang:image', 'trim');
		 
		if($this->input->post('submit'))
		{
			$data['product_categories']	= $this->input->post('categories');
		}
		
		if ($this->form_validation->run() == FALSE)
        {
            $this->view($this->config->item('admin_folder').'/menu_form', $data);
        }
        else
        {
			$uploaded   = $this->upload->do_upload('image');
            
            if ($menu_id)
            {
                //delete the original file if another is uploaded
                if($uploaded)
                {
                    
                    if($data['image'] != '')
                    {
                        $file = array();
                        $file[] = 'uploads/images/full/'.$data['image'];
                        $file[] = 'uploads/images/medium/'.$data['image'];
                        $file[] = 'uploads/images/small/'.$data['image'];
                        $file[] = 'uploads/images/thumbnails/'.$data['image'];
                        
                        foreach($file as $f)
                        {
                            //delete the existing file if needed
                            if(file_exists($f))
                            {
                                unlink($f);
                            }
                        }
                    }
                }
                
            }
            
            if(!$uploaded)
            {
                $data['error']  = $this->upload->display_errors();
                if($_FILES['image']['error'] != 4)
                {
                    $data['error']  .= $this->upload->display_errors();
                    $this->view($this->config->item('admin_folder').'/menu_form', $data);
                    return; //end script here if there is an error
                }
            } else
            {
                $image          = $this->upload->data();
                $save['image']  = $image['file_name'];
                
                $this->load->library('image_lib');
                
                //this is the larger image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/images/full/'.$save['image'];
                $config['new_image']    = 'uploads/images/medium/'.$save['image'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 600;
                $config['height'] = 500;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //small image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/images/medium/'.$save['image'];
                $config['new_image']    = 'uploads/images/small/'.$save['image'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 300;
                $config['height'] = 300;
                $this->image_lib->initialize($config); 
                $this->image_lib->resize();
                $this->image_lib->clear();

                //cropped thumbnail
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/images/small/'.$save['image'];
                $config['new_image']    = 'uploads/images/thumbnails/'.$save['image'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 30;
                $config['height'] = 30;
                $this->image_lib->initialize($config);  
                $this->image_lib->resize(); 
                $this->image_lib->clear();
            }
			$save['menu_id']         = $menu_id;
			$save['menu'] 		=  $this->input->post('menu');
            $save['price']      = $this->input->post('price');
            $save['enabled']     = $this->input->post('enabled');
			//save categories
			$categories			= $this->input->post('categories');
			if(!$categories)
			{
				$categories	= array();
			}
			
			$category_id    = $this->Menu_model->save($save,$categories);
			redirect($this->config->item('admin_folder').'index/menu_form');
		}
	}
}
