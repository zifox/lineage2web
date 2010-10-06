<?php
define('INWEB', true);
require_once ("include/config.php");
//пароль
head("Home");
function convertPic($id, $width, $height)
{
    ini_set('memory_limit', '100M');   //  handle large images
    if(file_exists('news/'.$id.'_thumb.jpg'))
    unlink('news/'.$id.'_thumb.jpg');         //  remove old images if present
    $new_img = 'news/'.$id.'_thumb.jpg';

    $file_src = "news/$id.jpg";  //  temporary safe image storage

    list($w_src, $h_src, $type) = getimagesize($file_src);     // create new dimensions, keeping aspect ratio
    $ratio = $w_src/$h_src;
    if ($width/$height > $ratio) {$width = floor($height*$ratio);} else {$height = floor($width/$ratio);}

    switch ($type)
    {
        case 1:   //   gif -> jpg
            $img_src = imagecreatefromgif($file_src);
        break;
        case 2:   //   jpeg -> jpg
            $img_src = imagecreatefromjpeg($file_src);
        break;
        case 3:  //   png -> jpg
            $img_src = imagecreatefrompng($file_src);
        break;
    }
    $img_dst = imagecreatetruecolor($width, $height);  //  resample

    imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $width, $height, $w_src, $h_src);
    imagejpeg($img_dst, $new_img);    //  save new image
    imagedestroy($img_src);       
    imagedestroy($img_dst);
}
$maxfilesize = 1024*1024*1024*5; // 5Mb

$allowed_types = array(
"image/gif" => "gif",
"image/pjpeg" => "jpg",
"image/jpeg" => "jpg",
"image/jpg" => "jpg",
"image/png" => "png"
// Add more types here if you like
);
includeLang('index');
$action = addslashes($_GET['action']);
$id= (int)$_GET['id']+0;
if(!is_numeric($id) || $id <= 0) $id = NULL;
$parse = $Lang;

