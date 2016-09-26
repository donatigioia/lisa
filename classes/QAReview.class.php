
<?php
class QAReview
{
    var $sentence = array("source" => "", "sourceId" => "", "target" => "", "comment" => "", "GeneralCommentID" => "");
  
    public function OpenDocument()
    {
        $this->stringXML   = file_get_contents($this->file);
        $this->translation = $this->fixDocument();           
        return $this->buildTable();
    }

    public function buildTable()
    {   
        $returnString      = "";
        $sourceID          = "";
        foreach ($this->translation->file->body->group as $translationGroup)
        {
            $this->GeneralCommentID = array();
            $this->sourceID         = $translationGroup->{"trans-unit"}[0]['id'];
            $this->sourceText       = $translationGroup->{"trans-unit"}->source;
            $path  = $translationGroup->{"trans-unit"}->target->mrk->mrk;  
            $this->correctionComment = array();               
            
            foreach ($path as $value)                                          
            {   
                if($value["mtype"] =="x-sdl-feedback-deleted" or $value["mtype"] == "x-sdl-feedback-added")
                {
                     // correctionComment(IDsentence,slice of modified text,IDcomment,"comment",IDsource,user,severityCode)
                    $this->correctionComment[] = array($value['sdl_revid']."",$value."","","","",""); 
                }
            }

            foreach ($translationGroup->{"trans-unit"}->target->mrk->mrk as $key => $value)
            {
                if ($value['sdl_cid'] != null) 
                {
                    $this->GeneralCommentID[] = $value['sdl_cid'];
                }
            }
            $returnString .= $this->buildTableRows();
        }
        return $returnString;
    }

    protected function buildTableRows()
    {
        $sourceID = $this->sourceID;
        $source   = $this->sourceText;
        $target   = $this->getTarget();
                    $this->getDeleteComment();
        $comment  = $this->getComment();
        $general  = "";
        $general  = $comment[0][0];
        $generalCommentJson     = addslashes(json_encode($comment[0]));
        $correctionCommentJson  = addslashes(json_encode($this->correctionComment));
        if($this->correctionComment[0][1]=="")
        {   
            $disabled="disabled=\"true\"";
            $allowed ="<span style=\"cursor:not-allowed\">";
       }
        $html=" <tr role=\"row\" class=\"odd\">
                <td class=\"v-align-middle semi-bold sorting_1 sorting_2\">
                  <p>$source</p>
                </td>
                <td class=\"v-align-middle semi-bold\">
                  <input class=\"targetText\" id=\"target\" type=\"hidden\" value=\"$target\"/> <div contenteditable=\"true\" class=\"targetSegment\" id=\"openModal\" data-target=\"$target\"data-sourceID=\"$sourceID\" data-source=\"$source\"data-inputFile=\"$this->file\" data-deleteComment=''> $target
                </td>
                <td class=\"v-align-middle\" align=\"center\">
                  <p>".count($comment[0])."</p>
                </td>
                <td class=\"controller\">
                <button type=\"button\" $disabled onclick='initializeModalAddQuality(this,\"$correctionCommentJson\");'  id=\"openModal\"  data-target=\"$target\" data-sourceID=\"$sourceID\" data-source=\"$source\"data-inputFile=\"$this->file\"$disabled>
                      $allowed
                      <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i>
                </button>
                <button type=\"button\" onclick='initializeModalAddGeneralComment(this,\"$generalCommentJson\");' id=\"openModal2\" data-target=\"$target\" data-comment=\"$general \"data-sourceID=\"$sourceID\"data-inputFile=\"$this->file\">
                     <i class=\"fa fa-comment\" aria-hidden=\"true\"></i>
                </button>
                <button><i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>
                 ";
        return $html;
    }

   protected function takeCorrectCorrectionComment()
   {
   

   }
    
    protected function getTargetTag()
    {
        $startTag        = strpos($this->stringXML, "<target>");
        $finalTag        = strpos($this->stringXML, "</target>");
        $length          = $finalTag - ($startTag);
        $string          = substr($this->stringXML, $startTag, $length + 9);
        $this->stringXML = str_replace($string, "", $this->stringXML);
        $string          = substr($string, 8, strlen($string) - 17);
        return $string;
    }
    
    protected function getTarget()
    {
        $targetTag = $this->getTargetTag();
        $arrayTags = explode("<", $targetTag);
        
        foreach ($arrayTags as $tag)
        {
            if (strpos($tag, "mtype=\"x-sdl-feedback-deleted\""))
            {
                $startString   = strpos($tag, ">");
                $text          = substr($tag, $startString + 1);
                $returnString .= "<s><font color='red'>$text</font></s>";
            }
            elseif(strpos($tag, "mtype=\"x-sdl-feedback-added\""))
            {
                $startString   = strpos($tag, ">");
                $text          = substr($tag, $startString + 1);
                $returnString .= "<i><font color='green'>$text</font></i>";
            }
            elseif (strpos($tag, ">") == (strlen($tag) - 1)) 
            {
                $returnString .= "";
            }
            elseif (strpos($tag, "mtype=\"seg\""))
            {
                $startString   = strpos($tag, ">");
                $returnString .= substr($tag, $startString + 1);
            }
            else
            {
                $startString   = strpos($tag, ">");
                $returnString .= substr($tag, $startString + 1);   
            }
        }
        return $returnString;
    }
    
    public function getComment()
    {
        $comments[]        = array();
        $this->translation = $this->fixDocument(); 
        foreach ($this->translation->{"doc-info"}->{"cmt-defs"}->{"cmt-def"} as $item)
        {
            foreach ($item->Comments->Comment as $value) 
            {
                $comments[] = array($item[0]['id'],$value);
            }
        }
        foreach ($comments as $value)
        {           
            foreach ($this->GeneralCommentID as $com)
            {
                if (trim($value[0]) == trim($com))
                {
                    $comment[] =array(trim($value[0]), $value[1] . "\n");
                }
            }  
            for($i=0;$i<count($this->correctionComment);$i++)
            {

                if (trim($value[0]) == trim($this->correctionComment[$i][2]) )
                {
                    $this->correctionComment[$i][3] = $value[1]; 
                }
            }                                                              
        }                         
        $generalSpecificCOmment = array($comment,$delComment);
        return $generalSpecificCOmment;
    }
    
    public function getDeleteComment()
    {
        $comments[]        = array();
        $this->translation = $this->fixDocument();
        foreach ($this->translation->{"doc-info"}->{"rev-defs"}->{"rev-def"} as $item)
        {
            for ($i=0;$i<count($this->correctionComment); $i++)
            {   
                if ($item["id"] == trim($this->correctionComment[$i][0]))
                {   
                    $this->correctionComment[$i][2] = $item->{"sdl_cmt"}["id"]."";
                    $this->correctionComment[$i][5] = $item["fbSeverity"]."";
                    $this->correctionComment[$i][6] = $item["fbCategory"]."";
                }
            }
        } 
    }


    public function getLanguage()
    {
        $this->translation = $this->fixDocument();
        $xml=$this->translation->{"file"};
        return $xml["source-language"]." > ".$xml["target-language"];
    }
    
    public function fixDocument()
    {
        $file = (file_get_contents($this->file));
        $file = str_replace("sdl:cid", "sdl_cid", $file);
        $file = str_replace('sdl:revid', 'sdl_revid', $file);
        $file = str_replace('sdl:cmt', 'sdl_cmt', $file);
        return simplexml_load_string($file);
    }
}


