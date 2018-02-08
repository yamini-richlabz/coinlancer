<?php
 class category_model extends CI_MODEL{
public function getting_records($params)
    {
        if(is_array($params))
        {
			$nr=(isset($params['nr']))?$params['nr']:'';
			$si=(isset($params['si']))?$params['si']:'';
			$join_col=(isset($params['search']))?$params['search']:array();
			$where=(isset($params['wherecondition']))?$params['wherecondition']:array();
			// $like=(isset($params['like']))?$params['like']:'';
			// echo $like;exit;
			$or_where=(isset($params['or_where']))?$params['or_where']:array();
			$or_second_where=(isset($params['or_second_where']))?$params['or_second_where']:array();
            $this->db->from($params['table']);
			$this->db->order_by((isset($params['order_by_cols']))?$params['order_by_cols']:'',(isset($params['order_by']))?$params['order_by']:'DESC');
            $this->db->where($where);
			// $this->db->like('emp_name',$like,'before');
			$this->db->or_where($or_where);
			$this->db->or_where($or_second_where);
			if(!empty($join_col)){
				extract($params['search']);
			$this->db->like($join_col,$input,'after');
			}
			$this->db->limit($nr,$si);
			// print_r($this->db->last_query();
        }// print_r($res);
        else 
            $this->db->from($params);
			$res=$this->db->get();
			$error = $this->db->error();
			$error_message = $error['message'];
        if ($error['code'] == 0) {
            $count=$res->num_rows();  
            if ($count>0) {
                $response[CODE] = SUCCESS_CODE;
                $response[MESSAGE] = 'Success';
                $response[DESCRIPTION] = $count.'records found';
                $response['row'] = $res->row();
                $response['result']=$res->result();
                $response['num_rows']=$count;
            } else 
            {
                $response[CODE] = FAIL_CODE;
                $response[MESSAGE] = 'Fail';
                $response[DESCRIPTION] = 'No records found';
            }
        } else {
            $response[CODE] = DB_ERROR_CODE;
            $response[MESSAGE] = 'Databse Error';
            $response[DESCRIPTION] = $error_message;
        }
        // $res=$res->result();
        return json_encode($response);
		
    } 



    public function allCategories()
    {
        $response=[];
        $cols ="category_name,category_id";
        $sql=$this->db->select($cols)->from('cl_category_tbl')->get();
        $db_error=$this->db->error();
        if($db_error['code']==0)
        {
            $count=$sql->num_rows();
            
                $response[CODE] = ($count > 0)?SUCCESS_CODE:FAIL_CODE;
                $response[MESSAGE] =  ($count > 0)?'Success':'Fail';
                $response[DESCRIPTION] =  ($count > 0)?'Getting category List':'No resutls found';
                                
                $response['category_result']=($count > 0)?$sql->result():array();
                $response['results_count']=$count;

            
        }
        else
        {
            $response['code']=545;
            $response['message']='Interal server';
            $response['description']='some thing error occured';
        }

        return  json_encode($response);

    }
	
	
}