switch ($action)
{
    case 'add':
        if($user->mod())
        {
            if($_POST['add'])
            {
            $error=0;
            if(!isset($_POST['name']) || $_POST['name'] == '') 
            {
                echo 'Invalid or empty name! <br />';
                $error++;
            }
            if(!isset($_POST['desc']) || $_POST['desc'] == '') 
            {
                echo 'Invalid or empty Content!  <br />';
                $error++;
            }
            if($_FILES['file']['size'] > $maxfilesize)
            {
                echo 'File is too large! <br />';
                $error++;
            }
            if($_FILES['file']['name'] == '')
            {
                echo 'File is not specified! <br />';
                $error++;
            }
            if (!array_key_exists($_FILES['file']['type'], $allowed_types) && $_FILES['file']['name'] != '')
            {
                echo 'Wrong file type! <br />';
                $error++;
            }
            
            if($error === 0)
            {
                $name=$mysql->escape($_POST['name']);
                $desc=$mysql->escape($_POST['desc']);
                $desc=str_replace(array('\r\n'), '<br />', $desc);
                $desc=str_replace(array('\n'), '<br />', $desc);
                $desc=str_replace(array('\r'), '<br />', $desc);


                $descdb = substr($desc, 0, 500);
                $mysql->query($q[10], array('db' => $webdb, 'page'=>'index'));
                $mysql->query($q[9], array("db" => $webdb, "desc" => $descdb, "name" => $name, "author" => $_SESSION['account'], "date" => date('Y-m-d H:i:s')));
                $id=$mysql->result($mysql->query("SELECT LAST_INSERT_ID()"));
                if(file_exists('news/'.$id.'.html'))
                    unlink('news/'.$id.'.html');
                file_put_contents('news/'.$id.'.html', $desc);
                
                if(file_exists('news/'.$id.'.jpg'))
                    unlink('news/'.$id.'.jpg');
                move_uploaded_file($_FILES['file']['tmp_name'], 'news/'.$id.'.jpg');
                
                convertPic($id, 150, 150);
                    
                    
                    echo 'News added!';
                

            }
            else
            {
                echo 'Please fix errors and try again!';
            }

        }

                ?>
                <form action="news.php?action=add" method="post"  enctype="multipart/form-data">
                <table>
                <tr><td>
                <label for="name">Title:
                      <input type="text" value="" title="News Title" accesskey="t" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 150px;" size="50" id="name" name="name" />
                </label></td></tr>
                <tr><td>
                <label for="desc">Text:
                
                      <textarea rows="10" cols="20" title="News Content" accesskey="c" style="width: 100%;" id="desc" name="desc" ></textarea>
                </label></td></tr>
                <tr><td>
                <label for="file">Image: 
                      <input type="file" value="" title="Image" accesskey="f" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width:50px;" size="50" id="file" name="file" />
                </label></td></tr>
                <tr><td><input type="submit" value="Submit" /><input name="add" type="hidden" value="add" /></td></tr>
                </table>
                </form>
                <?php
                }
    break;
    case 'edit':
        if(isset($id) && $user->mod()  && $id !=NULL)
        {
            if($_POST['edit'])
            {
            $error=0;
            if(!isset($_POST['name']) || $_POST['name'] == '') 
            {
                echo 'Invalid or empty name! <br />';
                $error++;
            }
            if(!isset($_POST['desc']) || $_POST['desc'] == '') 
            {
                echo 'Invalid or empty Content!  <br />';
                $error++;
            }
            if($_FILES['file']['size'] > $maxfilesize)
            {
                echo 'File is too large! <br />';
                $error++;
            }
            if (!array_key_exists($_FILES['file']['type'], $allowed_types) && $_FILES['file']['name'] != '')
            {
                echo 'Wrong file type! <br />';
                $error++;
            }
            
            if($error === 0)
            {
                $name=$mysql->escape($_POST['name']);
                $desc=$mysql->escape($_POST['desc']);
                $desc=str_replace(array('\r\n'), '<br />', $desc);
                $desc=str_replace(array('\n'), '<br />', $desc);
                $desc=str_replace(array('\r'), '<br />', $desc);
                $newsq = $mysql->query($q[6], array("db" => $webdb, "news_id" => $id));
                if($mysql->num_rows($newsq))
                {
                if(file_exists('news/'.$id.'.html'))
                {
                    unlink('news/'.$id.'.html');
                }
                file_put_contents('news/'.$id.'.html', $desc);
                $desc = substr($desc, 0, 500);
                    $mysql->query($q[10], array('db' => $webdb, 'page'=>'index'));
                    $mysql->query($q[8], array("db" => $webdb, "news_id" => $id, "desc" => $desc, "name" => $name, "date" => date('Y-m-d H:i:s') , "editor" => $_SESSION['account']));
                    if($_FILES['file']['name'] != '')
                    {
                        if(file_exists('news/'.$id.'.jpg'))
                            unlink('news/'.$id.'.jpg');
                    move_uploaded_file($_FILES['file']['tmp_name'], 'news/'.$id.'.jpg');
                    convertPic($id, 150, 150);
                    
                    }
                    echo 'News updated!';
                }

            }
            else
            {
                echo 'Please fix errors and try again!';
            }

        }

                $newsq = $mysql->query($q[6], array("db" => $webdb, "news_id" => $id));
                if($mysql->num_rows($newsq))
                {
                    $news=$mysql->fetch_array($newsq);
                    $desc=file_exists('news/'.$id.'.html')?file_get_contents('news/'.$id.'.html'):$news['desc'];
                ?>
                <form action="news.php?action=edit&amp;id=<?php echo $id;?>" method="post"  enctype="multipart/form-data">
                <table>
                <tr><td>
                <label for="name">Title:
                      <input type="text" value="<?php echo $news['name'];?>" title="News Title" accesskey="t" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 150px;" size="50" id="name" name="name" />
                </label></td></tr>
                <tr><td>
                <label for="desc">Text:
                
                      <textarea rows="10" cols="20" title="News Content" accesskey="c" style="width: 100%;" id="desc" name="desc" ><?php echo htmlspecialchars($desc);?></textarea>
                </label></td></tr>
                <tr><td>
                <label for="file">Image: 
                      <input type="file" value="" title="Image" accesskey="f" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width:50px;" size="50" id="file" name="file" />
                </label></td></tr>
                <tr><td><input type="submit" value="Submit" /><input name="edit" type="hidden" value="edit" /></td></tr>
                </table>
                </form>
                <?php
                }
            }
    break;
    case 'delete':

        if(isset($id) && isset($_GET['confirm']) && $id!=NULL && $user->mod())
        {
            $mysql->query($q[7], array("db" => $webdb, "news_id" => $id));
            if(file_exists('news/'.$id.'.html'))
            {
                if(unlink('news/'.$id.'.html'))
                {
                    echo 'File <b>news/'.$id.'.html</b> deleted!<br />';
                }
            }
            if(file_exists('news/'.$id.'.jpg'))
            {
                if(unlink('news/'.$id.'.jpg'))
                {
                    echo 'File <b>news/'.$id.'.jpg</b> deleted!<br />';
                }
            }
            if(file_exists('news/'.$id.'_thumb.jpg'))
            {
                if(unlink('news/'.$id.'_thumb.jpg'))
                {
                    echo 'File <b>news/'.$id.'_thumb.jpg</b> deleted!<br />';
                }
            }
            echo 'Deleted from DataBase!';
        }
        else
        {
            if($user->mod())
            {
                echo '<a href="news.php?action=delete&amp;confirm=1&amp;id='.$id.'">';
                echo menubutton($Lang['delete']);
                echo '</a>';
            }
        }
    break;
    default:
    if(isset($id) && $id!=NULL)
    {
        $mysql->query($q[6], array("db" => $webdb, "news_id" => $id));
        if($mysql->num_rows())
        {
            if(file_exists('news/'.$id.'.html'))
            {
                $news = $mysql->fetch_array();
                $parse+=$news;
                $parse['desc'] = file_get_contents('news/'.$id.'.html');
            $parse['read_more']='';
            $nparse['thumb']='';
            if($user->mod())
            {
                $parse['add'] = '<a href="news.php?action=add"><img src="img/add.png" alt="'.$Lang['add'].'" title="'.$Lang['add'].'" border="0" /></a>';
                $parse['edit'] = '<a href="news.php?action=edit&amp;id='.$news['news_id'].'"><img src="img/edit.png" alt="'.$Lang['edit'].'" title="'.$Lang['edit'].'" border="0" /></a>';
                $parse['delete'] = '<a href="news.php?action=delete&amp;id='.$news['news_id'].'"><img src="img/delete.png" alt="'.$Lang['delete'].'" title="'.$Lang['delete'].'" border="0" /></a>';
            }
            else
            {
                $parse['add'] = '';
                $parse['edit'] = '';
                $parse['delete'] = '';
            }
            $tpl->parsetemplate('news_row', $parse);
                
            }
        }

        
    }
    else
    {
        $newsq=$mysql->query($q[5],  array("db" => $webdb, "limit" => $Config['news_limit']));
        while($news=$mysql->fetch_array($newsq))
        {
            $parse+=$news;
            $parse['read_more']='<a href="news.php?id='. $news['news_id'].'">'.$Lang['read_more'].'</a>';
            $nparse['thumb']='_thumb';
            if($user->mod())
            {
                $parse['add'] = '<a href="news.php?action=add"><img src="img/add.png" alt="'.$Lang['add'].'" title="'.$Lang['add'].'" border="0" /></a>';
                $parse['edit'] = '<a href="news.php?action=edit&amp;id='.$news['news_id'].'"><img src="img/edit.png" alt="'.$Lang['edit'].'" title="'.$Lang['edit'].'" border="0" /></a>';
                $parse['delete'] = '<a href="news.php?action=delete&amp;id='.$news['news_id'].'"><img src="img/delete.png" alt="'.$Lang['delete'].'" title="'.$Lang['delete'].'" border="0" /></a>';
            }
            else
            {
                $parse['add'] = '';
                $parse['edit'] = '';
                $parse['delete'] = '';
            }
            $tpl->parsetemplate('news_row', $parse);
        }
    }
    break;
}
foot();
?>