<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>style.css"/>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>admin1.css">
  
  <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>login.css">

 
  <style type="text/css">
  
  </style>
</head>

<body>
  <div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
            <?php 
              $attr=array('role'=>'login','onsubmit'=>'return validate_form();'); 
              echo form_open('admin/Login/forgot_password',$attr);
            ?> 
        <!-- <form method="post" action="#" role="login"> -->
         <!--  <img src="" class="img-responsive" alt="Logo" /> -->
         <h1 class="text-center"> Forgot Password</h1 >
         <div class="row">
        <?php if( $error = $this->session->flashdata('login_failed')): ?>
            <div class="alert alert-dismissible alert-danger">
              <strong><?php echo $error; ?></strong>
            </div>
          <?php endif; ?>
        </div>
          <!-- <input type="email" name="email" placeholder="Email" required class="form-control input-lg" value="" />
          
          <input type="password" class="form-control input-lg" id="password" placeholder="Password" required="" /> -->
          <?php 
                    $email_att=array('name'=>'admin_email',
                                      'id'=>'admin_email',
                                      'placeholder'=>'Enter email id',
                                      'class'=>'form-control input-lg',
                                      'value'=>set_value('admin_email'));
                    echo form_input($email_att); 
                    echo form_error('admin_email');
            ?>
          
          <div class="pwstrength_viewport_progress"></div>
           <?php
           $arr=array('name'=>'btn_continue','id'=>'btn_continue','value'=>'Continue','class'=>'btn btn-primary btn-block');
            echo form_submit($arr);
            
            echo form_close();
           ?>
          <!-- <a href="<?php //echo base_url().'login/Login/dashboard'; ?>" class="btn btn-md btn-primary btn-block">Login in </a> -->
          <!-- <button type="submit" name="go" class="btn btn-md btn-primary btn-block">Sign in</button> -->
         
          
       <!--  </form> -->
        
      </section>  
      </div>
      
      <div class="col-md-4"></div>
      
  </div>
</div>
</body>
</html>
<script type="text/javascript">
  function validate_form()
  {
    flag=true;
      var admin_email=$('#admin_email').val();
      if(admin_email=="")
      {
        flag=false;
        $('#admin_email').css('border','1px solid red');
      }
       return flag;
  }
</script>