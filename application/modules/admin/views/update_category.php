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
						<a href="<?php echo ADMIN_PATH.'Master/list_category'; ?>" class="btn btn-primary pull-right">Manage Category</a>
						</div>
						<!-- /.box-header -->
						<!-- form start -->
						<form action="<?php echo ADMIN_PATH; ?>Master/update_category/<?php echo $this->uri->segment(4); ?>" id="form_data" method="post">
						<div class="box-body">
						 <div class="col-md-8 input_fields_wrap"> 
                                            <div class="navbar-form">
                                                <?php echo form_label('category name')."<span style='color:red' > * </span> <br>";
                                                
                                                  $data1= array(
                                                    'name'          => 'category_name',
                                                    'id'            => 'category_name',
                                                    'maxlength'     => 40,
                                                    'autocomplete'  => 'off',
                                                    'class'         => 'form-control input_small class_form',
                                                    'placeholder'   => 'Enter Exam Category',
													'value'  => $result->category_name

                                                );

                                                 echo form_input($data1);
                                                 if(isset($err_mesg)){echo $err_mesg; }
                                                 ?>
                                             <span class="category_error" style="color:red" id="category_error"><?php echo form_error('category_name'); ?></span>  
                                              </div>
                                        </div>
						
						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="box-footer pull-right">
							<input type="submit" id="btn_submit" class="btn btn-success" value="Update">
						 </div>
						</div>
						</div>
						</form>
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
$(document).ready(function(){
	$('#form_data').on('submit',function()
	{ 
	  var flag=true;
		$('#category_error').html('');
		var category_name=$('#category_name').val();
		var ct_pattern=/^[a-zA-Z1-9][a-zA-Z0-9 -]*$/;
	if(category_name==""){flag=false;$('#category_error').html('Please enter category');}
		if(category_name!=""){if(!category_name.match(ct_pattern)){flag=false;$('#category_error').html('Invalid category');}}
		return flag;
	});
});
$("#temp").delay(4000).fadeOut("slow");

</script>
