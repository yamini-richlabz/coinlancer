<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_controller
{
	public function __construct() {
        parent::__construct();
        $this->load->model('Category_model');
		 $this->load->library("pagination");
	 }
	                                      // Categories//
	 // ** Adding Categories//
	  public function category_view()
    {
        $this->data['URL_TITLE']='Add Category';
        $this->data['main_title']='Add Category';
        $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>  ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Category', 'link' => ADMIN_PATH.'master/category_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Category', 'link' => ADMIN_PATH.'master/list_category', 'class' => 'active', 'icon' => ''),
        );
     $this->data['breadcrumb'] = json_encode($breadcrumb_array);
        $this->load->view('add_category', $this->data);   
    }
	 public function add_category(){	
		// print_r($_POST); exit;
		 $inputData =file_get_contents('php://input');
		 if (isJson($inputData))
        {
				 $request=json_decode($inputData);
				$category=$request->category_name;
				//print_r($category); exit;
				$logwith=$request->is_mobile;
				$error=0;
				$err_mesg="";
				 if(is_array($category))
				 {
					   $insertdata=array();
					   $duplicateData='';
						   $insertdataArray=array();
						   $dataArray=array_unique($category);
					 foreach($dataArray as $res)
					 {
						$checkDuplicate=$this->Crud->commonCheck('category_id','cl_category_tbl',array('category_name'=>$res)); 
						if($checkDuplicate == 0)
						{
							$insertdataArray[]=array(
													 'category_name' => $res,
													 'added_on'=>DATE,
													'added_by'=>1
													 );
						}
						else
						{
							$duplicateData.=$res.',';
						}
					 }
					 
					 $duplicateMessage=rtrim($duplicateData,',');
					 if(is_array($insertdataArray) && count($insertdataArray))
					 {
							  $insertdata=$insertdataArray;
						 
							$checkedSql=$this->Crud->batchInsert('cl_category_tbl',$insertdata);
							 $checkedReq=json_decode($checkedSql);
							$response[CODE]=$checkedReq->code;
							$response[MESSAGE]=$checkedReq->message;
							$response[DESCRIPTION]=$checkedReq->description;	
					  }
					  else
					  {
							$response[CODE]=204;
							$response[MESSAGE]='Fail';
							$response[DESCRIPTION]='Already category name was entered';
					  }
					$response['duplicate']=$duplicateMessage;
					 
				 }
				 else
				 {
					 
							$response['code']=204;
							$response['message']='Validation';
							$response['description']='Input data expecting in array format.';
				 }
		}
		else
		{
					$response['code']=301;
					$response['message']='Validation';
					$response['description']='Accepts Json Data only';
		}
echo json_encode($response);
		        }
   // ** Listing Categories//
	public function list_category()
	{
		$data=array();
		 $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Category', 'link' => ADMIN_PATH.'master/category_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Category', 'link' => ADMIN_PATH.'master/list_category', 'class' => 'active', 'icon' => ''),
                    ); 
	$params['table']='cl_category_tbl';
	$getrecs=json_decode($this->Category_model->getting_records($params));
		if($getrecs->code==SUCCESS_CODE)
		{
			$recs=$getrecs->num_rows;
			$config=array();
			$config['base_url']=ADMIN_PATH.'master/list_category';
			$config['total_rows']=$recs;
			$config['uri_segment']=4;
			$config['per_page']=20;
			$config['cur_tag_open'] = '<a href="#" class="active">';//this is active tab
			$config['cur_tag_close'] = '</a>';
			$this->pagination->initialize($config);
			$seg=$this->uri->segment(4);
			if(!empty($seg))
				$si=$seg;
			else
				$si=0;
			$params['si']=$si;
			$params['nr']=20;
		$params['order_by_cols']='category_id';
		$result=$this->Category_model->getting_records($params); 
		// print_r($result); exit;
		$res=json_decode($result);
		$result1=($res->result); 
		$this->data['limit']=$config['per_page'];
		if($res->code==SUCCESS_CODE)
		{
			$this->data['records']=$result1;
			$this->data['per']=$res->num_rows;
			$this->data['total']=$recs;
			$this->data['si']=$si;
			$this->data['main_title']='Manage Categories';
			$this->data['URL_TITLE']='Mange Category';
			$this->data['breadcrumb'] = json_encode($breadcrumb_array);
           $this->load->view('list_category', $this->data);
		}
		}
		else{
		$this->data['breadcrumb'] = json_encode($breadcrumb_array);
		$this->data['URL_TITLE']='Mange Category';
		$this->data['main_title']='Manage Categories';
        $this->load->view('list_category', $this->data);
		}
	}
	// ** searching Categories//
	public function search_category()
	{
		// print_r($_POST); exit;
		$data=array();
		 $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Category', 'link' => ADMIN_PATH.'master/category_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Category', 'link' => ADMIN_PATH.'master/list_category', 'class' => 'active', 'icon' => ''),
                    );
		$input=$this->input->post('search_name');
		// echo $input; exit;
		if(empty($input))
			$input=$this->uri->segment(4);
	$params['table']='cl_category_tbl';
	$params['search']=array(
			'input'=>$input,
			'join_col'=>'category_name'
		);
	$getrecs=json_decode($this->Category_model->getting_records($params));
	// print_r($getrecs); exit;
		if($getrecs->code==SUCCESS_CODE)
		{
			$recs=$getrecs->num_rows;
			$config=array();
			$config['base_url']=ADMIN_PATH."master/search_category/$input";
			$config['total_rows']=$recs;
			$config['uri_segment']=5;
			$config['per_page']=20;
			$config['cur_tag_open'] = '<a href="#" class="active">';//this is active tab
			$config['cur_tag_close'] = '</a>';
			$this->pagination->initialize($config);
			$seg=$this->uri->segment(5);
			if(!empty($seg))
				$si=$seg;
			else
				$si=0;
			$params['si']=$si;
			$params['nr']=20;
		$params['order_by_cols']='category_id';
		$params['search']=array(
			'input'=>$input,
			'join_col'=>'category_name'
		);
		$result=$this->Category_model->getting_records($params); 
		// print_r($result); exit;
		$res=json_decode($result);
		$result1=($res->result); 
		$this->data['limit']=$config['per_page'];
		if($res->code==SUCCESS_CODE)
		{
			$this->data['records']=$result1;
			$this->data['per']=$res->num_rows;
			$this->data['total']=$recs;
			$this->data['si']=$si;
			$this->data['main_title']='Manage Categories';
			$this->data['URL_TITLE']='Mange Category';
			$this->data['breadcrumb'] = json_encode($breadcrumb_array);
           $this->load->view('list_category', $this->data);
		}
		}
		else{
		$this->data['breadcrumb'] = json_encode($breadcrumb_array);
		$this->data['URL_TITLE']='Mange Category';
		$this->data['main_title']='Manage Categories';
        $this->load->view('list_category', $this->data);
		}
	}
	// ** changing the status of category //
	 public function commonStatusActivity()
    {
       
        $response = array();
       $tablename = $this->input->post('tablename');
       $updatelist = $this->input->post('updatelist');
        $activity = $this->input->post('activity');
        if ($tablename != '' && $updatelist != '' && $activity != '' && ($activity == 0 || $activity == 1 || $activity == 2)) {
            $table= '';
            $setcolumns = '';
            $wherecondition = '';
            $updatevalue = '';
            switch ($tablename) {
            case 'category_name':   // need to refer name for table name
              $table='cl_category_tbl';   // table name 
              $setcolumns='category_status';
              $updatevalue=$activity;
              $wherecondition="category_id  IN  (" .$updatelist. ")";
              break;
           
            }
           $update = $this->Crud->commonStatusActivity($table, $setcolumns, $updatevalue, $wherecondition);
            echo $update;
            exit;
        }
        echo json_encode($response);
        }
		// ** Deleting Categories//
