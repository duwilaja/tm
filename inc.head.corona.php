<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $app." - ".$title;?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="corona/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="corona/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End Plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css" />
	<link rel="stylesheet" type="text/css" href="corona/assets/vendors/css/select2.min.css" />
	<link rel="stylesheet" type="text/css" href="corona/assets/vendors/css/select2.bootstrap.min.css" />
    <link rel="stylesheet" href="corona/bs4/bootstrap.css">
    <link rel="stylesheet" href="corona/bs4/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="corona/bs4/buttons.bootstrap4.css">
    <link rel="stylesheet" href="corona/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="favicon-16.png" />
	<style type="text/css">
	.hidden{
		display: none;
	}
	.modal-backdrop {
	  position: fixed;
	  top: 0;
	  left: 0;
	  z-index: 0;
	  width: 100vw;
	  height: 100vh;
	  background-color: rgba(200,200,200,0.4);
	}
	.close{
		color: white;
	}
	div.card-title{
		display: flex;
		justify-content: space-between;
	}
	.panel-body{
		padding: 15px;
	}
	div.datepicker td span {
	  display: block;
	  width: 31%;
	  height: 54px;
	  line-height: 54px;
	  float: left;
	  margin: 2px;
	  cursor: pointer;
	  text-align: center;
	}
	div.datepicker thead tr:first-child th {
	  cursor: pointer;
	  padding: 8px 0px;
	  text-align: center;
	}
	div.datepicker td.day:hover {
	  background: #F5F5F5;
	  cursor: pointer;
	  text-align: center;
	}
	.main-card{
		overflow: auto;
	}
	.pull-right{
		float: right;
	}
	.tile {
	  width: 100%;
	  float: left;
	  margin: 0px;
		margin-bottom: 0px;
	  list-style: none;
	  text-decoration: none;
	  font-size: 38px;
	  font-weight: 300;
	  color: #FFF;
	  -moz-border-radius: 0px;
	  -webkit-border-radius: 0px;
	  border-radius: 0px;
	  padding: 10px;
	  margin-bottom: 20px;
	  min-height: 100px;
	  position: relative;
	  border: 1px solid #D5D5D5;
		border-top-color: rgb(213, 213, 213);
		border-right-color: rgb(213, 213, 213);
		border-bottom-color: rgb(213, 213, 213);
		border-left-color: rgb(213, 213, 213);
	  text-align: center;
	}
	.sidebar .sidebar-brand-wrapper .sidebar-brand.brand-logo-mini img{
		width: 28px;
	}
	.navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini img{
		width: 28px;
	}
	.error{
		color: orange;
	}
	div.table-responsive > div.dt-container > div.row{
		margin: 10px;
	}
	#txtmsg{
		max-height: 350px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	textarea.form-control.form-control-sm{
		height: auto;
	}
	h3.card-title{
		margin-top: 5px;
		font-size: 1rem;
		font-weight: bold;
		padding-left: 10px;
	}
	.card{
		border-radius: 15px;
		margin-top: 5px;
	}
	.card-heading{
		border-bottom-color: #888;
		border-bottom-style: solid;
		border-bottom-width: 1px;
	}
	.mywijet{
		text-align: center;
		width: 100%;
	}
	.mywijet > span{
		font-size: 20px;
	}
	.mywijval{
		padding: 5px;
		font-size: 35px;
		text-align: center;
	}
	.mywijtxt{
		text-align: center;
		padding : 5px;
		bottom: 0px;
		position: absolute;
		width: 100%;
		border-radius: 0 0px 10px 10px;
	}
	.mywijtxts{
		font-size: 20px;
	}
	
