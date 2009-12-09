<?php
$filename="data.txt";
//Если файл существует
if ( file_exists($filename) )
{
     //Чтение построчно в массив
     $data=file($filename);
     echo "<table width=500 align=center cellspacing=0 cellpadding=2 border=1><tr><td><b>Nick</b></td><td><b>Message</b></td></tr>";
     //Перебор массива $data
     foreach($data as $content)
     {
         //Это - здоровая паранойя
         //проверка на пустоту текущей строки
         if($content==="")
         {
             continue;
         }
         //Разбиваем строку из файла на составляющие, а если в строке
         //вообще символа "=" нет, переходим сразу к следующей (строке)
         if(!$values=explode("=", $content))
         {
             continue;
         }
         echo "<tr>";
         //Перебираем - это для универсальности кода
         foreach($values as $text)
         {
             echo" <td valign=top>";
             //Заменяем "безопасные строки" обратно
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
<form name='form' action='./index.php?id=del' method='POST'>
          <br>
      
         <input type=submit name='action' value='Delete'>
     </form>


</font>
</body>
</html>
<!-- end of msg.php--> 