public function commonDelete()
	{	
		$response = array();
		$tablename = $this->input->post('tablename');
		$updatelist = $this->input->post('updatelist');
		$relationname='category_name';
		if ($tablename != '') {
		    $table = '';
		    $wherecondition = '';
		    switch ($tablename) {
		    case 'category_name':
			    $table = 'cl_category_tbl';
				$wherecondition = "category_id IN  (" . $updatelist . ")";
			    break;

			}
			//print_r($wherecondition);
			// echo $relationname; exit;
		    $update = $this->Crud->commonDelete($table,$wherecondition,$relationname);
		    echo $update;
		    exit;
		}
		echo json_encode($response);
    }
	// ** Updating Categories//
 public function get_category()
    {
		$id=$this->uri->segment(4);
		$this->data['URL_TITLE']='Update Category';
         $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Category', 'link' => ADMIN_PATH.'master/category_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Category', 'link' => ADMIN_PATH.'master/list_category', 'class' => 'active', 'icon' => ''),
                    );       
        $this->data['main_title']='Update Categories';
		$params['table']='cl_category_tbl';
        $params['wherecondition']=array('category_id'=>$id);
		$params['cols']='category_name,category_id';
        $res=json_decode($this->Crud->commonget($params));
		$this->data['result']=$res->row; 
        $this->data['breadcrumb'] = json_encode($breadcrumb_array);
        $this->load->view('update_category', $this->data);
    }
    public function update_category()
	{
		//echo "ho"; exit;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_name','Category name','required|regex_match[/^[a-zA-Z1-9][a-zA-Z0-9 -]*$/]',array('required'=>'Please enter category','regex_match'=>'Invalid category'));
		if($this->form_validation->run()==false)
			{
				$this->get_category();
			}
			else
			{
				$id=$this->uri->segment(4);
				$category_name=$this->input->post('category_name');
		 $where_cond=array('category_name'=>$category_name,'category_id !='=>$id);
              $common_check=$this->Crud->commonCheck('category_name','cl_category_tbl',$where_cond);
			  // echo $common_check; exit;
			 if($common_check == 0 )
			  {
				$data=array('category_name'=>$category_name
							);
				
				$id1=array('category_id'=>$id); 
				$successMsg= 'updated successfully';
				$failMsg= 'something went wrong';
				$updater=$this->Crud->commonUpdate('cl_category_tbl',$data,$id1,$successMsg,$failMsg);
				$res=json_decode($updater);
				//print_r($res); exit;
				 if($res->code==SUCCESS_CODE)
				 {
					 $this->session->set_flashdata('success','Data updated successfully.');
					 redirect('admin/master/list_category');
				 }
				 else
				 {
					 $this->session->set_flashdata('failure','Data not updated');
					redirect('admin/master/list_category');
				 }
			}
			else{
				$this->session->set_flashdata('exist','Already coupon code was exist');
				redirect('admin/master/list_category');
			}
			}
	}
	                                // **  SubCategories//
	// **  Listing SubCategories//
