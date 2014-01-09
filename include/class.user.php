<?php
if(!defined('INCONFIG'))
{
	header("Location: ../index.php");
	die();
}

class User
{
	//private $access=array();
	function __construct()
	{
		if(isset($_SESSION['logged']) && $_SESSION['logged'] && isset($_SESSION['account']) && $_SESSION['account'] != '')
		{
			$this->checkSession();
		}
		elseif (isset($_COOKIE['logincookie']))
		{
			$this->checkRemembered($_COOKIE['logincookie']);
		}
	}

	public function checkLogin($username, $password, $remember)
	{
		global $sql;
		$username = $sql->escape($username);
		$password = $this->encryptPass($password);
		$result = $sql->query(42, array('name'=>$username, 'pass'=>$password));

		if($sql->numRows())
		{
			$this->setSession($sql->fetchArray($result), $remember);
			return true;
		}
		else
		{
			return false;
		}
	}

	private function setSession($values, $remember, $init = true)
	{
		global $sql;
		$_SESSION['account'] = strtolower($values['login']);
		$cookie = $this->encryptPass($values['login'] . $values['password']);
		$_SESSION['cookie'] = $cookie;
		$_SESSION['logged'] = true;
		$_SESSION['webpoints'] = $values['webpoints'];
		$_SESSION['vote_time'] = $values['voted'];
		$_SESSION['skin'] = $values['skin'];
		if($remember)
		{
			$this->updateCookie($cookie, true);
		}
		if($values['accessLevel'] == 127)
		{
			$_SESSION['admin'] = true;
		}
		elseif ($values['accessLevel'] < 127 && $values['accessLevel'] > 0)
		{
			$_SESSION['moderator'] = true;
		}
		else
		{
			$_SESSION['admin'] = false;
			$_SESSION['moderator'] = false;
		}
		if($init)
		{
			$session = $sql->escape(session_id());
			$ip = $sql->escape($_SERVER['REMOTE_ADDR']);

			$sql->query(43, array('cookie'=>$cookie, 'session'=>$session, 'ip'=>$ip, 'login'=>$values['login']));
		}
	}

	private function updateCookie($cookie, $save)
	{
		$_SESSION['cookie'] = $cookie;
		if($save)
		{
			$cookie = serialize(array($_SESSION['account'], $cookie));
			setcookie('logincookie', $cookie, time() + 31104000, '', '');
		}
	}

	private function checkRemembered($cookie)
	{
		global $sql;
		list($username, $cookie) = unserialize($cookie);
		if(!$username || !$cookie)
			return;
		$username = val_string($username);
		$cookie = val_string($cookie);

		$result = $sql->query(44, array('login'=>$username, 'cookie'=>$cookie));
		if($sql->numRows())
		{
			$this->setSession($sql->fetchArray($result), true);
		}
	}

	private function checkSession()
	{
		global $sql;
		$username = $_SESSION['account'];
		$cookie = $_SESSION['cookie'];
		$session = session_id();
		$ip = $_SERVER['REMOTE_ADDR'];
		$result = $sql->query(45, array('login'=>$username, 'cookie'=>$cookie, 'session'=>$session, 'ip'=>$ip));
		if($sql->numRows())
		{
			$this->setSession($sql->fetchArray($result), false, false);
		}
		else
		{
			$this->logout();
		}
	}

	public function logged()
	{
		if($_SESSION['logged'] == true && $_SESSION['account'] != '')
		{
			return true;
		}
		return false;
	}
	public function admin()
	{
		if($_SESSION['admin'] == true)
		{
			return true;
		}
		return false;
	}
	public function mod()
	{
		if($_SESSION['moderator'] == true || $_SESSION['admin'] == true)
		{
			return true;
		}
		return false;
	}

	public function logout()
	{
		$_SESSION['account'] = '';
		$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['vote_time'] = 0;
		$_SESSION['webpoints'] = 0;
		$_SESSION['admin'] = false;
		$_SESSION['mod'] = false;
		$_SESSION['logged'] = false;
		unset($_SESSION);
		setcookie('logincookie', '', 0, '', '');
		if(isset($_SESSION['account']))
		{
			return false;
		}
		return true;
	}
	public function debug()
	{
		return print_r($_SESSION, true);
	}
	private function encryptPass($password)
	{
		global $sql;
		return base64_encode(pack('H*', sha1($sql->escape($password))));
	}

