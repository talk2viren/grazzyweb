<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('vendors/css/bootstrap.css');?>" rel="stylesheet">
	
	 
	<link href="http://localhost/peptkraf/app/themes/default/assets/css/examples.css">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('vendors/css/font-awesome.min.css');?>"  rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('vendors/css/nprogress.css');?>" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url('vendors/css/bootstrap-progressbar-3.3.4.min.css');?>" rel="stylesheet">
	
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url('vendors/css/daterangepicker.css');?>"  rel="stylesheet">
	
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('vendors/css/custom.min.css');?>" rel="stylesheet">

	 <link href="<?php echo base_url('vendors/css/bootstrap-table.css ');?>" rel="stylesheet">
	<script src="<?php echo base_url('vendors/js/jquery.min.js');?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url('vendors/js/bootstrap.min.js');?>"></script>
	<?php if($this->auth->is_logged_in(false, false)):?>
		
	<style type="text/css">
		
		@media (max-width: 979px){ 
			body {
				margin-top:0px;
			}
		}
		@media (min-width: 980px) {
			.nav-collapse.collapse {
				height: auto !important;
				overflow: visible !important;
			}
		 }
		
		.nav-tabs li a {
			text-transform:uppercase;
			background-color:#f2f2f2;
			border-bottom:1px solid #ddd;
			text-shadow: 0px 1px 0px #fff;
			filter: dropshadow(color=#fff, offx=0, offy=1);
			font-size:12px;
			padding:5px 8px;
		}
		
		.nav-tabs li a:hover {
			border:1px solid #ddd;
			text-shadow: 0px 1px 0px #fff;
			filter: dropshadow(color=#fff, offx=0, offy=1);
		}

	</style>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.redactor').redactor({
				minHeight: 200,
				imageUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_image');?>',
				fileUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_file');?>',
				imageGetJson: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/get_images');?>',
				imageUploadErrorCallback: function(json)
				{
					alert(json.error);
				},
				fileUploadErrorCallback: function(json)
				{
					alert(json.error);
				}
		  });
	});
	</script>
	<?php endif;?>
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
	<?php if($this->auth->is_logged_in(false, false)):?>
	<?php $admin_url = site_url($this->config->item('admin_folder')).'/';?>
		<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?=$admin_url;?>" class="site_title"><i class="fa fa-paw"></i> <span>POS</span></a>
            </div>

            <div class="clearfix"></div>
			<div class="profile clearfix">
             
              <div class="profile_info">
				<?php $userdata = $this->session->userdata('admin'); ?>
                <h2>Welcome,<?=$userdata['firstname'];?></h2>
                
              </div>
            </div>
            

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
				<?php if($this->auth->check_access('Restaurant manager')) : ?>
						<li><a href="<?php echo $admin_url;?>orders/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
						<li><a href="<?php echo $admin_url;?>restaurant"><i class="fa fa-home"></i> Control <span class=""></span></a>
							<ul class="nav child_menu">
							<!--  <li><a href="<?php echo $admin_url;?>restaurant">Restaurants</a></li>-->
							</ul>
						</li>
						<li><a href="<?php echo $admin_url;?>orders/previousorders"><i class="fa fa-home"></i>Previous Orders </a></li>
							
						<li><a href="<?php echo $admin_url;?>orders/RequestBill"><i class="fa fa-home"></i> Request Bill <span class=""></span></a></li>
						 <li><a href="<?php echo $admin_url;?>orders/SalesChart"><i class="fa fa-home"></i> <?php echo lang('common_sales') ?> <span class=""></span></a>
						<ul class="nav child_menu">
						
						</ul>
					</li>
				<?php endif; ?>
                <?php if($this->auth->check_access('Deliver manager')) : ?>
						<li><a><i class="fa fa-home"></i> Orders <span class="fa fa-chevron-down"></span></a>
							<ul class="nav child_menu">
							  <li><a href="<?php echo $admin_url;?>orders/delpartnerorders">New orders</a></li>
							  <li><a href="<?php echo $admin_url;?>orders/previousordersdelpartner">Previous Orders</a></li>
							</ul>
						</li>
						<li><a href="<?php echo $admin_url;?>deliveryboy"><i class="fa fa-home"></i> Delivery Boy </a></li>
				<?php endif; ?>
                <?php if($this->auth->check_access('Admin')) : ?>
					<!--<li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>-->
					<li><a href="<?php echo $admin_url;?>dashboard"><i class="fa fa-home"></i> Dashboard <span class=""></span></a>
						<ul class="nav child_menu">
					<!--	    <li><a href="<?php echo $admin_url;?>dashboard">Restaurant/Pitstops</a></li> -->
                           <!-- <li><a href="<?php echo $admin_url;?>dashboard/recentinfo">Recent information</a></li>-->
						</ul>
					</li>
					
					<li><a href="<?php echo $admin_url;?>deliverypartner"><i class="fa fa-home"></i>Delivery Partner </a></li>
                    <li><a><i class="fa fa-home"></i> <?php echo lang('common_sales') ?> <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
						    <li><a href="<?php echo $admin_url;?>orders/previousordersdelpartner">Previous orders</a></li>
                            <li><a href="<?php echo $admin_url;?>customers"><?php echo lang('common_customers') ?></a></li>
                             <!--<li><a href="<?php echo $admin_url;?>customers/groups"><?php echo lang('common_groups') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>reports"><?php echo lang('common_reports') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>coupons"><?php echo lang('common_coupons') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>giftcards"><?php echo lang('common_giftcards') ?></a></li>-->
						</ul>
					</li>
					<li><a><i class="fa fa-home"></i> <?php echo lang('common_catalog') ?> <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="<?php echo $admin_url;?>categories"><?php echo lang('common_categories') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>restaurant">Restaurants</a></li>
							<li><a href="<?php echo $admin_url;?>pitstop">Pitstops</a></li>
						</ul>
					</li>
                   <li><a><i class="fa fa-home"></i> <?php echo lang('common_administrative') ?>  <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<!-- <li><a href="<?php echo $admin_url;?>settings"><?php echo lang('common_gocart_configuration') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>shipping"><?php echo lang('common_shipping_modules') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>payment"><?php echo lang('common_payment_modules') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>settings/canned_messages"><?php echo lang('common_canned_messages') ?></a></li>
                            <li><a href="<?php echo $admin_url;?>locations"><?php echo lang('common_locations') ?></a></li>-->
                            <li><a href="<?php echo $admin_url;?>admin"><?php echo lang('common_administrators') ?></a></li>
						</ul>
					</li>
					<li><a><i class="fa fa-home"></i>Messages <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu">
							<li><a href="<?php echo $admin_url;?>message/restmessage">Restaurant message</a></li>
                            <li><a href="<?php echo $admin_url;?>message/delmessage">Delivery partner message</a></li>
							<li><a href="<?php echo $admin_url;?>message/custmessage">customer message</a></li>
                            <li><a href="<?php echo $admin_url;?>message/notifications">Notification messages</a></li>
						</ul>
					</li>
                    <?php endif; ?>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

           
          </div>
        </div>
		 <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
               
                <li><a href="<?php echo site_url($this->config->item('admin_folder').'/login/logout');?>"><?php echo lang('common_log_out') ?></a></li>
                  

              <!--  <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
	<?php endif; ?>
<div class="right_col" role="main" style="overflow: auto;min-height:700px;">
	<div class="container">
	
		<?php
		//lets have the flashdata overright "$message" if it exists
		if($this->session->flashdata('message'))
		{
			$message    = $this->session->flashdata('message');
		}
		
		if($this->session->flashdata('error'))
		{
			$error  = $this->session->flashdata('error');
		}
		
		if(function_exists('validation_errors') && validation_errors() != '')
		{
			$error  = validation_errors();
		}
		?>
		
		<div id="js_error_container" class="alert alert-error" style="display:none;"> 
			<p id="js_error"></p>
		</div>
		
		<div id="js_note_container" class="alert alert-note" style="display:none;">
			
		</div>
		
		<?php if (!empty($message)): ?>
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($error)): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $error; ?>
			</div>
		<?php endif; ?>
	</div>      

	<div class="container">
		<?php if(!empty($page_title)):?>
		<div class="page-header">
			<h1><?php echo  $page_title; ?>
			<?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
			<!--<span class="pull-right" style="font-size:16px;"><a href="<?=$_SERVER['HTTP_REFERER'];?>">Back</a></span>-->
			<?php } ?>
			</h1>
			
		</div>
		<?php endif;?>
    
    