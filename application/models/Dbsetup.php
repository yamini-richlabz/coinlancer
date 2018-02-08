<?php
defined('BASEPATH') or die('Error occured while loading All operations');
class Dbsetup extends CI_Model
{
    public function __construct() {
        parent::__construct();
          $this->load->dbutil();
          $this->load->dbforge();
    }
    
    // Database List 
    public function dbList()
    {
            return $result= $this->dbutil->list_databases();
    }
    
    //Table List
    public function tableList()
    {      
        return $tables = $this->db->list_tables();
    }
    
    //Table Details
    public function tableDetails($table)
    {
        $result='';
        $table=  strtolower($table);
        if(!empty($table))
       {
             $result = $this->db->field_data($table);
        }
        return $result;
    }
    
   // Create a table
   public function createTable($table)
   {
       $response=array();
       $table=  strtolower($table);
       $attributes = array('ENGINE' => 'InnoDB');
        $create=$this->dbforge->create_table($table, FALSE, $attributes);
        //$response[CODE]=()
   }
   
   //DB Back Up
   public function dbbackup($filename,$peferences)
   {
            $common_ext='Backup_'.date('Y-m-d-h-i-s').'_'.rand(00,99);
            $backup = $this->dbutil->backup($peferences); 
            $db_name =$common_ext.$filename.'.zip';
            $backup_path ='backups/database/'.$db_name;
            $this->load->helper('file');
            $move=write_file($backup_path, $backup); 
            $this->load->helper('download');
           force_download($db_name, $backup);
   }
}