<?php if(!$dark){?>
	.content-wrapper{
		background: #f6f7fb;
	}
	body{
		color: #000;
	}
	.card{
		background-color: #ffffff;
	}
	.card .card-title{
		color: #000;
	}
	.tile{
		background-color: #f0f0f0;
		border-radius: 15px;
		border-color: #000;
		color: #000;
	}
	.table-dark{
		background-color: #f6f7fb;
	}
	.table{
		color: #000;
	}
	.table thead th{
		color: #000;
	}
	.form-control {
		background-color: #ddd;
		color: #222;
		border: none;
	}
	input.form-control:focus, select.form-control:focus, textarea.form-control:focus{
		background-color: #ddd;
		border: none;
	}
	.form-control[readonly], form-control.disabled {
	  color: #888;
	  border: none;
	}
	.select2-container--default .select2-selection--single, .select2-container--default .select2-dropdown, .select2-container--default .select2-selection--multiple {
		border-color: #2c2e33;
		background: #ddd;
		border: none;
	}
	.navbar{
		background-color:  #ffffff;
	}
	.navbar .navbar-menu-wrapper{
		color: #222222;
	}
	.navbar .navbar-menu-wrapper .search input {
		background: #e4e4e4;
		color: #222;
		border: none;
	}
	.modal-content{
		background-color: #fdfdfd;
	}
	.btn-default{
		background-color: #aaa;
	}
	.page-title{
		color: #222;
	}
	.navbar .navbar-brand-wrapper{
		background: #ffffff;
	}
	.close{
		color: unset;
	}
	.sidebar{
		background-color: #ffffff; /*#424d69;*/
		box-shadow: 20px 19px 34px -15px rgba(0, 0, 0, 0.5);
	}
	.sidebar .sidebar-brand-wrapper{
		background-color: #ffffff; /*#424d69;*/
	}
	.footer{
		background-color: #ffffff; /*#424d69;*/
	}
	.navbar .navbar-menu-wrapper{
		-webkit-box-shadow:  unset;
		box-shadow: unset;
	}
<?php }else{ ?>
	select.form-control, select.asColorPicker-input, .dataTables_wrapper select, .jsgrid .jsgrid-table .jsgrid-filter-row select, .select2-container--default select.select2-selection--single, .select2-container--default .select2-selection--single select.select2-search__field, select.typeahead, select.tt-query, select.tt-hint{
		color: #ddd;
	}
	.select2-container--default .select2-selection--single, .select2-container--default .select2-dropdown, .select2-container--default .select2-selection--multiple {
	  border-color: #2c2e33;
	  background: #2A3038;
	}
	.select2-container--default .select2-selection--single .select2-search__field, .select2-container--default .select2-dropdown .select2-search__field, .select2-container--default .select2-selection--multiple .select2-search__field {
	  border-color: #2c2e33;
	  color: #ddd;
	}
	.select2-container--default .select2-results__option[aria-selected="true"] {
	  background-color: #444;
	}
	input.form-control:focus, select.form-control:focus{
		color: #ddd;
	}
	.form-control[readonly], form-control.disabled{
		background: #2A3038; color: #888;
	}
<?php }?>
	.main-panel{
		padding-top: 50px;
	}
	.navbar .navbar-menu-wrapper{
		height: 50px;
	}
	.sidebar .sidebar-brand-wrapper{
		height: 50px;
	}
    @media (min-width: 992px){
		.sidebar-icon-only .sidebar .nav {
			overflow: hidden;
		}
		.sidebar-icon-only .sidebar {
		  width: 0px;
		}
		.sidebar-icon-only .page-body-wrapper {
			width: 100%;
		}
	}
	.indonut{
		width: 100%; 
		height: 40px; 
		position: absolute; 
		top: 70px; 
		margin-top: -20px; 
		line-height:19px; 
		text-align: center; 
		z-index: 1;
		font-size: 40px;
	}
	.bg-pink{
		background-color: #D5739D;
	}
	.bg-red{
		background-color: #EA6B66;
	}
	.bg-purple{
		background-color: #A680B8;
	}
	.bg-green{
		background-color: #97D077;
	}
	.bg-orange{
		background-color: #FFA500;
	}
	a.ahome{
		text-decoration: none;
		color: #000;
	}
	a.ahome:hover{
		text-decoration: none;
		color: #000;
	}
	.btn-progress{
		background-color: #d2691e;
	}
	.btn-solved{
		background-color: #2e8b57;
	}
	.btn-closed{
		background-color: #fa8072;
	}
	<?php if($menu=='home'){?>
	.card{
		box-shadow: 5px 5px 5px 0 rgba(0,0,0,0.50);
	}
	<?php }?>
	.card .card-body{
		padding-top:5px;
		padding-bottom:5px;
	}
	</style>
  </head>
  <body class="sidebar-icon-only">
    <div class="container-scroller">
