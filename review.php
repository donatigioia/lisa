<?php
include 'classes/QAReview.class.php';
include 'classes/ModalFactory.class.php';
ini_set("display_errors", 0);
$translation = new QAReview();
$translation->file =  substr($_GET["document"],3);
$translation->user = $_GET["user"];
$modal = new ModalFactory();
$file = $_GET["document"];
$file= substr($file,3);
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
	<div class="pgn-wrapper" data-position="top">
		<div class="pgn push-on-sidebar-open pgn-bar">
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">×</span><span class="sr-only">Close</span>
				</button>
				<div align="center">
					<span> <h5><b><?php echo $file;?></b> <br>
					 was successfully open! </h5></span>
				 </div>
			</div>
		</div>
	</div>
	<div class="container" style="width:90%;">
		<div align="center">
			<h2>QAReview</h2> 
		</div>
		<br>
		<b> LANGUAGE COMBINATION: </b>
		<?=$translation->getLanguage();?>
		<br>
		<div class="panel panel-transparent m-t-10" align="right">
            <div class="panel-body" >
                <table  class="table table-hover dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" >
                 	<thead>
                  		<tr role="row">
                  			<th style="width: 40%;">	Source 	    </th>
                  			<th style="width: 40%;">	Target   	</th>
                  			<th style="width: 8%;">	    Comment 	</th>
                  			<th style="width: 15%;">	Controller 	</th>
                  		</tr>
                  	</thead>
                  	<?=$translation->OpenDocument();?>
                </table>           
            </div>
            <button type="button" onclick='report( "<?=$translation->file ?>");' class="btn btn-primary">       	   Report      </button>
            <button type="button" onclick="window.close();" class="btn btn-primary">       Close       </button>
        </div>
		<div class="modal fade" id="modalAddQuality" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" align="center">	
						<h4 class="modal-title" >Quality Assessment item</h4>
					</div>
					<div class="modal-body">
						<form>
							<fieldset>
								<legend id="legend"><h2> <img src="images/+.gif" width="19">  Add Quality Assessment item to report translation issues:</h2></legend>
								<div style="float:left; display:block; width:70%;"  id="category">Category:
									<select id="categorySelect" name="category">
											<?=$modal->printCategory();?>
										</select>
								</div>
								<div id="severity">	Severity:
								<select id="severitySelect" name="severity">
									<option value="Critical">Critical</option>
									<option value="Major">Major</option>
									<option value="Minor">Minor</option>
								</select>
								</div>
								<br>
								<div style="float:left; display:block; width:38%; height:20%;">
									<fieldset>
										<legend><h4>Comment:</h4></legend>
										<textarea rows="4" cols="48" id="comment" class="comment"></textarea>
										<legend ><h4>Error Deleted:</h4></legend>
										<div id="Error_Deleted" style="color:red; "> </div>
									</fieldset>
								</div>
								<div style="float:left; display:block; width:10%; height:20%;" align="center">
									<fieldset>
										<br>
										<br>
										<br>
										<button type="button" class="btn btn-primary" id = "previusCorrectionComment" disabled = true onclick="previusComment2();"> < </button>
										<br>
										<br>
										<button type="button" class="btn btn-primary" id = "nextCorrectionComment" onclick="nextComment2();" > 	> </button>
									</fieldset>
								</div>
								<fieldset id="correctCommentDetail">
									<div style="float:left; display:block; width:65%;">
									<legend><h4>Detail:</h4></legend>
										<b>Added From:</b>
										<div id="Added_From"> </div>
										<b>In Date:</b>
									    <div id="In_Date"> </div> 
									    <b>Severity:</b>
									    <div id="Severity"> </div> 
									    <b>Category:</b>
									    <div id="Category"> </div> 
									</div>								
								</fieldset>
								<br>
								<div id="space"> <br><br><br><br></div>
								<b>Source segment content: </b>
								<br>
								<div class="panel panel-default">
									<div class="panel-body">
										<div id="sourceSegment"></div>
									</div>
								</div>
								<b>Target segment content: </b>
								<br>
								<div class="panel panel-default">
									<div class="panel-body">
										<input="text" id="modalTargetSegment" readonly>
									</div>
								</div>
								<fieldset align="right">
									<button type="button" class="btn btn-warning btn-cons" id="help">Help</button>
									<button type="button" class="btn btn-danger btn-cons" onclick="$('#modalAddQuality').modal('hide');">Cancel</button>
									<button type="button" onclick="upDateSpecificComment('<?=$translation->user;?>');" class="btn btn-success btn-cons" id="addCorrectionComment">Add</button>
								</fieldset>
								
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="addComment" role="dialog">
			<div class="modal-dialog" style="width: 30%!important;">
				<div class="modal-content">
					<div class="modal-header">	
						<h4 class="modal-title">         <b> General Comment </b> </h4>
					</div>

					<div class="modal-body">
						<p id="idComment" align="right"> <b> id:             </b> </p>
						<p id="numberComment">           <b> New comment:    </b> </p>
						<form>
							<textarea style="width: 100%; height: 30%;" id="generalComment" class="comment"> </textarea>
						</form>
						<br>
						<button type="button" class="btn btn-primary" id="previusGeneralComment"  onclick="previusComment();" disabled = true> Previus   </button>
						<button type="button" class="btn btn-primary" id="nextGeneralComment" onclick="nextComment();">  Next 	 </button>
						<p align="right">
							<button type="button" class="btn btn-warning btn-cons" onclick="$('#addComment').modal('hide');"> Cancel </button>
							<button type="button" class="btn btn-success btn-cons" id="addGeneralComment" onclick="upDateGeneralComment('<?=$translation->user;?>');$('#addComment').modal('hide');"> Add</button>
							<button type="button" class="btn btn-danger btn-cons" id="remove" onclick="removeGeneralComment();$('#addComment').modal('hide');" disabled = true> Delete</button>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="insertWord" role="dialog">
			<div class="modal-dialog" style="width: 20%!important;">
				<div class="modal-content" align="center">
					<div class="form-group form-group-default required">
						<br>
						<label><b>Insert Correction</b></label>
						<br>
						<br>
						<div id="preAdded"></div><input type="text" id="inseredWord" style="width: 90%;"><div id="postAdded"></div>
						<br>
						<button type="button" class="btn btn-warning btn-cons" onclick="$('#insertWord').modal('hide');"> Cancel </button>
						<button type="button" class="btn btn-success btn-cons" onclick="initializeModalAddQuality(this);$('#insertWord').modal('hide');">Insert</button>
						<br>
					</div>
					</div>
				</div>
			</div>
		</div>
	</body>
<script src="js/modalAndText.js"></script>
<script src="js/ModalGeneralComment.js"></script>
<script src="js/ModalCorrectionComment.js"></script>
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
	$.notify(val[2][1], val[3][1]);
</script>
