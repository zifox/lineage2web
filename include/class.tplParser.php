<?php
if(!defined('INCONFIG'))
{
	header("Location: ../index.php");
	exit();
}

class TplParser
{
	private $tpldir = 'template';
	private $defaultTpl = 'default';
	private $tpl;

	function __construct($tpl)
	{
		$this->tpl = $tpl;
	}

	public function parseTemplate($template, $array, $return = false)
	{
		$template = $this->getTemplate($template);
		if($template)
		{
			$content = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
			if($return)
				return $content;
			echo $content;
		}
		return;
	}

	private function getTemplate($templatename)
	{
		if(file_exists($this->tpldir . '/' . $this->tpl . '/' . $templatename . '.tpl'))
		{
			return file_get_contents($this->tpldir . '/' . $this->tpl . '/' . $templatename . '.tpl');
		}
		elseif(file_exists($this->tpldir . '/' . $this->defaultTpl . '/' . $templatename . '.tpl'))
		{
			return file_get_contents($this->tpldir . '/' . $this->defaultTpl . '/' . $templatename . '.tpl');
		}
		else
		{
			return msg('Failed', 'Failed to get file ' . $templatename . ' contents', 'error',true);
		}
	}
}
?>