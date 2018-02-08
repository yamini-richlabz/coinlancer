<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Admin Navigations</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
       
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo ADMIN_PATH.'Master/category_view'; ?>"><i class="fa fa-circle-o"></i> Add Category</a></li>
            <li><a href="<?php echo ADMIN_PATH.'Master/list_category'; ?>"><i class="fa fa-circle-o"></i> List Category</a></li>
            <li><a href="<?php echo ADMIN_PATH.'Master/subcategory_view'; ?>"><i class="fa fa-circle-o"></i> Add Subcategory</a></li>
            <li><a href="<?php echo ADMIN_PATH.'Master/list_subcategory'; ?>"><i class="fa fa-circle-o"></i>List Subcategory</a></li>
            <li><a href="<?php echo ADMIN_PATH.'Slider_ctrl/slider_view'; ?>"><i class="fa fa-circle-o"></i>Add Slider</a></li>
          </ul>
        </li>
        <li><a href="#"><span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>