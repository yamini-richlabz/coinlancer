<!DOCTYPE html>
<html>
<head>
    <?php echo $this->load->view(ADMIN_CSS_INCLUDE_PATH); ?>
    <style type="text/css">
    	sup{color: red;}
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <?php echo $this->load->view(ADMIN_HEADER_PATH); ?>
    <?php echo $this->load->view(ADMIN_SIDEBAR_PATH); ?>
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="prtm-page-bar">
        <ul class="breadcrumb">
            <?php
            $breadcrumb_details = json_decode($breadcrumb);
            $breadcrumb_count = count($breadcrumb_details);
            foreach ($breadcrumb_details as $breadcrumb) {
                ?>
                <li class="breadcrumb-item <?php echo $breadcrumb->class; ?>">
                    <a href="<?php echo $breadcrumb->link; ?>">    <i class="material-icons"><?php echo $breadcrumb->icon; ?></i> <?php echo fetch_ucfirst($breadcrumb->title); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>    
      <h1>
        <?php echo $main_title; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
						<h3 class="box-title"><?php echo $main_title; ?></h3>
						<a href="<?php echo base_url().'admin/Master/list_slider'; ?>" class="btn btn-primary pull-right">Manage Slider</a>
						</div>
						<!-- /.box-header -->
						<!-- form start -->
						<!-- <form action="" id="form_data"> -->
                        <?php 
            $attr=array('onsubmit'=>'return form_validate1();');
            echo form_open_multipart('admin/Slider_ctrl/insert_slider',$attr); 
            ?>
            <?php
            if(!empty($msg))
            {?>
                <p align="pull-left" class="text-danger">
                <?php 
                    echo $msg; ?>
                </p>
            <?php
            }?>
						<div class="box-body">
						<!-- <input type="hidden" name="is_mobile" id="is_mobile" value="web"/> -->
						                   <div class="col-md-8 input_fields_wrap"> 
                                            <div class="navbar-form">
                                            <!-- <input type="text" style="width: 250px;"> -->
                                                <?php echo form_label('Slider title')."<span style='color:red' id='slider_error'> * </span> <br>";
                                                  $data1= array(
                                                    'name'          => 'slider_title',
                                                    'id'            => 'slider_title',
                                                    'width'         => 250,
                                                    'autocomplete'  => 'off',
                                                    'class'         => 'form-control',
                                                    'placeholder'   => 'Enter slider title'
                                                );
                                                 echo form_input($data1); ?>
                        <?php echo form_error('slider_title',"<span class='text-danger'>","</span>"); 
                                                 if(isset($err_mesg)){echo $err_mesg; }
                                                 ?>
                                             <span class="slider_error" id="silder_error"></span>  
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-8 input_fields_wrap"> 
                                            <div class="navbar-form">
                                                <?php echo form_label('Slider url')."<span style='color:red' id='slider_error'> * </span> <br>";
                                                  $data1= array(
                                                    'name'          => 'slider_url',
                                                    'id'            => 'slider_url',
                                                    'maxlength'     => 40,
                                                    'autocomplete'  => 'off',
                                                    'class'         => 'form-control input_small class_form',
                                                    'placeholder'   => 'Enter slider url'
                                                );
                                                 echo form_input($data1); ?>
                        <?php echo form_error('slider_url',"<span class='text-danger'>","</span>"); 
                                                 if(isset($err_mesg)){echo $err_mesg; }
                                                 ?>
                                             <span class="category_error" id="category_error"></span>  
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-8 input_fields_wrap"> 
                                            <div class="navbar-form">
                                                <?php echo form_label('Slider image')."<span style='color:red' id='slider_error'> * </span> <br>";
                                                  $data1= array(
                                                    'name'          => 'slider_image',
                                                    'id'            => 'slider_image',
                                                    'maxlength'     => 40,
                                                    'autocomplete'  => 'off',
                                                    'class'         => 'form-control input_small class_form'
                                                );
                                                 echo form_upload($data1);?>
                       <!--  // echo form_error('slider_image',"<span class='text-danger'>","</span>"); -->
                                <span class='text-danger'>
                                <?php    if(isset($upload_error)) echo $upload_error; ?></span>
                                                 <!-- if(!empty($upload_error)){echo upload_error; } -->
                                                
                                             <span class="category_error" id="category_error"></span>  
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-8 input_fields_wrap"> 
                                            <div class="navbar-form">
                                                <?php echo form_label('Slider description')."<span style='color:red' id='slider_error'> * </span> <br>";
                                                  $data1= array(
                                                    'name'          => 'slider_desc',
                                                    'id'            => 'slider_desc',
                                                    'maxlength'     => 50,
                                                    'autocomplete'  => 'off',
                                                    'class'         => 'form-control input_small class_form',
                                                    'placeholder'   => 'Enter slider description'
                                                );
                                                 echo form_input($data1); ?>
                        <?php echo form_error('slider_desc',"<span class='text-danger'>","</span>"); 
                                                 if(isset($err_mesg)){echo $err_mesg; }
                                                 ?>
                                             <span class="category_error" id="category_error"></span>  
                                                
                                            </div>
                                        </div>
						
						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="box-footer pull-right">
							<!-- <a href=""><button type="button" class="btn btn-info">Reset</button></a>
							<button type="submit" name="btn_slider_submit" id="btn_slider_submit" class="btn btn-success">Add Now</button> -->
                             <?php     
  echo form_reset(['name'=>'btn_reset','value'=>'Reset','class'=>'btn btn-info']) ;
  echo form_submit(['name'=>'btn_slider_submit','value'=>'Add Now','class'=>'btn btn-success']);
      ?>
						 </div>
						</div>
						</div>
						<!-- </form> -->
                        <?php echo form_close();?>
					</div>
				</div>
			</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php echo $this->load->view(ADMIN_JS_INCLUDE_PATH); ?>
    <?php echo $this->load->view(ADMIN_FOOTER_PATH); ?>
</body>
</html>
<script>
function form_validate()
{
    flag=true;
    //alert('hi..');
        var slider_title=$('#slider_title').val();
        //alert(slider_title);
        if(slider_title=="")
        {
          flag=false;
          $('#slider_title').css('border','1px solid red');
        }
        else
        {
          $('#slider_title').css('border','1px solid grey');
        }
        var slider_url=$('#slider_url').val();
        //alert(slider_url);
        if(slider_url=="")
        {
            flag=false;
            $('#slider_url').css('border','1px solid red');
        }
        else
        {
            $('#slider_url').css('border','1px solid grey');
        }
        var slider_image=$('#slider_image').val();
        //alert(slider_image);
        if(slider_image=="")
        {
            flag=false;
            $('#slider_image').css('border','1px solid red');
        }
        else
        {
            $('#slider_image').css('border','1px solid grey');
        }
        var slider_desc=$('#slider_desc').val();
        //alert(slider_desc);
        if(slider_desc=="")
        {
            flag=false;
            $('#slider_desc').css('border','1px solid red');
        }
        else
        {
            $('#slider_desc').css('border','1px solid grey');
        }
    return flag;
}
</script>