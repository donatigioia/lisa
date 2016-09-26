<?php
include $_SERVER['DOCUMENT_ROOT'].'/../GVPortal/functions.php';
include 'takeidCategory.php';

$translation = new ModifyCommentXMLFile();
$translation->updateComment();

class ModifyCommentXMLFile
{
	public function updateComment()
	{
		echo $_GET["category"];
		$newXmlString = $this->createNewXmlString();
		$this->overrideXml($newXmlString);
		$this->addSecondPartOfXml();	
	}

	private function createNewXmlString()
	{
		$OriginalXmlPart = $this->extractCorrectFilePart();
		$newString   	 = $this->mergeString($OriginalXmlPart);
		$newString   	 = $this->fixStringXml($newString);
		return $newString;
	}

	private function extractCorrectFilePart()
	{
		$sourceID  				   = $_GET["sourceID"];
		$this->fileName  		   = "../".$_GET["inputFile"];
		$file 	   				   = (file_get_contents($this->fileName));
		$this->OriginalCompleteXml = $file;
		$file 	   				   = strchr($file,$sourceID);
		$file 	   				   = strchr($file,"<target>");
		$file 	   				   = strchr($file,"\">");
		$file 	   				   = substr($file,2);
		if (strrpos($file,"mrk mtype=\"x-sdl-comment\"")>-1)
		{
			$file  = strchr($file,"mrk mtype=\"x-sdl-comment\"",true);
		}
		else
		{
			$file  = strchr($file,"</target>",true);
		}
		
		$this->Original  = substr($file,0,strripos( $file,"</mrk>"));
		$file      	     = str_replace(">","<",$file);
		$file      	     = explode("<",$file);
		return $file;
	}

	private function mergeString($OriginalXmlPart)
	{	
		$xmlTarget   = $_GET["xmlTarget"];
		$target      = str_replace(">","<",$xmlTarget);
		$target      = explode("<", $target);
		$countTarget = 0;
		$countFile   = 0;

		while($countFile<count($OriginalXmlPart) and $countTarget<count($target))
		{
			if(trim($OriginalXmlPart[$countFile])=="")
			{
				$countFile++;
			}
			if(trim($target[$countTarget])=="")
			{
				$countTarget++;
			}
			//var_dump($OriginalXmlPart[$countFile]."== ".$target[$countTarget]);

			if(trim($OriginalXmlPart[$countFile])==trim($target[$countTarget]))
			{
				$newString  .= $OriginalXmlPart[$countFile]."<br>";
				$countFile   = $countFile +1;
			}
			elseif((substr($OriginalXmlPart[$countFile],0,3)=="mrk" and trim($target[$countTarget])=="tag")or(substr($OriginalXmlPart[$countFile],0,4)=="/mrk" and $target[$countTarget]=="/tag" ) )
			{
				$newString  .= $OriginalXmlPart[$countFile]."<br>";
				$countFile   = $countFile +1;
			}
			else
			{
				$newString  .= $target[$countTarget]."<br>";
				$countFile   = $countFile +1;
				$countTarget ++;
				$newString  .= $target[$countTarget]."<br>";
				$countTarget ++;
				$newString  .= $target[$countTarget]."<br>";
				$countTarget ++;
				$newString  .= $target[$countTarget]."<br>";
			}

			if((substr($OriginalXmlPart[$countFile],0,3) == "mrk") and (substr($target[$countTarget+1],0,3)!="tag"))
			{
				$countTarget++;
				$newString  .= $target[$countTarget]."<br>";
			}
			$countTarget = $countTarget+1;	
		}
		//var_dump($newString);
		return $newString;
	}

	private function fixStringXml($newString)
	{
		$this->commentID   = \GVPortal\Base\UniqueID::code15(); 
		$newString   	   = str_replace("<br>mrk","<mrk",$newString);
		$newString   	   = str_replace("\"<br>","\">",$newString);
		$newString   	   = str_replace("<br>/mrk","</mrk>",$newString);
		$newString   	   = str_replace("<br>","",$newString);
		$newString   	   = str_replace("N3w1D15",$this->commentID,$newString);
		
		if(substr($newString,0,3) =="mrk")
		{
			$newString ="<".$newString;
		}
		//var_dump($newString);
		return $newString;
	}

	private function addSecondPartOfXml()
	{	
		$this->user = $_GET["user"];
		$severity   = $_GET["severity"];
		$category   = new takeIdCategory();
		$id 		= $category->getId();
		$id 		= $id[0]["code"];
	
		$this->translation = simplexml_load_file($this->fileName);
	    $tag   = $this->translation->{"doc-info"}->{"rev-defs"}->addChild('rev-def');
		$tag->addAttribute('id',$this->commentID);
		$tag->addAttribute('type',$_GET["type"]);
		$tag->addAttribute('author',$_GET["user"]);
		$tag->addAttribute('date',date(DATE_ATOM, mktime(0, 0, 0, 7, 1, 2000)));
		$tag->addAttribute('fbCategory',$id);
		$tag->addAttribute('fbSeverity',$severity);
		$tag2 =$tag->addChild('sdl_cmt');
		$commentID2= \GVPortal\Base\UniqueID::code15(); 
		$tag2->addAttribute('id',$commentID2);

		$tag3 = $this->translation->{'doc-info'}->{'cmt-defs'}->addChild('cmt-def'); 
		$tag3->addAttribute('id',$commentID2);
		$tag4 = $tag3->addChild('Comments'); 
		$tag5 = $tag4->addChild('Comment',$_GET["comment"]); 
		$tag5->addAttribute('severity',"Low");
		$tag5->addAttribute('user', $_GET["user"]);
		$tag5->addAttribute('date',date(DATE_ATOM, mktime(0, 0, 0, 7, 1, 2000)));
		$tag5->addAttribute('version','1.0');
		
		$this->saveFile();
		
	}	

	private function saveFile()
	{
		$f    = fopen($this->fileName, "w");
		fwrite($f, $this->translation->asXML());
		$file = (file_get_contents($this->fileName));
		$file = str_replace("sdl_cmt","sdl:cmt",$file);
		$f    = fopen($this->fileName, "w");
		fwrite($f, $file);
		fclose($f);
	}

	private function overrideXml($newXmlString)
	{
		$newXmlComplete  = str_replace($this->Original,$newXmlString,$this->OriginalCompleteXml);
		$f               = fopen($this->fileName, "w");
		fwrite($f, $newXmlComplete);
		fclose($f);
		echo "<script type=\"text/javascript\">	window.close();	window.open(\"../review.php?document=$this->fileName&user=$this->user&msg=Comment Updated!&type=success\"); </script>";
	}
}
?> 
