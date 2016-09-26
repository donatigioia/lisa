<?php
include 'classes/report.class.php';
$report = new Report();
ini_set("display_errors", 0);
?>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body>
		<div class="container" style="width:90%;">
				<div align="center">
      		        <h2> Report</h2> 
      		 	</div>
      		    <br>
      		    <table  class="table table-hover dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="width:50%;" >
      		    	<thead>
      		   		<?=$report->createReport();?>
      		     