<?php
include 'classes/FileList.class.php';
include 'classes/QAReview.class.php';
ini_set("display_errors", 0);
$files = new OpenFile();
?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="pgn-wrapper" data-position="top">
				<div class="pgn push-on-sidebar-open pgn-bar">
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">×</span><span class="sr-only">Close</span>
						</button>
						<div align="center">
							<span><h5><b>Welcome  <?php echo $_GET["user"]; ?>!</b>
							<br>
							Choose the document to continue! </h5></span>
						<div>
					</div>
				</div>
			</div>
			
		
    			<h2>  Recent File: </h2> 
		
			<div class="panel panel-transparent m-t-10" style="width: 70%;">
				<table class="table table-hover dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
					<thead>
						<tr role="row">
							<th style="width: 40%;">	File Name	    </th>
							<th style="width: 40%;">	File Size   	</th>
							<th style="width: 20%;">	  				</th>
						</tr>
						<tr>
						<form action="classes/Upload.class.php?user=<?php echo $_GET['user']; ?>" method="post" enctype="multipart/form-data">
    						<th></th>
    						<th><input type="file" name="fileToUpload" id="fileToUpload"></th>
    						<th><button name="subject"  class="btn btn-sm  btn-rounded btn-primary" name="fileToUpload" id="fileToUpload" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>   </th>				
    					</form>
    					</tr>
						<?= $files->fileList();?>
					</thead>
				</table>
			</div>
		</div>
	</body>
</html>

<div id="notification"></div>


<script>
function deleteFile(documents,user)
{
	window.close();
	window.open("classes/deleteFile.class.php?document=" + documents+"&user="+ user);
}
function downloadFile(documents,user)
{
	window.open("classes/downloadFile.class.php?document=" + documents+"&user="+ user);
}

function chooseFile(documents,user)
	{
		window.close();
		window.open("review.php?document=../" + documents+"&user="+ user);
	}
</script>

<script src="js/ModalCorrectionComment.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
 <script src="js/notify.js"></script>


<script class="demo">
var query = window.location.search.substr(1);
query=query.replace(/%20/g, " ");
var par = query.split('&'); 
var c=0; var val = new Array();
	while(par.length > c)
	{
  		val[c] = par[c].split('=');
 	 	c++;
	}
$.notify(val[1][1], val[2][1]);


</script>


