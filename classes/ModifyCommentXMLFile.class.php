<?php

include $_SERVER['DOCUMENT_ROOT'].'/../GVPortal/functions.php';

class ModifyCommentXMLFile
{
	public function __construct()
	{
		
	}

	public function removeComment($typeComment)
	{
		echo "Comment Deleted";
		$this->translation = $this->getTranslation();
		$f         = "";
		$sourceID  = $_GET["sourceID"];
		$commentID = $_GET["commentID"];
		
		foreach ($this->translation->{"doc-info"}->{"cmt-defs"}->{"cmt-def"} as $item)  //If there is a old comment, delete
		{	
			if($item["id"] == $commentID)
			{ 
				$dom = dom_import_simplexml($item);
			    $dom->parentNode->removeChild($dom);
    		}
		}

		foreach ($this->translation->file->body->group as $translationGroup)            // Connect new comment at the correct source
		{
			if($translationGroup->{"trans-unit"}["id"] == $sourceID)
			{
				$target = $translationGroup->{"trans-unit"}->target->mrk->mrk[0];	
				$mrk    = $translationGroup->{"trans-unit"}->target->mrk->mrk;
				 if($mrk['mtype'] == 'x-sdl-comment') 
				 {
			        $dom = dom_import_simplexml($mrk);
			        $dom->parentNode->removeChild($dom);
    			}
    		}
    	}
		$this->saveFile();
	}

	public function addComment($typeComment)
	{

		$this->translation = $this->getTranslation();
		$f          = "";
		$severity   = "Low";
		$comment    = $_GET["comment"];
		$sourceID   = $_GET["sourceID"];
		$commentID  = $_GET["commentID"];
		$user       = $_GET["user"];
		$this->user = $user;

		foreach ($this->translation->{"doc-info"}->{"cmt-defs"}->{"cmt-def"} as $item)  //If there is a old comment, delete
		{	
			if($item["id"] == $commentID)
			{
				$dom = dom_import_simplexml($item);
			    $dom->parentNode->removeChild($dom);
    		}
		}

		$commentID   = \GVPortal\Base\UniqueID::code15();                                   //Add new comment
		
		$tagDef      = $this->translation->{'doc-info'}->{'cmt-defs'}->addChild('cmt-def'); 
	
		$tagDef->addAttribute('id',$commentID);

		$tagComments = $tagDef->addChild('Comments'); 
		$tagComment  = $tagComments->addChild('Comment',$comment); 

		$tagComment->addAttribute('severity',$severity);
		$tagComment->addAttribute('user',$user);
		$tagComment->addAttribute('date',date(DATE_ATOM, mktime(0, 0, 0, 7, 1, 2000)));
		$tagComment->addAttribute('version','1.0');
		
		foreach ($this->translation->file->body->group as $translationGroup)            // Connect new comment at the correct source
		{
			if($translationGroup->{"trans-unit"}["id"] == $sourceID)
			{
				$target = $translationGroup->{"trans-unit"}->target->mrk->mrk[0];	
				$mrk    = $translationGroup->{"trans-unit"}->target->mrk->mrk;
				 if($mrk['mtype'] == 'x-sdl-comment') 
				 {
			        $dom = dom_import_simplexml($mrk);
			        $dom->parentNode->removeChild($dom);
    			}
				$tagmrk2 = $translationGroup->{"trans-unit"}->target->mrk->addChild('mrk');
				$translationGroup->{"trans-unit"}->target->mrk->mrk = $target;
				if ($typeComment == "General")
				{	
					$tagmrk2->addAttribute("mtype","x-sdl-comment");
					$tagmrk2->addAttribute("sdl_cid",$commentID);	
				}
				else if($typeComment == "Delete")
				{
					$tagmrk2->addAttribute("mtype","x-sdl-feedback-deleted");
					$tagmrk2->addAttribute("sdl_revid",$commentID);
					
				}				
			}
		}

		$this->saveFile();
	}

	protected function saveFile()
	{ 
		$f    = fopen($this->file, "w");
		fwrite($f, $this->translation->asXML());
		$file = (file_get_contents($this->file));
		$file = str_replace("sdl_cid","sdl:cid",$file);
		$file = str_replace('sdl_revid','sdl:revid', $file);
		$f    = fopen($this->file, "w");
		echo $f;
		fwrite($f, $file);
		fclose($f);
		echo "<script type=\"text/javascript\">	window.close();	window.open(\"../review.php?document=$this->file&user=$this->user&msg=Comment Updated!&type=success\"); </script>";
	}

	protected function getTranslation()
	{
		
		return simplexml_load_file($this->file);
	}
	
}
?>
