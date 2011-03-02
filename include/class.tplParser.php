<?php
//пароль
if (!defined('INCONFIG')) {
    header("Location: ../index.php");
    exit();
}

class tplParser
{

    private $tpldir ='template';
    private $tpl;

    function __construct($tpl)
    {
        $this->tpl=$tpl;
    }
    
    public function parsetemplate ($template, $array, $return = 0) {
        $template = $this->gettemplate($template);
        if($template)
        {
            $content = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
            if($return)
                return $content;
            echo $content;
        }
        return;
    }

    private function gettemplate ($templatename) {
	   $filename = $this->tpldir . '/' . $this->tpl . '/' . $templatename . ".tpl";
        if(file_exists($filename))
	       return file_get_contents($filename);
        msg('Failed', 'Failed to get file '.$templatename. ' contents', 'error');
         return;
    }
}
?>