var inputFile;
var addWord;
function report(file)
{
	window.open("report.php?&inputFile=" + file,"title",'scrollbars=no,resizable=yes, width=300,height=100,status=no,location=center, toolbar=no');
		
}
function upDateSpecificComment()
	{
		if( document.getElementById("Comment").value == comment)
		{
			alert("Comment unmodified");
		}
		else
		{
		 	window.open("addComment.php?comment=" + document.getElementById("Comment").value + "&commentID=" + generalCommentID + "&user=Gabry&sourceID=" + sourceID + "&inputFile="+inputFile+"&severity=" + document.getElementById("severity").value + "&typeComment=Delete","title",'scrollbars=no,resizable=yes, width=300,height=100,status=no,location=center, toolbar=no');
		}
	}

function openFile()
{
	window.open("FileList.php");
}

function getTarget()
{
	alert($(this).attr("data-sourceID"));
}

function replaceAll(str, find, replace)
{
	return str.replace(new RegExp(find, 'g'), replace);
}

$(".targetSegment").keyup(function(e){

	target = $(this).parent().children(".targetText").val();	
	target= target.trim();
	if (e.which == 8 || e.which == 46)
	{
		var textUnmodified = $(this).html();
		textUnmodified	   = textUnmodified.trim();
		textUnmodified	   = replaceAll(textUnmodified,"\"","'");
		var start  		   = -1;
		var finish         = -1;
		var diference      =  0;
		var count          =  0;
		var slice          = "";
		var tagCount       =  0;
		var modalOpen      = true;
	
		for (var i = 0; i <= target.length; i++)
		{
			if(target.charAt(i)=="<")
			{
				tagCount ++;
			}

			if(target.charAt(i) == textUnmodified.charAt(count))
			{
				count++;
				if(((textUnmodified.length + diference) == target.length))
				{
					finish = i;
					break;
				}
			}
			else
			{
				if((tagCount % 4 !=0) && (tagCount!=0))
				{
					
					$.notify("You can't modified a comment!", "error");
					modalOpen = false;
				}
				diference++;
				if(start == -1)
				{
					start = i;
				}
			}
		}
      	error   = "";
      	add     = false;
      	closetag= true;
		for (var i = 0; i <= target.length; i++)
		{
			if(i == start)
			{
				slice += "<s><u><font color='red'>";
				add=true;
				closetag=false;
			}
			
			if(i == finish && i != target.length)
			{
				slice += "</font></u></s>";
				add=false;
				closetag=true;
			}
			if(add) error+= target.charAt(i);
			slice  += target.charAt(i);
		}
		if(closetag==false)
		{
			slice += "</font></u></s>";
		}
		output = slice;
		$(this).html(output);
		$(this).attr("output", output);
		$(this).attr("error", error);
		if(modalOpen)
		{
			initializeModalAddQuality(this);
		}
		else
		{
			location.reload();
		}
		
	} 
	else if(e.which == 13)
	{
		
		$("#addComment").attr("data-sourceID",  $(this).attr("data-sourceID"));
		$("#addComment").attr("data-inputFile", $(this).attr("data-inputFile"));
		$("#addComment").attr("data-target",    $(this).html());
		addWord = $(this).html();
		target    = addWord.split("<div>");
		target[1] = target[1].split("</div>").join("");
		document.getElementById("preAdded").innerHTML = target[0];
		document.getElementById("postAdded").innerHTML= target[1];
		$('#insertWord').modal('show');
	}
}


);