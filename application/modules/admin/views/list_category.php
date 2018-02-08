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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
			<div class="col-md-12 col-sm-12 ">
			<form class="form-horizontal" id="myform" method="post" 
                              enctype="multipart/form-data" action="<?php echo base_url();?>admin/Master/search_category" >
       <div class="col-md-4 ">
          <div class="col-md-6 pd0 form-inline">
			     <input type="search" name="search_name" id="search_name" class="form-control" placeholder="Search here....." >
				 <span id="search_error" style="color:red"></span>
           </div>
            <div class="col-md-2 pd0">
           <button class="btn btn-md btn-default" onclick="return validate();">Search</button>
           </div>
        </div>
		</form>
		<div class="col-sm-2"></div>
        <div class="col-md-3 form-inline">
         
             <a href="#" class="btn btn-success  " onclick="updateActivationStatus('1')">Active</a>
             <a href="#" class="btn btn-warning " onclick="updateActivationStatus('0')">Inactive</a>
             <a href="#" class="btn btn-danger " onclick="commonDelete();">Delete</a>
          
        </div>
        <div class="col-md-1">
           <a href="<?php echo base_url().'admin/Master/category_view'; ?>" class="btn btn-primary pull-right">Add New</a>
        </div>
        
      </div>
	    <div class="col-sm-12" style="margin-top:2%;">
                    <div class="alert alert-success " id="success" style="display:none;"><strong>Success : </strong><span id="successmessage"></span> </div>
                                <div class="alert alert-danger " id="fail" style="display:none;"> <strong>Error : </strong><span id="failmessage"></span></div>
								<?php if($this->session->flashdata('success')){
                                  echo "<div id='temp' class='alert alert-success'>".$this->session->flashdata('success')."</div>"; 
                                       }
                                  if($this->session->flashdata('failed')){
                                  echo "<div id='temp' class='alert alert-danger'>".$this->session->flashdata('failed')."</div>"; 
                                   } 
                                ?>
								</div>
      <div style="height: 35px;"></div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row">
              <div class="col-sm-12">
              <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
                <tr role="row">
                  <th> <input type="checkbox" id="checkAll" class="small-checkbox"></th>
                  <th> S.no </th>
                  <th> Category name </th>
                  <th> Staus</th>
                  <th> Action</th>
                  </tr>
                </thead>
                      <tbody>
                             <?php  
                                if(empty($records)){
                                              ?>
                                              <tr>
                                              <td colspan="15"><div class="alert alert-danger text-center text-upper"><?php echo 'No records found!'; ?></div></td>
                                              </tr>
                                              <?php
                                             }
                                            else
                                            {
                                            //print_r($result);
                                                    $i=$si;
                                                foreach ($records as $row) {
                                            ?>
                                            <tr class="">
                                                <td><input type="checkbox"  name="multiple[]" value="<?php echo $row->category_id; ?>"  class="checkSingle">  </td>
                                                <td><?php echo $i+1; ?></td>
                                                <td><?php echo ucfirst($row->category_name); ?> </td>
                                                <td><?php if($row->category_status==0){echo "<b style='color:red'>Inactive</b>";} else{echo "<b style='color:green'>Active</b>";} ?> </td>
                                               <td> <a href="<?php echo ADMIN_PATH.'master/get_category/'.$row->category_id; ?>" class="btn btn-info btn-sm" onclick="update(<?php echo $row->category_id; ?>)"> EDIT </a>&nbsp;
                                                </td>
                                             </tr>
                                           <?php 
                                                $i++ ;} ?>
												 <tr>
												<td></td>
												  <td colspan="1">Displaying <?php if(isset($per)) echo $per; ?> of <?php echo $total; ?> records</td>
												  <td colspan="8" align="right">
													<div class="pagination">
													<li>
													<?php echo $this->pagination->create_links(); ?>
													</li>
												</td>
												 </tr>
                                             <?php }
                                            ?>
                                        </tbody>
                <tfoot>
                <tr></tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
       
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 </div>
  </div>
   </div>
    </div>
	<?php echo $this->load->view(ADMIN_JS_INCLUDE_PATH); ?>
   <?php echo $this->load->view(ADMIN_FOOTER_PATH); ?>
    

 
</div>
<!-- ./wrapper -->
   
</body>
</html>
<script type="text/javascript">
 function validate()
    {
	var search_name=$('#search_name').val();
	var str=true;
	$('#search_error').html('');
	if(search_name==""){str=false;$('#search_error').html('Please enter category');}
	return str;
   }
</script>
<script type="text/javascript">
    $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
 
});
$(".checkSingle").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#checkAll").prop("checked", true); }     
    }
    else {
      $("#checkAll").prop("checked", false);
    } 
});
</script>
<script type="text/javascript">
   function updateActivationStatus(s) {
                     var listarray = new Array();
                        //check this line for name filed
                        $('input[name="multiple[]"]:checked').each(function () {
                            listarray.push($(this).val());
                        });
                        //alert off if not nessearry
                       // alert(listarray);
                        var checklist = "" + listarray;
                         //alert off if not nessearry
                        //alert(checklist);
                        if (!isNaN(s) && (s == '1' || s == '0') && checklist != '') {
                            $('#fail').hide();
                            $.ajax({
                                dataType: 'json',
                                type: 'post',
                                data: {'tablename': 'category_name', 'updatelist': checklist, 'activity': s},
                                url: '<?php echo base_url(); ?>admin/Master/commonStatusActivity/',
                                success: function (u) {
                                    console.log(u);
                                    if(u.code=='200'){$('#success').show();$('#successmessage').html(u.description);setTimeout(function() {window.location=location.href;},2000);}
                    if(u.code=='204' || u.code=='301' || u.code=='422'){$('#fail').show();$('#failmessage').html(u.description);setTimeout(function() {window.location=location.href;},2000);}
                                },
                                error: function (er) {
                                    console.log(er);
                                }
                            });
                        } else {
                            $('#fail').show();
                            $('#failmessage').html('*  Please select a record');
							setTimeout(function() {window.location=location.href;},2000);
                        }
                    }

    function commonDelete(){
  var listarray=new Array();
      $('input[name="multiple[]"]:checked').each(function(){listarray.push($(this).val());});
        var checklist=""+listarray;
         // alert(checklist);
      if(checklist!=''){
		   var c= confirm('Confirm to delete');
		   if(c){
         // $('#fail').hide();
         $.ajax({
          dataType:'json',
          type:'post',
          data:{'tablename':'category_name','updatelist':checklist},
          url:'<?php echo base_url();?>admin/Master/commonDelete/',
          success:function(u){
            //console.log(u);
            if(u.code=='200'){$('#success').show();$('#successmessage').html(u.description);
			setTimeout(function() {window.location=location.href;},2000);}
                    if(u.code=='204' || u.code=='301' || u.code=='422'){$('#fail').show();$('#failmessage').html(u.description);
					setTimeout(function() {window.location=location.href;},2000);}
                 },
          error:function(er){
            console.log(er);
          }
        });
      }
	   else
	   {
		    $('input[name="multiple[]"]').removeAttr('checked');
			 $('input[name="checkAll[]"]').removeAttr('checked');
	   }
	  }
	else{
       $('#fail').show();$('#failmessage').html('*Please Select ');
	   setTimeout(function() {window.location=location.href;},2000);
      }
	  }
$("#temp").delay(4000).fadeOut("slow");
$("#success").delay(4000).fadeOut("slow");
$("#fail").delay(4000).fadeOut("slow");
</script>