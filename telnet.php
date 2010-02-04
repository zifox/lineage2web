<?php
define('INWEB', True);
require_once("include/config.php");


if (logedin() && is_admin()){
head('Telnet');
$execs = $_GET['execs'];
$mycommand = $_GET['mycommand'];


		
		$fp=@fsockopen($server,$port,$errno,$errstr);
		$command="$mycommand\r";


	//Dont Touch Anything :PPP

		if ($execs == "yes") {
			fputs($fp,$l2jpass);
			fputs($fp,$command);
			fputs($fp,"quit\r");
			while(!feof($fp))$output.=fread($fp,16);
			fclose($fp);
			$clear_r=array("Password Correct!","Password:","Please Insert Your Password!","\n","Password: Password Correct!","Welcome To The L2J Telnet Session.","[L2J]","Bye Bye!");
			$output = str_replace($clear_r,"", $output);
			//$output = str_replace("Incorrect Password!","\n\nIncorrect Password! Check config.php", $output);

			print "&phpconsole=";
			print "$output";
			print "&";
			print "&phpstatus=okman&";
			}else{
				print "OK";
			}
		}
foot();
/*
 

             // Logonserver Restart

                 $usetelnetlog = fsockopen($log_host, $log_port, $errno, $errstr, 5);

                 if($usetelnetlog)

                 {

                         $give_string = 'restart' ;

                         fputs($usetelnetlog, $log_password);

                         fputs($usetelnetlog, "\r\n");

                         fputs($usetelnetlog, $give_string);

                         fputs($usetelnetlog, "\r\n");

                         fclose($usetelnetlog);

                         echo "Restart 1: Restart Login Server...".$t;

                }

                else

                {

                        echo "Restart 1: <b>ERROR</b> Couldn't connect to telnet to restart Loginserver".$t;

                }

 

             //GameServer Restart

                flush();

                sleep (5);

                $usetelnetgs = fsockopen($gs_host, $gs_port, $errno, $errstr,5);

                if($usetelnetgs)

                {

                    $give_string = 'restart 5';

                    fputs($usetelnetgs, $gs_password);

                    fputs($usetelnetgs, "\r\n");

                    fputs($usetelnetgs, $give_string);

                    fputs($usetelnetgs, "\r\n");

                    fputs($usetelnetgs, "exit\r\n");

                    fclose($usetelnetgs);

                    echo "Restart 2: Restart Gameserver...".$t;

                 }

                 else

                 {

                        echo "Restart 2: <b>ERROR</b> Couldn't connect to telnet to restart Gameserver".$t;

                 }

 
*/
?>