public function list_subcategory()
	{
		$data=array();
              $this->data['URL_TITLE']='Manage Subcategory';
         $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Subcategory', 'link' => ADMIN_PATH.'master/subcategory_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Subcategory', 'link' => ADMIN_PATH.'master/list_subcategory', 'class' => 'active', 'icon' => ''),
                    );       
        $this->data['main_title']='Manage Subcategories';
	$params['table']='cl_sub_category_tbl';
	$getrecs=json_decode($this->Category_model->getting_records($params));
		if($getrecs->code==SUCCESS_CODE)
		{
			$recs=$getrecs->num_rows;
			$config=array();
			$config['base_url']=ADMIN_PATH.'master/list_subcategory';
			$config['total_rows']=$recs;
			$config['uri_segment']=4;
			$config['per_page']=20;
			$config['cur_tag_open'] = '<a href="#" class="active">';//this is active tab
			$config['cur_tag_close'] = '</a>';
			$this->pagination->initialize($config);
			$seg=$this->uri->segment(4);
			if(!empty($seg))
				$si=$seg;
			else
				$si=0;
			$params['si']=$si;
			$params['nr']=20;
		$params['order_by_cols']='sub_category_id';
		$result=$this->Category_model->getting_records($params); 
		// print_r($result); exit;
		$res=json_decode($result);
		$result1=($res->result); 
		$this->data['limit']=$config['per_page'];
		 $this->data['category_details']=$this->Category_model->allCategories();
		if($res->code==SUCCESS_CODE)
		{
			$this->data['records']=$result1;
			$this->data['per']=$res->num_rows;
			$this->data['total']=$recs;
			$this->data['si']=$si;
			$this->data['breadcrumb'] = json_encode($breadcrumb_array);
		  $this->load->view('list_subcategory', $this->data);
		}
		}
		else{
		$this->data['URL_TITLE']='Mange Category';
		$this->data['main_title']='Manage Categories';
		$this->data['breadcrumb'] = json_encode($breadcrumb_array);
        $this->load->view('list_subcategory', $this->data);
		}
	}
	// ** Searching SubCategories//
