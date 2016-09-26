var source;
var target;
var comments;
var sourceID;
var inputFile;
var xmlTarget;
var type;
var generalCommentID;
var correctionCommentCount;

function initializeModalAddQuality(element,json)
{	
	if(document.getElementById("inseredWord").value == "")
	{
		correctionCommentCount = 0;
		type="FeedbackDeleted";
		severity="";
    	try
    	{
    		comments = JSON.parse(json);
   			target   = $(element).attr("data-target");
   			document.getElementById("comment")		.value			= comments[0][3][0];
   			document.getElementById("Error_Deleted").innerHTML		= "<b><s>"+comments[0][1]+"</s></b>";
   			document.getElementById("Added_From")	.innerHTML		= comments[0][3]["@attributes"]["user"];
   			document.getElementById("In_Date")		.innerHTML    	= comments[0][3]["@attributes"]["date"];
   			document.getElementById("Severity")		.innerHTML		= convertSeverity(comments[0][5]);
   			document.getElementById("Category")		.innerHTML		= convertCategory(comments[0][6]);
   			$("#nextCorrectionComment").notify("Scroll the comments","info");
   			$("#addCorrectionComment").hide();
   			$("#severity").hide();
   			$("#category").hide();
   			$("#legend").hide();
   			$("#space").hide();
		}
		catch(err)
		{
    	 	target   = $(element).attr("output");
    	 	error    = $(element).attr("error");
    	 	$("#previusCorrectionComment").hide();
    	 	$("#nextCorrectionComment").hide();
			document.getElementById("Error_Deleted").innerHTML		="<b><s>"+error+"</s></b>";
			$("#comment").notify("Insert Here Your Comment","info");
			$("#severitySelect").notify("Set Here the severity","info");	
		}
	
		source       = $(element).attr("data-source");
		sourceID	 = $(element).attr("data-sourceID");
		inputFile    = $(element).attr("data-inputFile");
		$('#modalTargetSegment').html(target);
		$('#modalAddQuality').modal('show');
		$('#sourceSegment').html(source);	
		xmlTarget = enXml(target);    
	}
	else
	{
		type="FeedbackAdded";
		sourceID  = $("#addComment").attr("data-sourceID");
		inputFile = $("#addComment").attr("data-inputFile");
		target    = $("#addComment").attr("data-target");
		target    = target.split("<div>");
		target[1] = target[1].split("</div>").join("");
		$('#modalAddQuality').modal('show');
		original = target[0] + target[1];
		target   = target[0] +"<u><font color='green'>"+ document.getElementById("inseredWord").value +"</font></u>" + target[1];
		$('#modalTargetSegment').html(target);
		xmlTarget = enXml(target);
	}
}

function enXml(target)
{
	//Here I create the Xml structure for insert in the file
	xml = target.split("<s>").join("");
	xml = xml.split("</s>").join("");
	xml = xml.split("<i>").join("");
	xml = xml.split("</i>").join("");
	xml = xml.split("<u><font color='red'>").join("<mrk mtype=\"x-sdl-feedback-deleted\" sdl:revid=\"N3w1D15\">");
	xml = xml.split("<u><font color='green'>").join("<mrk mtype=\"x-sdl-feedback-added\" sdl:revid=\"N3w1D15\">");
	xml = xml.split("<u><font color='green'>").join("<mrk mtype=\"x-sdl-feedback-added\" sdl:revid=\"N3w1D15\">");
	xml = xml.split("</font></u>").join("</mrk>");
	xml = xml.split("<font color='red'>").join("<tag>");
	xml = xml.split("<font color=\"red\">").join("<tag>");
	xml = xml.split("</font>").join("</tag>");
	xml = xml.split("<font color='green'>").join("<tag>");
	xml = xml.split("<font color=\"green\">").join("<tag>");
	xml = xml.split("</font>").join("</tag>");
	return xml;
}