	public function regUser($acc, $pass, $ref)
	{
		global $sql;

		$acc = $sql->escape($acc);
		$pass0 = $sql->escape($pass);
		$pass = $this->encpass($pass);
		$ref = $sql->escape($ref);
		$ip = $sql->escape($_SERVER['REMOTE_ADDR']);
		if($ref != '')
		{
			$checkref = $sql->query(46, array('login'=>$ref));
			if($sql->numRows() && $sql->result($checkref, 0, 'lastIP') != $ip)
			{
				$sql->query(47, array('login'=>$ref, 'webpoints'=>getConfig('features', 'reg_reward', '5')));
			}
		}
		$sql->query(48, array('login'=>$acc, 'pass'=>$pass,'ip'=>$ip));
		if($this->checkLogin($acc, $pass0, 0))
			return true;
		else
			return false;
	}

	public function changePass($acc, $old, $pass, $pass2)
	{
		global $sql, $Lang;

		if(ereg("^([a-zA-Z0-9_-])*$", $old) && ereg("^([a-zA-Z0-9_-])*$", $pass) && ereg("^([a-zA-Z0-9_-])*$", $pass2))
		{

			if($pass == $pass2)
			{
				$result = $sql->query(49, array('login'=>$acc, 'pass'=>encodePass($old)));
				if($sql->numRows())
				{
					$sql->query(50, array('login'=>$acc, 'pass'=>encodePass($old)));
					msg(getLang('success'), getLang('password_changed'));
				}
				else
				{
					msg(getLang('error'), getLang('old_password_incorrect'),'error');
				}
			}
			else
			{
				msg(getLang('error'), getLang('passwords_no_match'),'error');
			}
		}
		else
		{
			msg(getLang('error'), getLang('incorrect_chars'), 'error');
		}
	}
	
	/*
 	public function hasAccess($s)
    {
        if($s==null || $s=='') return 1;
        else if(isset($this->access[$s]))
            return $this->access[$s];
        else
            return $this->createAccess($s);
    }
    public function getGroupName()
    {
        return $$this->array['name'];
    }
    public function getGroupId()
    {
        return $$this->array['id'];
    }
    public function createAccess($s)
    {
        global $sql;
        $s=$sql->escape($s);
        $this->access[$s]=0;
        
        $sql->query("ALTER TABLE `groups` ADD COLUMN `$s`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0;");
        msg('Warning', 'Access '.$s.' not defined. Creating now with default 0 value for all groups!', 'warning');
        return 0;
    }
    public function getUser()
    {
        return isset($_SESSION['user'])?$_SESSION['user']:null;
    }
    public function getColor()
    {
        return "#000000";
    }
    public function setVar($var,$val)
    {
        global $sql;
        switch($var)
        {
            case 'lang':
            case 'skin':
            case 'lastAccess':
                $_SESSION[$var]=$val;
                $sql->query("UPDATE employees SET `$var`='$val' WHERE user='".$this->getUser()."';");
            break;
            default:
                ($val=='no' || $val=='false'||$val=='n'||$val=='f'||$val=='0')?$val=0:$val=1;
                if(isset($_SESSION[$var]))
                {
                    $_SESSION[$var]=$val;
                    $sql->query("UPDATE employees SET `$var`='$val' WHERE user='".$this->getUser()."';");
                }
                else
                {
                    $this->createVar($var);
                    $this->setVar($var,$val);
                }
            break;
            
        }
    }
    public function getVar($var)
    {
        if(isset($_SESSION[$var]))
        {
            return $_SESSION[$var];
        }
        else
        {
            $this->createVar($var);
            return $this->getVar($var);
        }
    }
    private function createVar($var)
    {
        global $sql;
        $sql->query("ALTER TABLE employees ADD COLUMN `$var` tinyint(1) NOT NULL DEFAULT 0;");
        $_SESSION[$var]=0;
    }*/
}
?>