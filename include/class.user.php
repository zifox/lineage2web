<?php
//пароль
if (!defined('INCONFIG')) {
    Header("Location: ../index.php");
    die();
}
class user {
//	var $failed = false;
    
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
        global $mysql;
		$username = $mysql->escape($username);
		$password = $this->encpass($password);
		$sql = "SELECT * FROM `accounts` WHERE `login` = '$username' AND `password` = '$password'";
		$result = $mysql->query($sql);

		if ($mysql->num_rows($result))
		{
			$this->setSession($mysql->fetch_array($result), $remember);
			return true;
		}
		else
		{
//			$this->failed = true;
			$this->logout();
			return false;
		}
	}

	private function setSession($values, $remember, $init = true)
	{
        global $mysql;
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
        }else{
            $_SESSION['admin'] = false;
        }
		if ($init){
			$session = $mysql->escape(session_id());
			$ip = $mysql->escape($_SERVER['REMOTE_ADDR']);

			$sql = "UPDATE `accounts` SET `cookie` = '$cookie', `session` = '$session', `ip` = '$ip' WHERE `login` = '{$values[login]}'";
			$mysql->query($sql);
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
        global $mysql;
		list($username, $cookie) = @unserialize($cookie);
		if (!$username || !$cookie) return;
		$username = $mysql->escape($username);
		$cookie = $mysql->escape($cookie);

		$sql = "SELECT * FROM `accounts` WHERE `login` = '$username' AND `cookie` = '$cookie'";
		$result = $mysql->query( $sql );
		if ( $mysql->num_rows2( $result ) )
		{
			$this->setSession($mysql->fetch_array($result), true );
		}
	}

	private function checkSession()
	{
        global $mysql;
		$username = $_SESSION['account'];
		$cookie = $_SESSION['cookie'];
		$session = session_id();
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "SELECT * FROM `accounts` WHERE `login` = '$username' AND `cookie` = '$cookie' AND `session` = '$session' AND `ip` = '$ip'";
        $result = $mysql->query($sql);
		if ($mysql->num_rows2($result))
		{
			$this->setSession($mysql->fetch_array($result), false, false);
		}
		else
		{
			$this->logout();
		}
	}
    
    public function logged(){
		if ($_SESSION['logged'] == true)
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

	public function logout()
	{
		$_SESSION['account'] = '';
		$_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
		//$_SESSION['last_act'] = time();
		$_SESSION['vote_time'] = 0;
		$_SESSION['webpoints'] = 0;
        $_SESSION['admin'] = false;
        $_SESSION['logged'] = false;
        unset($_SESSION);
        setcookie('logincookie', '', 0, '', '');
	}
    public function debug()
    {
        print_r($_SESSION);
    }
    private function encpass($password)
    {
        global $mysql;
        return base64_encode(pack('H*', sha1($mysql->escape($password))));
    }
    
    public function reguser($acc, $pass, $ref){
        global $mysql, $Config;
        
        $acc = $mysql->escape($acc);
        $pass = $this->encpass($pass);
        $ref = $mysql->escape($ref);
        $ip = $mysql->escape($_SERVER['REMOTE_ADDR']);
        if($ref != '')
        {
            $checkref=$mysql->query("SELECT `login`, `lastIP` FROM `accounts` WHERE `login` = '".$ref."'");
            if($mysql->num_rows2($checkref) && $mysql->result($checkref, 0, 'lastIP') != $ip)
            {
                $mysql->query("UPDATE `accounts` SET `webpoints`=`webpoints`+'{$Config['reg_reward']}' WHERE `login`='".$ref."'");
            }
        }
   	    $mysql->query("INSERT INTO `accounts` (`login`, `password`, `accessLevel`, `lastIP`) VALUES ('".$acc."', '".$pass."', '0', '$ip')");
        $this->checkLogin($acc,$pass, 0);
    }
    
    public function changepass()
    {
        
    }
}

?>