<?php
include("module/stat-menu.php");

//Это заголовок для кодировки
$header="";

//Это массив с нежелательными и "безопасными" символами
$escape=array
(
     "\n" => "",
     "\r" => "",
     "="    => "*#!equals!#*"
);
//Проверка на пустоту
if( empty($_POST['text']) || empty($_POST['textarea']) )
{
     echo $header;
     echo "One or both fields empty.<br>";
     echo "<input type=button value='Back' OnClick='javascript:history.back()'>";
     exit;
}
//Попытка открыть файл
if(!$handle=fopen('module/data.txt', 'at'))
{
     echo $header;
     echo "Cannot open File.<br>";
     echo "<input type=button value='Back' OnClick='javascript:history.back()'>";
     exit;
}

//Записываем две переменные в строку - чтобы не делать всё по два раза
$content='['.getenv("REMOTE_ADDR").']'.$_POST["text"].'*#!divider!#*'.$_POST["textarea"];

//Заменяем переводы строк на <br />
//и применяем как фильтр массив $escape
$content=nl2br($content);
$content=strtr($content, $escape);

//Разбиваем строку по константе *#!divider!#*, затем
//сворачиваем ее через "=" и добавляем в конец "\n"
$content=implode("=", explode("*#!divider!#*",
$content))."\n";

//Убираем теги и специальные символы HTML  - защищаемся от XSS
$content=strip_tags($content);
$content=htmlspecialchars($content, ENT_QUOTES);

//Блокируем файл
flock($handle, LOCK_EX);

//Пишем в файл
if(fwrite($handle, $content) === FALSE)
{
     echo $header;
     echo "Cannot add things to file";

     exit;
}

//Разблокируем и закрываем файл
flock($handle, LOCK_UN);
fclose($handle);
{
     echo $header;
     echo "<br><br><b>Your message have sended to Administration</b>.<br>";  
}
?>
<form name='form' action='./index.php?id=gm' method='POST'><br />
<input type="submit" name="action" value="Back" /></form>