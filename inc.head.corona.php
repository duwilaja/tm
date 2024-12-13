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
	.form-control[readonly], form-control.disabled{
		background: #2A3038; color: #888;
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
	select.form-control, select.asColorPicker-input, .dataTables_wrapper select, .jsgrid .jsgrid-table .jsgrid-filter-row select, .select2-container--default select.select2-selection--single, .select2-container--default .select2-selection--single select.select2-search__field, select.typeahead, select.tt-query, select.tt-hint{
		color: #ddd;
	}
	input.form-control:focus, select.form-control:focus{
		color: #ddd;
	}
	#txtmsg{
		max-height: 350px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	.select2-container--default .select2-results__option[aria-selected="true"] {
	  background-color: #444;
	}
	</style>
  </head>
  <body class="sidebar-icon-only">
    <div class="container-scroller">
