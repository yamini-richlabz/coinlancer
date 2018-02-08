<?php
class Slider_model extends CI_model
{
	public function insert_slider_img($data)
	{
		$this->db->where('slider_title',$data['slider_title']);
		$rs=$this->db->get('cl_slider_tbl');echo "<br>";
		// echo $this->db->last_query();echo "<br>";
		 $count=$rs->num_rows();
		if($count>0)
		{
			return 3;
		}
		else
		{
			$rs=$this->db->insert('cl_slider_tbl',$data);
			if($rs)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}
	}
}
?>