<?php defined('BASEPATH') or die('Something went wrong');
class LoginModel extends CI_model
{
	public function admin_login_check($data)
	{
		$this->db->where($data);
		$rs=$this->db->get('cl_admin_tbl');
		$count=$rs->num_rows();
		if($count>0)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}
	public function edit_admin_login_ip($ip_set,$id)
	{
		$this->db->where('id',$id);
		$res=$this->db->update('cl_admin_tbl',$ip_set);
		if($res)
		{
			return 1;
		}
	}
	public function get_admin_email($wer)
	{
		$this->db->where($wer);
		$rs=$this->db->get('cl_admin_tbl');
		$count=$rs->num_rows();
		if($count>0)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}
}