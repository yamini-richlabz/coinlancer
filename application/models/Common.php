<?php
defined('BASEPATH') or die('Some thing error occured while loading the common model');
class Common extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function headerMenuList($access,$search=NULL)
    {
        
            $response=array('header_menu_result'=>array());
            $access_col='';
            switch ($access)
            {
                case '1':$access_col='superadmin_access_status';break;
                case '2':$access_col='admin_access_status';break;
                case '3':$access_col='store_access_status';break;
            }
            $where=array($access_col=>1);
            $cols="id as id,title as menu_tile,icon as menu_icon,store_access_status as store_access";
            $sql=  $this->db->select($cols)->from('rl_project_header_menulist_tbl')->where($where)->order_by('title','ASC')->get();
            $db_error=  $this->db->error();
            if($db_error['code']==0)
            {
                    $count=$sql->num_rows();
                    $menu_array=array();
                    if($count > 0)
                    {
                        foreach ($sql->result() as $menu_response)
                        {   
                                $menu_id=$menu_response->id;
                                foreach($menu_response as $key=>$val)
                                {
                                    $menu_array[$key]=$val;
                                }
                                $menu_array['submenu_list']=array();
                                /*Submenu list */
                                    $submenu_where=array('header_menu_id'=>$menu_id,$access_col=>1);
                                    $submenu_cols="header_menu_id as menu_id,tile as title,url_link as url_link,url_newwindow_open as page_open,"
                                            . "store_access_status as store_access,admin_access_status as admin_access,superadmin_access_status as superadmin_access";
                                   $submenu_sql=  $this->db->select($submenu_cols)->from('rl_project_header_submenulist_tbl')
                                           ->where($submenu_where)->order_by('id','ASC')->get();
                                   $submenu_count=$submenu_sql->num_rows();
                                   if($submenu_count > 0)
                                   {
                                        $submenu_array=array();
                                        foreach($submenu_sql->result() as $submenu_result)
                                        {
                                                foreach($submenu_result as $submenu_key=>$submenu_val)
                                                {
                                                        $submenu_array[$submenu_key]=$submenu_val;
                                                }
                                                array_push($menu_array['submenu_list'], $submenu_array);
                                        }
                                   }
                                /*Submenu list End*/
                                array_push($response['header_menu_result'], $menu_array);
                        }
                    }
                    $response[CODE]=($count > 0)?SUCCESS_CODE:FAIL_CODE;
                    $response[MESSAGE]=($count > 0)?'Success':'Fail';
                    $response[DESCRIPTION]=($count > 0)?'Getting menu list':'No results found';
                    
            }
            else
            {
                   $response[CODE]=DB_ERROR_CODE;
                   $response[MESSAGE]='DB Error';
                   $response[DESCRIPTION]=$db_error['message'];
            }
            return json_encode($response);
    }
}
