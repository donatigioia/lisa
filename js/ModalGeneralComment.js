var source;
var target;
var comment;
var sourceID;
var generalCommentID;
var generalCommentCount;
var inputFile;

function initializeModalAddGeneralComment(element,json)
{	
	comments			= JSON.parse(json);
	generalCommentCount = -1;
	sourceID		    = $(element).attr("data-sourceID");
	inputFile           = $(element).attr("data-inputFile");
 	$('#generalComment').val("Add your Comment Here");
	$('#addComment').modal('show');
	generalCommentID	= "";
	document.getElementById("idComment").innerHTML     = "<b> id: </b> &nbsp"
}

function nextComment()
{	
	if(generalCommentCount == 0 )
	{
		document.getElementById("addGeneralComment").disabled 			= false;
	}

	if (generalCommentCount < comments.length -1)
	{
		generalCommentCount ++;
		generalCommentID = comments[generalCommentCount][0];
		$('#generalComment').val(comments[generalCommentCount][1]);
		document.getElementById("previusGeneralComment").disabled       = false; 
		document.getElementById("remove").disabled 						= false;
		document.getElementById("addGeneralComment").innerHTML 		= "Edit";
	}
	else
	{
		document.getElementById("nextGeneralComment").disabled 			= true;
	}
	if(generalCommentCount == comments.length -1)document.getElementById("nextGeneralComment").disabled 			= true;
	document.getElementById("idComment").innerHTML     = "<b> id: </b> &nbsp" + comments[generalCommentCount][0];
	document.getElementById("numberComment").innerHTML = "<b> Comment: </b> " + (generalCommentCount+1) +"/"+ comments.length;
}

function previusComment()
{
	if(generalCommentCount == 0 )
	{
			document.getElementById("addGeneralComment").innerHTML 		= "Add";
	}

	if(generalCommentCount<=0)
	{	
		generalCommentID  = "";
		generalCommentCount --;
		document.getElementById("numberComment").innerHTML = "<b> New comment: </b>";	
		$('#generalComment').val("Add your Comment Here");
		document.getElementById("previusGeneralComment").disabled 		 = true;
		document.getElementById("remove").disabled         				 = true;
		document.getElementById("nextGeneralComment").disabled 		     = false; 
		document.getElementById("idComment").innerHTML     = "<b> id: </b> &nbsp";

	}
	else if (generalCommentCount > 0)
	{
		generalCommentCount --;
		generalCommentID = comments[generalCommentCount][0];
		$('#generalComment').val(comments[generalCommentCount][1]);
		document.getElementById("nextGeneralComment").disabled 			  = false; 
		document.getElementById("numberComment").innerHTML = "<b> Comment:</b> " + (generalCommentCount+1) +"/"+ comments.length;
		document.getElementById("idComment").innerHTML     = "<b> id: </b> &nbsp" + generalCommentID;
	}	
}

function removeGeneralComment()
{
	window.open("classes/removeComment.php?comment=" + document.getElementById("generalComment").value + "&commentID=" + generalCommentID + "&sourceID=" + sourceID + "&inputFile="+inputFile+"&severity=" + document.getElementById("severity").value + "&typeComment=General","title",'scrollbars=no,resizable=yes, width=300,height=100,status=no,location=center, toolbar=no');
}

function upDateGeneralComment(user)
{
	window.close();
	window.open("classes/addComment.php?comment=" + document.getElementById("generalComment").value + "&commentID=" + generalCommentID + "&user="+user+"&sourceID=" + sourceID + "&inputFile="+inputFile+"&severity=" + document.getElementById("severity").value + "&typeComment=General","title",'scrollbars=no,resizable=yes, width=300,height=100,status=no,location=center, toolbar=no');
}
