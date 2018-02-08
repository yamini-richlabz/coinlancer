<!DOCTYPE html>
<html>
<head>
    <?php echo $this->load->view(ADMIN_CSS_INCLUDE_PATH); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <?php echo $this->load->view(ADMIN_HEADER_PATH); ?>
    <?php echo $this->load->view(ADMIN_SIDEBAR_PATH); ?>
    <?php echo $this->load->view(ADMIN_CONTENT_PATH); ?>
    <?php echo $this->load->view(ADMIN_FOOTER_PATH); ?>
    <?php echo $this->load->view(ADMIN_JS_INCLUDE_PATH); ?>
	<script src="<?php echo ADMIN_JS_PATH; ?>dashboard2.js"></script>
</body>
</html>
