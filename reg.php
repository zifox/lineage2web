<?php 
//пароль
define('INWEB', True);
require_once("include/config.php");
//head('Registration');
includeLang('reg');
if($user->logged())
{
    head($Lang['registration'], 1, 'index.php', 5);
    msg($Lang['error'], $Lang['already_reg'], 'error');
    foot();
    exit();
}
$ref=getVar('ref');
if(isset($_POST['account']) && isset($_POST['password']))
{
    if(strtolower($_SESSION['captcha'])!=strtolower(getVar('captcha'))){
        head($Lang['registration'], 1, 'index.php', 5);
        msg($Lang['error'], $Lang['code_incorrect'], 'error');
        foot();
        exit();
    }

    $account = getVar('account');
    $password = getVar('password');
    $password2 = getVar('password2');
    $ip = getVar('REMOTE_ADDR');

    if(ereg("^([a-zA-Z0-9_-])*$", $account) && ereg("^([a-zA-Z0-9_-])*$", $password) && ereg("^([a-zA-Z0-9_-])*$", $password2))
    {
	   if (strlen($account)<16 && strlen($account)>4 && strlen($password)<16 && strlen($password)>4 && $password==$password2)
	   {
		  $check=$sql->query($q[101], array('login'=>$account));
		  if($sql->num_rows())
		  {
                head($Lang['registration'], 1, 'index.php', 5);
                msg($Lang['error'], $Lang['already_exists'], 'error');
                foot();
                exit();
		  }
		  else
		  {
                head($Lang['registration'],1, 'index.php',5);
                if($user->reguser($account, $password, $ref))
                {
                    msg($Lang['success'], $Lang['success_logged']);
                }
                else
                {
                    msg($Lang['success'], $Lang['success_failed']);
                }
                foot();
                exit();
		  }
	   }
	   else
	   {
            head($Lang['registration'], 1, 'index.php', 5);
            msg($Lang['error'], $Lang['too_short'], 'error');
            foot();
            exit();
	   }
    }
    else
    {
            head($Lang['registration'], 1, 'index.php', 5);
            msg($Lang['error'], $Lang['invalid_chars'], 'error');
            foot();
            exit();
    }
}
head($Lang['registration']);
$par['lang']=getLang();

$params = implode(';', $par);
if($cache->needUpdate('reg', $params))
{
    
    $parse = $Lang;
    $parse['ref'] = $ref;
    $parse['button'] = button($Lang['reg_me'], 'Submit', 1);
    $content=$tpl->parsetemplate('reg', $parse,1);
    $cache->updateCache('reg', $content, $params);
    
    echo $content;
}
else
{
    echo $cache->getCache('reg', $params);
}
foot();
?>         