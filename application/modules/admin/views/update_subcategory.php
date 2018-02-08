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
						<a href="<?php echo ADMIN_PATH.'Master/list_subcategory'; ?>" class="btn btn-primary pull-right">Manage Subcategory</a>
						</div>
						<!-- /.box-header -->
						<!-- form start -->
						<form action="<?php echo ADMIN_PATH.'Master/update_subcategory/'.$this->uri->segment(4); ?>" id="form_data" method="post">
						<div class="box-body">
						<div class="col-md-2 "> </div>
						<div class="col-lg-12">
                    <?php if($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success" id="temp">
                    <?php echo $this->session->flashdata('success'); ?>
                    </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('exist')) { ?>
                    <div class="alert alert-danger" id="temp">
                    <?php echo $this->session->flashdata('exist'); ?>
                    </div>
                    <?php } ?>
		</div> <div class="col-md-2 "> </div>
                         <div class="col-md-4 "> 
                                            <div class="navbar-form">
                                                 <?php echo form_label('category name')."<span style='color:red' > * </span> <br>"; ?>
                                                   <select name="category_id" id="category_id" class="form-control">
                                                    <option value="0">Choose Category</option>
                                                       <?php 
                                                       $cat_req=json_decode($category_details);
                                                       if($cat_req->code==200){

                                                        foreach($cat_req->category_result as $cat_res){ ?>
                                                        <option value="<?php echo $cat_res->category_id;?>" <?php if($result->category_id==$cat_res->category_id){echo "selected";}?>><?php echo $cat_res->category_name; ?></option>
                                                        <?php }
                                                       }
                                                       ?>
                                                       
                                                   </select> 
                                                   <span  class="category_error" id="category_error" style="color:red"><?php echo form_error('category_id');?></span>  
                                               <br>
                                                 
                                            </div>
                                        </div>
						                   <div class="col-md-5 input_fields_wrap"> 
                                            <div class="navbar-form">
                                                <?php echo form_label('subcategory name')."<span style='color:red'> * </span> <br>";
                                                $data1= array(
                                                    'name'          => 'subcategory_name',
                                                    'id'            => 'subcategory_name',
                                                    'maxlength'     => 40,
                                                    'autocomplete'  => 'off',
                                                    'class'         => 'form-control input_small class_form',
                                                    'placeholder'   => 'Enter Subcategory',
													'value' =>$result->subcategory_name

                                                );

                                                 echo form_input($data1);
                                                 if(isset($err_mesg)){echo $err_mesg; }
                                                 ?>
                                             <span class="subcategory_error" style="color:red" id="subcategory_error"><?php echo form_error('subcategory_name');?></span>  
                                             </div>
                                        </div>
						
						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="box-footer pull-right">
							<button type="submit" id="btn_submit" class="btn btn-success">Update</button>
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
		$('#category_error,#subcategory_error').html('');
		var category_id=$('#category_id').val();
		var subcategory_name=$('#subcategory_name').val();
		var sbct_pattern=/^[a-zA-Z1-9][a-zA-Z0-9 -]*$/;
	if(category_id=="0"){flag=false;$('#category_error').html('Please select category');}
		if(subcategory_name==""){flag=false;$('#subcategory_error').html('Please enter subcategory');}
		if(subcategory_name!=""){if(!subcategory_name.match(sbct_pattern)){flag=false;$('#subcategory_error').html('Invalid subcategory');}}
		return flag;
	});
});
$("#temp").delay(4000).fadeOut("slow");

</script>