<?php
class Slider_ctrl extends CI_controller
{
	public $profile_folder,$data,$adminid;
    public function __construct()
    {
     	parent::__construct();        
        $this->data=array();
        $this->load->model(array('Slider_model'=>'slider_model'));
        $this->load->library('form_validation');
    }
    public function slider_view()
    {
        $this->data['URL_TITLE']='Add Slider';
        $this->data['main_title']='Add Slider';
        $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' => 'dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Slider', 'link' => 'javascript:void(0);'.'add/Slider/', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Slider', 'link' =>'javascript:void(0);', 'class' => 'active', 'icon' => ''),
        );
      $this->data['breadcrumb'] = json_encode($breadcrumb_array);
        $this->load->view('add_slider', $this->data);   
    }
	public function insert_slider()
	{
		$this->load->helper('file');
		//$this->load->library('form_validation');
		if($this->input->post('btn_slider_submit'))
		{
			//echo "hi..slider..viru";
			$config['upload_path']='uploads';
			$config['allowed_types']='gif|png|jpg|jpeg';
			$config['file_name']=rand(1000,9999);
			$this->load->library('upload',$config);

			$arr=array(
					   array('field'=>'slider_title',
					   		 'label'=>'',
					   		 'rules'=>'required|trim',
					   		 'errors'=>array('required'=>'Slider title is required')),
					   array('field'=>'slider_url',
					   		 'label'=>'',
					   		 'rules'=>'required|trim',
					   		 'errors'=>array('required'=>'Slider url is required')),
					   // array('field'=>'slider_image',
					   // 		 'label'=>'',
					   // 		 'rules'=>'required',
					   // 		 'errors'=>array('required'=>'Slider image is required')),
					   array('field'=>'slider_desc',
					   		 'label'=>'',
					   		 'rules'=>'required|trim',
					   		 'errors'=>array('required'=>'Description is required'))
				);
			$this->form_validation->set_rules($arr);
			if($this->form_validation->run()==false)
			{
				$this->slider_view();
			}
			else
			{
				if($this->upload->do_upload('slider_image'))
				{
					$data=$this->upload->data();
					$docs_path = base_url()."uploads/".$data['raw_name'].$data['file_ext'];echo "<br>";
				 	$slider_desc=$this->input->post('slider_desc');echo "<br>";
				 	$slider_url=$this->input->post('slider_url');echo "<br>";
				 	$added_by=1;echo "<br>";
				 	$added_on=DATE;echo "<br>";
				 	$slider_status=1;
					$slider_title=$this->input->post('slider_title');echo "<br>";
					$data=array('slider_title'=>$slider_title,
							'slider_img'=>$docs_path,
							'slider_desc'=>$slider_desc,
							'slider_url'=>$slider_url,
							'added_by'=>$added_by,
							'added_on'=>$added_on,
							'slider_status'=>$slider_status);
					$rs=$this->slider_model->insert_slider_img($data);
					if($rs==1)
					{
						$data['msg']="Slider added into DB successfully";
					}
					if($rs==2)
					{
						$data['msg']="Slider not added..";
					}
					if($rs==3)
					{
						$data['msg']="Slider already existed";
					}
					$breadcrumb_array = array(
            		array('title' => 'Dashboard', 'link' => 'dashboard', 'class' => '', 'icon' => ''),
            		array('title' => 'Add Slider', 'link' => 'javascript:void(0);'.'add/Slider/', 'class' => 'active', 'icon' => ''),
            		array('title' => 'list Slider', 'link' =>'javascript:void(0);', 'class' => 'active', 'icon' => ''),
        				);
					$data['main_title']='Add Slider';
					$data['breadcrumb'] = json_encode($breadcrumb_array);
					$this->load->view('add_slider',$data);
				}
				else
				{
					$breadcrumb_array = array(
            		array('title' => 'Dashboard', 'link' => 'dashboard', 'class' => '', 'icon' => ''),
            		array('title' => 'Add Slider', 'link' => 'javascript:void(0);'.'add/Slider/', 'class' => 'active', 'icon' => ''),
            		array('title' => 'list Slider', 'link' =>'javascript:void(0);', 'class' => 'active', 'icon' => ''),
        				);
					$data['upload_error']=$this->upload->display_errors();
					$data['main_title']='Add Slider';
					$data['breadcrumb'] = json_encode($breadcrumb_array);
					$this->load->view('add_slider',$data);
				}
			}
		}
		
	}
}
?>