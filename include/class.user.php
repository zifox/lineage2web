<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}
class user {
   
	function __construct()
	{
		if (isset($_SESSION['logged'])&& $_SESSION['logged'] && isset($_SESSION['account'])&& $_SESSION['account']!='')
		{
			$this->checkSession();
		} elseif (isset($_COOKIE['logincookie']))
		{
            $this->checkRemembered($_COOKIE['logincookie']);
		}
	}
    


	public function checkLogin( $username, $password, $remember )
	{
        global $sql;
		$username = $sql->escape($username);
		$password = $this->encpass($password);
		$sqlq = "SELECT * FROM `accounts` WHERE `login` = '$username' AND `password` = '$password'";
		$result = $sql->query($sqlq);

		if ($sql->num_rows())
		{
			$this->setSession($sql->fetch_array($result), $remember);
			return true;
		}
		else
		{
			//$this->logout();
			return false;
		}
	}

	private function setSession($values, $remember, $init = true)
	{
        global $sql;
		$_SESSION['account'] = $values['login'];
        $cookie = $this->encpass($values['login'].$values['password']);
        $_SESSION['cookie'] = $cookie;
		$_SESSION['logged'] = true;
        $_SESSION['webpoints'] = $values['webpoints'];
        $_SESSION['vote_time'] = $values['voted'];
		if ($remember){
			$this->updateCookie($cookie, true);
		}
        if($values['accessLevel'] == 127){
            $_SESSION['admin'] = true;
        }elseif($values['accessLevel'] < 127 && $values['accessLevel'] > 0)
        {
            $_SESSION['moderator'] = true;
        }
        else{
            $_SESSION['admin'] = false;
            $_SESSION['moderator'] = false;
        }
		if ($init){
			$session = $sql->escape(session_id());
			$ip = $sql->escape($_SERVER['REMOTE_ADDR']);

			$sqlq = "UPDATE `accounts` SET `cookie` = '$cookie', `session` = '$session', `ip` = '$ip' WHERE `login` = '{$values[login]}'";
			$sql->query($sqlq);
		}
	}

	private function updateCookie($cookie, $save)
	{
		$_SESSION['cookie'] = $cookie;
		if ($save)
		{
			$cookie = serialize(array($_SESSION['account'], $cookie));
			setcookie('logincookie', $cookie, time() + 31104000, '', '');
		}
	}

	private function checkRemembered($cookie)
	{
        global $sql;
		list($username, $cookie) = @unserialize($cookie);
		if (!$username || !$cookie) return;
		$username = $sql->escape($username);
		$cookie = $sql->escape($cookie);

		$sqlq = "SELECT * FROM `accounts` WHERE `login` = '$username' AND `cookie` = '$cookie'";
		$result = $sql->query( $sqlq );
		if ( $sql->num_rows() )
		{
			$this->setSession($sql->fetch_array($result), true );
		}
	}

	private function checkSession()
	{
        global $sql;
		$username = $_SESSION['account'];
		$cookie = $_SESSION['cookie'];
		$session = session_id();
		$ip = $_SERVER['REMOTE_ADDR'];
		$sqlq = "SELECT * FROM `accounts` WHERE `login` = '$username' AND `cookie` = '$cookie' AND `session` = '$session' AND `ip` = '$ip'";
        $result = $sql->query($sqlq);
		if ($sql->num_rows())
		{
			$this->setSession($sql->fetch_array($result), false, false);
		}
		else
		{
			$this->logout();
		}
	}
    
    public function logged(){
		if ($_SESSION['logged'] == true && $_SESSION['account']!='')
		{
			return true;
		}
		return false;
    }
	public function admin()
	{
		if ($_SESSION['admin'] == true)
		{
			return true;
		}
		return false;
	}
	public function mod()
	{
		if ($_SESSION['moderator'] == true || $_SESSION['admin'] == true)
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
        print_r($_SESSION);
    }
    private function encpass($password)
    {
        global $sql;
        return base64_encode(pack('H*', sha1($sql->escape($password))));
    }
    
    public function reguser($acc, $pass, $ref){
        global $sql;
        
        $acc = $sql->escape($acc);
        $pass0=$sql->escape($pass);
        $pass = $this->encpass($pass);
        $ref = $sql->escape($ref);
        $ip = $sql->escape($_SERVER['REMOTE_ADDR']);
        if($ref != '')
        {
            $checkref=$sql->query("SELECT `login`, `lastIP` FROM `accounts` WHERE `login` = '".$ref."'");
            if($sql->num_rows() && $sql->result($checkref, 0, 'lastIP') != $ip)
            {
                $sql->query("UPDATE `accounts` SET `webpoints`=`webpoints`+'".getConfig('features', 'reg_reward', '5')."' WHERE `login`='".$ref."'");
            }
        }
   	    $sql->query("INSERT INTO `accounts` (`login`, `password`, `accessLevel`, `lastIP`) VALUES ('".$acc."', '".$pass."', '0', '$ip')");
        if($this->checkLogin($acc,$pass0, 0))
            return true;
        else
            return false;
    }
    
    public function changepass()
    {
        
    }
}

?>