function nextComment2()
{	
	if (correctionCommentCount < comments.length -1)
	{
		correctionCommentCount ++;
		generalCommentID = comments[correctionCommentCount][0];
		document.getElementById("comment").value 					 		  = comments[correctionCommentCount][3][0];
		document.getElementById("Added_From").innerHTML				 		  = comments[correctionCommentCount][3]["@attributes"]["user"];
   		document.getElementById("In_Date").innerHTML				 		  = comments[correctionCommentCount][3]["@attributes"]["date"];
   		document.getElementById("Severity").innerHTML				 		  = comments[correctionCommentCount][3]["@attributes"]["severity"];
		document.getElementById("Error_Deleted").innerHTML			 		  = "<b><s>"+comments[correctionCommentCount][1] + "</s></b>";
		document.getElementById("previusCorrectionComment").disabled 		  = false;
		document.getElementById("Severity")		.innerHTML					  = convertSeverity(comments[correctionCommentCount][5]);
		document.getElementById("Category")		.innerHTML					  = convertCategory(comments[correctionCommentCount][6]);
	}
	else
	{
		document.getElementById("nextCorrectionComment").disabled             = true; 
	}
	if(correctionCommentCount == comments.length -1)
	{
		document.getElementById("nextCorrectionComment").disabled             = true; 
	}
	document.getElementById("idComment").innerHTML     = "<b> id: </b> &nbsp" + comments[correctionCommentCount][0];
	document.getElementById("numberComment").innerHTML = "<b> Comment: </b> " + (correctionCommentCount+1) +"/"+ comments.length;
}

function previusComment2()
{
	if(correctionCommentCount < 0)
	{	
		generalCommentID  = "";
		correctionCommentCount --;
		document.getElementById("previusCorrectionComment").disabled 		  = true;
		document.getElementById("nextCorrectionComment") .disabled 		      = false; 
	}
	else if (correctionCommentCount > 0)
	{
		correctionCommentCount --;
		generalCommentID = comments[correctionCommentCount][0];
		document.getElementById("comment").value				  =comments[correctionCommentCount][3][0];
		document.getElementById("Added_From").innerHTML			  = comments[correctionCommentCount][3]["@attributes"]["user"];
   		document.getElementById("In_Date").innerHTML			  = comments[correctionCommentCount][3]["@attributes"]["date"];
   		document.getElementById("Severity").innerHTML			  = comments[correctionCommentCount][3]["@attributes"]["severity"];
		document.getElementById("Error_Deleted").innerHTML		  ="<b><s>"+comments[correctionCommentCount][1]+"</s></b>";
		document.getElementById("nextCorrectionComment").disabled = false;
		document.getElementById("Severity")		.innerHTML		  = convertSeverity(comments[correctionCommentCount][5]);
		document.getElementById("Category")		.innerHTML		  = convertCategory(comments[correctionCommentCount][6]);
	}
	if(correctionCommentCount == 0)
	{
		document.getElementById("previusCorrectionComment").disabled 		  = true;
	}
}
function upDateSpecificComment(user)
{
	e = document.getElementById("severitySelect");
	strUser = e.options[e.selectedIndex].text;
	strUser= reConvertSeverity(strUser);
	category = document.getElementById("categorySelect");
	cat = category.options[category.selectedIndex].text;

	window.open("classes/ModifyCorrectedCommentXMLFile.class.php?comment="+document.getElementById("comment").value +"&type="+ type +"&user="+user+"&sourceID=" + sourceID +"&inputFile=" + inputFile + "&xmlTarget=" + xmlTarget + "&inputFile=" + inputFile + "&severity=" + severity + "&category=" + cat,"title",'scrollbars=no,resizable=yes, width=300,height=100,status=no,location=center, toolbar=no');
}

function convertSeverity(code) 
{
	switch (code)
    {
   		case "d5dc4095-a183-4d0c-8a5d-e27f5ee9111d":
   		    severity = "Minor";
   		    break;
   		case "8ffa4412-ab8c-4f24-94a1-7f6bd5545910":
   		    severity = "Major";
   		    break;
   		case "9555fe0f-f111-442a-aa0f-da1344859a96":
   		severity = "Critical";
   		break;
   	}
   	return severity;
}

function reConvertSeverity(code)
{
	switch (code)
    {
   		case "Minor":
   		    severity = "d5dc4095-a183-4d0c-8a5d-e27f5ee9111d";
   		    break;
   		case  "Major":
   		    severity ="8ffa4412-ab8c-4f24-94a1-7f6bd5545910"; 
   		    break;
   		case "Critical":
   			severity ="9555fe0f-f111-442a-aa0f-da1344859a96"; 
   			break;
   	}
   	return severity;
}


function convertCategory(code)
{
	switch (code)
    {
   		case "d5dc4095-a183-4d0c-8a5d-e27f5ee9111d":
   		    severity = "Minor";
   		    break;
   		case "8ffa4412-ab8c-4f24-94a1-7f6bd5545910":
   		    severity = "Major";
   		    break;
   		case "9555fe0f-f111-442a-aa0f-da1344859a96":
   			severity = "Critical";
   			break;
   	    default: 
        severity = code;
   	}
   	return severity;
}

