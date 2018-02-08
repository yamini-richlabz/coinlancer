<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_controller
{
    public $profile_folder,$data,$adminid;
    public function __construct()
    {
     	parent::__construct();        
        $this->data=array();
        $this->load->model(array('LoginModel'=>'login_model'));
        $this->load->library('form_validation');
        // $this->vendor_profile_folder='profile/';
        // $this->vendor_error_folder='errors/';
        // $this->vendorid=$this->session->userdata(VENDOR_SESS_CODE.'vendorid');
        // $this->vendor_table='vendor_tbl';
    }
    // public function index()
    // {/*check admin_id set or Not.If already set then redirect to the get_dashboard()*/
    //     if($this->session->userdata('admin_id'))
    //     {
    //         redirect('cl_ctrl/cl_admin/Admin/get_dashboard');
    //     }
    //     $this->load->view('cl_view/admin_view/admin_login_view');
    // }
    public function admin()
    {
		$this->data['URL_TITLE']='login';
        $this->load->view('admin_login', $this->data);
    }
    /*code for admin login*/
    public function admin_login()
    {
        if($this->input->post('btn_login'))
        {
            $arr=array(
                    array('field' =>'admin_email',
                          'label' =>'',
                          'rules' =>'required|trim|valid_email',
                          'errors'=>array('required'=>'Email is required','valid_email'=>'Invalid email address')),
                    array('field' =>'admin_pwd',
                          'label' =>'',
                          'rules' =>'required|trim',
                          'errors'=>array('required'=>'Password is required'))
            );
            $this->form_validation->set_error_delimiters('<span style="color:red">','</span>');
            $this->form_validation->set_rules($arr);
            if($this->form_validation->run()==false)
            {
                //$this->load->view('cl_view/admin_view/admin_login_view');
                $this->data['URL_TITLE']='login';
                $this->load->view('admin_login', $this->data);
            }
            else
            {
                $email=$this->input->post('admin_email');
                $pwd=md5($this->input->post('admin_pwd'));
                $data=array('email'   =>$email,'password'=>$pwd);
                $rs=$this->login_model->admin_login_check($data);
                if($rs)
                {   
                    $id=$rs->row()->id;
                    $this->session->set_userdata('admin_id',$id);
                    $ip=$this->input->ip_address();
                    $dt=date('Y-m-d H:i:sa');
                    $ip_set=array('last_login_ip'=>$ip,'last_login_date'=>$dt);
                    //$ret=$this->Admin_model->edit_admin_login_ip($ip_set,$id);
                    $ret=$this->login_model->edit_admin_login_ip($ip_set,$id);
                    if($ret)
                    {
                       // redirect('cl_ctrl/cl_admin/Admin/get_dashboard');
                        $this->dashboard();
                    }
                }
                else
                {
                    $this->session->set_flashdata('login_failed','Invalid Username/Password');
                    $this->data['URL_TITLE']='login';
                    $this->load->view('admin_login', $this->data);
                    //$this->load->view('cl_view/admin_view/admin_login_view');
                }
            }
        }
        if($this->input->post('btn_forgot'))
        {
            //echo "forgot password..!!";
            $this->data['URL_TITLE']='Forgot_Password';
            $this->load->view('forgot_pwd', $this->data);
        }
    }
    public function forgot_password()
    {
        if($this->input->post('btn_continue'))
        {
            //echo "code for Email verification link..!!";
            $arr=array(
                        array('field'=>'admin_email',
                              'lable'=>'',
                              'rules'=>'required|trim|valid_email',
                              'errors'=>array('required'=>'Email is required',
                                              'valid_email'=>'Invalid email id'))
                );
            $this->form_validation->set_rules($arr);
            $this->form_validation->set_error_delimiters('<span style="color:red">','</span>');
            if($this->form_validation->run()==false)
            {
                $this->data['URL_TITLE']='Forgot_Password';
                $this->load->view('forgot_pwd', $this->data);
            }
            else
            {
                $email=$this->input->post('admin_email');
                $get=array('email'=>$email);
                $rs= $this->login_model->get_admin_email($get);
            echo $em=base64_encode($rs->row()->email);
            }
        }
    }
    public function dashboard()
    {
		$this->data['URL_TITLE']='Dashboard';
        $this->load->view('admin_dashboard', $this->data);
    }
  

}