public function search_subcategory()
	{
		// print_r($_POST); exit;
		$data=array();
		$category_id=$this->input->post('category_id');
              $this->data['URL_TITLE']='Manage Subcategory';
         $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Subcategory', 'link' => ADMIN_PATH.'master/subcategory_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Subcategory', 'link' => ADMIN_PATH.'master/list_subcategory', 'class' => 'active', 'icon' => ''),
                    );
        $this->form_validation->set_rules('category_id','category_id','greater_than[0]',array('greater_than'=>'Please select category'));
		if($this->form_validation->run()==false)
			{
				// echo "hi"; exit;
				$this->list_subcategory();
			}
	else{
		// echo "hiii"; exit;
        $this->data['main_title']='Manage Subcategories';
	$params['table']='cl_sub_category_tbl';
	$params['wherecondition']=array('category_id'=>$category_id);
	$getrecs=json_decode($this->Category_model->getting_records($params));
		if($getrecs->code==SUCCESS_CODE)
		{
			$recs=$getrecs->num_rows;
			$config=array();
			$config['base_url']=ADMIN_PATH.'master/list_subcategory';
			$config['total_rows']=$recs;
			$config['uri_segment']=4;
			$config['per_page']=20;
			$config['cur_tag_open'] = '<a href="#" class="active">';//this is active tab
			$config['cur_tag_close'] = '</a>';
			$this->pagination->initialize($config);
			$seg=$this->uri->segment(4);
			if(!empty($seg))
				$si=$seg;
			else
				$si=0;
			$params['si']=$si;
			$params['nr']=20;
		$params['order_by_cols']='sub_category_id';
		$result=$this->Category_model->getting_records($params); 
		// print_r($result); exit;
		$res=json_decode($result);
		$result1=($res->result); 
		$this->data['limit']=$config['per_page'];
		 $this->data['category_details']=$this->Category_model->allCategories();
		 if($res->code==SUCCESS_CODE)
		{
			$this->data['records']=$result1;
			$this->data['per']=$res->num_rows;
			$this->data['total']=$recs;
			$this->data['si']=$si;
			$this->data['breadcrumb'] = json_encode($breadcrumb_array);
		$this->load->view('list_subcategory', $this->data);
		}
		}
		else{
		$this->data['URL_TITLE']='Mange Category';
		$this->data['main_title']='Manage Categories';
		$this->data['breadcrumb'] = json_encode($breadcrumb_array);
		$this->load->view('list_subcategory', $this->data);
		}
		}
	}
	// ** Adding SubCategories//
 public function subcategory_view()
    {
        $this->data['URL_TITLE']='Add Subcategory';
        $this->data['main_title']='Add Subcategory';
        $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Subcategory', 'link' => ADMIN_PATH.'master/subcategory_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Subcategory', 'link' => ADMIN_PATH.'master/list_subcategory', 'class' => 'active', 'icon' => ''),
                    );
        $this->data['category_details']=$this->Category_model->allCategories();
        $this->data['breadcrumb'] = json_encode($breadcrumb_array);
        $this->load->view('add_subcategory', $this->data);   
    }


  public function insert_subcategory(){	
		// print_r($_POST); exit;
		 $inputData =file_get_contents('php://input');
		 if (isJson($inputData))
        {
				 $request=json_decode($inputData);
				$category=$request->category_id; 	
				$subcategory=$request->subcategory_name;
				//print_r($category); exit;
				$logwith=$request->is_mobile;
				$error=0;
				$err_mesg="";
				 if(is_array($subcategory))
				 {
					   $insertdata=array();
					   $duplicateData='';
						   $insertdataArray=array();
						   $dataArray=array_unique($subcategory);
					 foreach($dataArray as $res)
					 {
						$checkDuplicate=$this->Crud->commonCheck('sub_category_id','cl_sub_category_tbl',array('subcategory_name'=>$res,'category_id'=>$category)); 
						if($checkDuplicate == 0)
						{
							$insertdataArray[]=array(
													'category_id'=>$category,	
													 'subcategory_name' => $res,
													 'added_on'=>DATE,
													 'added_by'=>1,
													 'flag_status'=>1
													 );
						}
						else
						{
							$duplicateData.=$res.',';
						}
					 }
					 
					 $duplicateMessage=rtrim($duplicateData,',');
					 if(is_array($insertdataArray) && count($insertdataArray))
					 {
							  $insertdata=$insertdataArray;
						 
							$checkedSql=$this->Crud->batchInsert('cl_sub_category_tbl',$insertdata);
							 $checkedReq=json_decode($checkedSql);
							$response[CODE]=$checkedReq->code;
							$response[MESSAGE]=$checkedReq->message;
							$response[DESCRIPTION]=$checkedReq->description;	
					  }
					  else
					  {
							$response[CODE]=204;
							$response[MESSAGE]='Fail';
							$response[DESCRIPTION]='Already sub category name was entered';
					  }
					$response['duplicate']=$duplicateMessage;
					 
				 }
				 else
				 {
					 
							$response['code']=204;
							$response['message']='Validation';
							$response['description']='Input data expecting in array format.';
				 }
		}
		else
		{
					$response['code']=301;
					$response['message']='Validation';
					$response['description']='Accepts Json Data only';
		}
echo json_encode($response);
		        }
		//** Status changing //
