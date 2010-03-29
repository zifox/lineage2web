<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}

class tplParser
{

    private $tpldir ='template';
    private $tpl;
    public $tpltime = 0;
    public $filecount = 0;
    
    function __construct($tpl)
    {
        $this->tpl=$tpl;
    }
    
    public function parsetemplate ($template, $array, $return = 0) {
        $tplstart = explode(" ", microtime());
        $starttime = $tplstart[1] . substr($tplstart[0], 1);
        $template = $this->gettemplate($template);
        if($template)
        {
            $content = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
            $this->filecount++;
            $tplend = explode(" ",microtime());
            $endtime = $tplend[1].substr($tplend[0],1);
            $this->tpltime+=bcsub($endtime,$starttime,6);
            if($return)
                return $content;
            echo $content;
        }
        return;
    }

    private function gettemplate ($templatename) {
	   $filename = $this->tpldir . '/' . $this->tpl . '/' . $templatename . ".tpl";
        if(file_exists($filename))
	       return @file_get_contents($filename);
        msg('Failed', 'Failed to get file '.$templatename. ' contents', 'error');
         return 0;
    }
    public function debug()
    {
        echo 'File Count: '.$this->filecount.' Template Load Time: '.$this->tpltime;
    }
}
?>