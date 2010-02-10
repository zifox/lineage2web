<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Contact");
includeLang('contact');
$action=$_GET['action'];

switch($action){
Case 'delete':
if(logedin() && is_admin())
{
$filename="module/data.txt";
if (unlink($filename))
echo"<b>All Messages have been deleted.</b><br><br>";
?>
<b>Delete all messages:</b>
<form name='form' action='contact.php' method='post'>
          <br />
      
         <input type="submit" name='action' value='Back' />
     </form><?php
}
break;
Case 'send':

$escape=array
(
     "\n" => "",
     "\r" => "",
     "="    => "*#!equals!#*"
);

if( empty($_POST['text']) || empty($_POST['textarea']) )
{
     echo "One or both fields empty.<br>";
     echo "<input type=button value='Back' OnClick='javascript:history.back()'>";
     exit;
}

if(!$handle=fopen('module/data.txt', 'at'))
{
     echo "Cannot open File.<br>";
     echo "<input type=button value='Back' OnClick='javascript:history.back()'>";
     exit;
}


$content='['.getenv("REMOTE_ADDR").']'.$_POST["text"].'*#!divider!#*'.$_POST["textarea"];


$content=nl2br($content);
$content=strtr($content, $escape);

$content=implode("=", explode("*#!divider!#*",
$content))."\n";

$content=strip_tags($content);
$content=htmlspecialchars($content, ENT_QUOTES);


flock($handle, LOCK_EX);


if(fwrite($handle, $content) === FALSE)
{
     echo "Cannot add things to file";

     exit;
}

flock($handle, LOCK_UN);
fclose($handle);
{
     echo $header;
     echo "<br><br><b>Your message have sent to Administration</b>.<br>";  
}
?>
<form name='form' action='stat.php' method='get'><br />
<input type="submit" name="stat" value="Back"  /></form>
<?
break;
Case 'read':
if(logedin() && is_admin()){
$filename="module/data.txt";
if ( file_exists($filename) )
{
     $data=file($filename);
     echo "<table width=500 align=center cellspacing=0 cellpadding=2 border=1><tr><td><b>[IP]Nick</b></td><td><b>Message</b></td></tr>";
     foreach($data as $content)
     {
         if($content==="")
         {
             continue;
         }

         if(!$values=explode("=", $content))
         {
             continue;
         }
         echo "<tr>";
         foreach($values as $text)
         {
             echo" <td valign=top>";
             $text=str_replace("*#!equals!#*", "=", $text);
             echo $text;
             echo" </td>";
         }
         echo " </tr>";
     }
     echo "</table> ";
}
else
{
     echo "<b>You dont have new messages</b><br><br>";
}
?>
    

 <b>Delete all messages:</b>
<form name='form' action='contact.php?action=delete' method='get'>
<br /><input type="submit" name='action' value='delete' />
</form>
<?
}
break;
/*$filename="module/data.txt";

if ( file_exists($filename) )
{
     $data=file($filename);
     {
         if($content==="")
         {
             continue;
         }

         if(!$values=explode("=", $content))
         {
             continue;
         }
         foreach($values as $text)
         {
             echo" <td valign=top>";
             $text=str_replace("*#!equals!#*", "=", $text);
             echo $text;
             echo" </td>";
         }
     }
}
else
{
     echo "";
}*/
default:
if(logedin() && is_admin())
{
    echo '<a href="contact.php?action=read">Read Messages</a>';
}
?><br /> 
<b>Write message to server Administration:</b><br /><br />
<form name='form' action='contact.php?action=send' method='post'>
Your Nick:<br /><input type="text" name="text" size="20" value="<?php echo (isset($_SESSION['account']))? $_SESSION['account'] :'';?>" /><br /><br />
Message:<br /><textarea name="textarea" rows="5" cols="20"></textarea><br /><br />
<input type="submit" name='action' value='Send' /></form>
<?php
break;
}
foot();
?>