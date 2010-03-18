<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}

class tplParser
{

    private $tpldir;
    private $tpl;
    public $tpltime = 0;
    public $filecount = 0;
    
    function __construct($tpldir, $tpl)
    {
        $this->tpldir=$tpldir;
        $this->tpl=$tpl;
    }
    
    public function parsetemplate ($template, $array, $return = 0) {
        
        $template = $this->gettemplate($template);
        if($template)
        {
            $tplstart = explode(" ", microtime());
            $starttime = $tplstart[1] . substr($tplstart[0], 1);
            $content = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
            $tplend = explode(" ",microtime());
            $endtime = $tplend[1].substr($tplend[0],1);
            $time = bcsub($endtime,$starttime,6);
            $this->tpltime+=$time;
            $this->filecount++;
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