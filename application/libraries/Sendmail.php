<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sendmail 
{

     public function emailConfigurations() {
         /*
          * If SITE_MODE==0 Then it is in local system
          * IF SITE_MODE==1 Then it is in Main server
          */
        if (SITE_MODE == 0) {
            $config['protocol'] = SMTP_PROTOCAL;
            $config['smtp_host'] = SMTP_HOST;
            $config['smtp_port'] = SMTP_PORT;
            $config['smtp_user'] = SMTP_USER;
            $config['smtp_pass'] = SMTP_PASSWORD;
            $config['mailpath'] = '/usr/sbin/sendmail';
        }
        $config['charset'] = "iso-8859-1";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
        return $config;
    }
    public function sendEmail($mail_array)
    {
        /*
         * TO : to email addresses. we can add multiple email ids (It accepts array only)- manditory
         * CC : cc email addresses. we can add multiple email ids (It accepts array only)- manditory
         * SUBJECT :  Subject of mail - manditory
         * DATA : Body data (Dynamic data) - manditory
         * ATTACHMENT : We can attach multiple files - Not manditory
         * TEMPLATE :  Email  body template
         * 
         */
          $response=array();
          $obj =& get_instance();
          if(is_array($mail_array))
          {
             // print_r($mail_array);exit;
                $to=$mail_array['to'];
                $cc=$mail_array['cc'];
                $subject=$mail_array['subject'];
                $data=$mail_array['data'];
                $attachment=(isset($mail_array['attachment']))?$mail_array['attachment']:'';
                $req_template=$mail_array['template'];
                $error=0;$error_messsage='';
                /*Validation Error Start*/
                if(!is_array($to)){$error=1;$error_messsage.='To email should be in array format only, ';}
                if(!is_array($cc)){$error=1;$error_messsage.='CC email should be in array format only, ';}
                if($subject==''){$error=1;$error_messsage.='Enter subject, ';}
                if(!is_array($data)){$error=1;$error_messsage.='Enter data, ';}
                if($req_template==''){$error=1;$error_messsage.='Template path is missing, ';}
                //checking multiple emails are valid or not is pending.
                /*Validation Error End*/
                if($error==0)
                {
                        $config = $this->emailConfigurations();
                        $assign_template = $obj->load->view($req_template, $data, TRUE);
                        $obj->email->initialize($config);
                        $obj->email->from(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
                        $obj->email->to($to);
                        $obj->email->cc($cc);
                        $obj->email->bcc(BCC_EMAIL);
                        $obj->email->reply_to(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
                        $obj->email->subject($subject);
                        if(count($attachment) > 0 && is_array($attachment))
                        {
                            foreach ($attachment as $attachment_result){
                            $obj->email->attach($attachment_result);
                            }
                        }
                        $obj->email->message($assign_template);
                        $obj->email->set_alt_message('Some data is missing.Please refresh once');
                        $send = $obj->email->send();
                           if($send)
                           {
                                     $response[CODE]=1;
                                     $response[MESSAGE]='Mail sended successfully';
                            }
                            else 
                            {
                                $response[CODE]=0;
                                $response[MESSAGE]=$this->email->print_debugger();
                            }
                }
                else
                {
                    $response[CODE]=0;
                    $response[MESSAGE]=$error_messsage;
                }
          }
         else
         {
             $response[CODE]=0;
             $response[MESSAGE]='Input data should be in array format only';
         }
         return $response;
    }

}