public function status_subcategory()
    {
        $response = array();
       $tablename = $this->input->post('tablename');
       $updatelist = $this->input->post('updatelist');
        $activity = $this->input->post('activity');
        if ($tablename != '' && $updatelist != '' && $activity != '' && ($activity == 0 || $activity == 1 || $activity == 2)) {
            $table= '';
            $setcolumns = '';
            $wherecondition = '';
            $updatevalue = '';
            switch ($tablename) {
            case 'subcategory_name':   // need to refer name for table name
              $table='cl_sub_category_tbl';   // table name 
              $setcolumns='flag_status';
              $updatevalue=$activity;
              $wherecondition="sub_category_id  IN  (" .$updatelist. ")";
              break;
           
            }
           $update = $this->Crud->commonStatusActivity($table, $setcolumns, $updatevalue, $wherecondition);
            echo $update;
            exit;
        }
        echo json_encode($response);
        }
		// ** Updating Categories//
 public function get_subcategory()
    {
		$id=$this->uri->segment(4);
		$this->data['URL_TITLE']='Update Subategory';
       $breadcrumb_array = array(
            array('title' => 'Dashboard', 'link' =>ADMIN_PATH.'login/dashboard', 'class' => '', 'icon' => ''),
            array('title' => 'Add Subcategory', 'link' => ADMIN_PATH.'master/subcategory_view', 'class' => 'active', 'icon' => ''),
            array('title' => 'list Subcategory', 'link' => ADMIN_PATH.'master/list_subcategory', 'class' => 'active', 'icon' => ''),
                    );
           $this->data['main_title']='Update Subcategory';
		$params['table']='cl_sub_category_tbl';
        $params['wherecondition']=array('sub_category_id'=>$id);
		$res=json_decode($this->Crud->commonget($params));
		$this->data['result']=$res->row; 
        $this->data['breadcrumb'] = json_encode($breadcrumb_array);
		$this->data['category_details']=$this->Category_model->allCategories();
        $this->load->view('update_subcategory', $this->data);
    }
    public function update_subcategory()
	{
		//echo "ho"; exit;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_id','category_id','greater_than[0]',array('greater_than'=>'Please select category'));
		$this->form_validation->set_rules('subcategory_name','subcategory_name','required|regex_match[/^[a-zA-Z1-9][a-zA-Z0-9 -]*$/]',array('required'=>'Please enter subcategory','regex_match'=>'Invalid subcategory'));
		if($this->form_validation->run()==false)
			{
				// echo "hi"; exit;
				$this->get_subcategory();
			}
			else
			{
				$id=$this->uri->segment(4);
				$category_id=$this->input->post('category_id');
				$subcategory=$this->input->post('subcategory_name');
		       $where_cond=array('subcategory_name'=>$subcategory,'sub_category_id !='=>$id);
              $common_check=$this->Crud->commonCheck('subcategory_name','cl_sub_category_tbl',$where_cond);
			  // echo $common_check; exit;
			 if($common_check == 0 )
			  {
				$data=array('category_id'=>$category_id,
				            'subcategory_name'=>$subcategory
							);
				
				$id1=array('sub_category_id'=>$id); 
				$successMsg= 'updated successfully';
				$failMsg= 'something went wrong';
				$updater=$this->Crud->commonUpdate('cl_sub_category_tbl',$data,$id1,$successMsg,$failMsg);
				$res=json_decode($updater);
				//print_r($res); exit;
				 if($res->code==SUCCESS_CODE)
				 {
					 $this->session->set_flashdata('success','Data updated successfully.');
					 redirect('admin/master/list_subcategory');
				 }
				 else
				 {
					 $this->session->set_flashdata('failure','Data not updated');
					redirect('admin/master/list_subcategory');
				 }
			}
			else{
				$this->session->set_flashdata('exist','Already subcategory was exist');
				$this->get_subcategory();
			}
			}
	}
		
                                             // ** Sliders//
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
    	echo "hi..slider..";
    }
}