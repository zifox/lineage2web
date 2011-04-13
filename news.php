<?php
define('INWEB', true);
require_once ("include/config.php");
//пароль
head("News");

$maxfilesize = 1024 * 1024 * 1024 * 5; // 5Mb

$allowed_types = array("image/gif" => "gif", "image/pjpeg" => "jpg", "image/jpeg" => "jpg", "image/jpg" => "jpg", "image/png" => "png" // Add more types here if you like
	);
includeLang('index');
$action = addslashes($_GET['action']);
$id = (int)$_GET['id'] + 0;
if (! is_numeric($id) || $id <= 0) $id = null;
$parse = $Lang;

switch ($action)
{
	case 'add':
		if ($user->mod())
		{
			if ($_POST['add'])
			{
                $name=getVar('name');
                $desc=getVar('desc');
				$error = 0;
				if ($name=='')
				{
					echo 'Invalid or empty name! <br />';
					$error++;
				}
				if ($desc=='')
				{
					echo 'Invalid or empty Content!  <br />';
					$error++;
				}
				if ($_FILES['file']['size'] > $maxfilesize)
				{
					echo 'File is too large! <br />';
					$error++;
				}
				if ($_FILES['file']['name'] == '')
				{
					echo 'File is not specified! <br />';
					$error++;
				}
				if (! array_key_exists($_FILES['file']['type'], $allowed_types) && $_FILES['file']['name'] != '')
				{
					echo 'Wrong file type! <br />';
					$error++;
				}

				if ($error === 0)
				{
					$descdb = substr($desc, 0, 500);
					//$desc=str_replace('\r\n','<br />');
					$ext = $allowed_types[$_FILES['file']['type']];
                    $md5 = substr(md5($name .  time()), 0, 12);
					$sql->query($q[10], array('db' => $webdb, 'page' => 'index'));
					$sql->query($q[9], array("db" => $webdb, "desc" => $descdb, "name" => $name, "author" => $_SESSION['account'], "date" => date('Y-m-d H:i:s'), "image" => $md5 . '.' . $ext));
					//$id = $sql->result($sql->query("SELECT LAST_INSERT_ID()"));
                    if($sql->row_count)
                    {
					if (file_exists('news/' . $md5 . '.html')) unlink('news/' . $md5 . '.html');
					file_put_contents('news/' . $md5 . '.html', $desc);

					if (file_exists('news/' . $md5 . '.' . $ext)) unlink('news/' . $md5 . '.' . $ext);

					move_uploaded_file($_FILES['file']['tmp_name'], 'news/' . $md5 . '.' . $ext);
					convertPic($md5, $ext, 150, 150);
					msg('Success','News added');
                    }
                    else
                    {
                        msg('Error','Something went wrong');
                    }
                        
				}
				else
				{
					echo 'Please fix errors and try again!';
				}

			}
            ?>
            <form name="news" action="news.php?action=add" method="post"  enctype="multipart/form-data">
            <table>
                <tr><td>
                    <label for="name">Title:
                        <input type="text" value="" title="News Title" accesskey="t" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 150px;" size="50" id="name" name="name" />
                    </label>
                </td></tr>
                <tr><td>
                    <label for="desc">
                        <?php textbbcode("news","desc");?>
                    </label>
                </td></tr>
                <tr><td>
                    <label for="file">Image: 
                        <input type="file" value="" title="Image" accesskey="f" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width:50px;" size="50" id="file" name="file" />
                    </label>
                </td></tr>
                <tr><td>
                    <input type="submit" value="Submit" />
                    <input name="add" type="hidden" value="add" />
                </td></tr>
            </table>
            </form>
            <?php
		}
		break;
	case 'edit':
		if (isset($id) && $user->mod() && $id != null)
		{
			if ($_POST['edit'])
			{
				$error = 0;
				if (! isset($_POST['name']) || $_POST['name'] == '')
				{
					echo 'Invalid or empty name! <br />';
					$error++;
				}
				if (! isset($_POST['desc']) || $_POST['desc'] == '')
				{
					echo 'Invalid or empty Content!  <br />';
					$error++;
				}
				if ($_FILES['file']['size'] > $maxfilesize)
				{
					echo 'File is too large! <br />';
					$error++;
				}
				if (! array_key_exists($_FILES['file']['type'], $allowed_types) && $_FILES['file']['name'] != '')
				{
					echo 'Wrong file type! <br />';
					$error++;
				}

				if ($error === 0)
				{
					$name = $sql->escape($_POST['name']);
					$desc = $_POST['desc'];
					$desc = str_replace(array('\r\n'), '<br />', $desc);
					$desc = str_replace(array('\n'), '<br />', $desc);
					$desc = str_replace(array('\r'), '<br />', $desc);
					$newsq = $sql->query(6, array("db" => $webdb, "news_id" => $id));
					if ($sql->num_rows($newsq))
					{
						$news = $sql->fetch_array($newsq);
						$md5 = explode(".", $news['image']);
						$md5 = $md5[0];
						$ext = $allowed_types[$_FILES['file']['type']];
						if (file_exists('news/' . $md5 . '.html'))
						{
							unlink('news/' . $md5 . '.html');
						}
						file_put_contents('news/' . $md5 . '.html', $desc);
						$desc = $sql->escape(substr($desc, 0, 500));
						$sql->query($q[10], array('db' => $webdb, 'page' => 'index'));
						$sql->query($q[8], array("db" => $webdb, "news_id" => $id, "desc" => $desc, "name" => $name, "date" => date('Y-m-d H:i:s'), "editor" => $_SESSION['account']));
						if ($_FILES['file']['name'] != '')
						{
							if (file_exists('news/' . $md5 . '.' . $ext)) unlink('news/' . $md5 . '.' . $ext);
							move_uploaded_file($_FILES['file']['tmp_name'], 'news/' . $md5 . '.' . $ext);
							convertPic($md5, $ext, 150, 150);

						}
						echo 'News updated!';
					}
				}
				else
				{
					echo 'Please fix errors and try again!';
				}

			}

			$newsq = $sql->query($q[6], array("db" => $webdb, "news_id" => $id));
			if ($sql->num_rows($newsq))
			{
				$news = $sql->fetch_array($newsq);
                $md5 = explode(".", $news['image']);
				$desc = file_exists('news/' . $md5[0] . '.html') ? file_get_contents('news/' . $md5[0] . '.html') : $news['desc'];
                $desc=str_replace('\\r\\n',"\n",$desc);
                //$desc = nl2br($desc);
                ?>
                <form name="news" action="news.php?action=edit&amp;id=<?php echo $id; ?>" method="post"  enctype="multipart/form-data">
                <table>
                <tr><td>
                    <label for="name">Title:
                        <input type="text" value="<?php echo $news['name']; ?>" title="News Title" accesskey="t" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width: 150px;" size="50" id="name" name="name" />
                    </label>
                </td></tr>
                <tr><td>
                    <label for="desc">
                        <?php textbbcode("news","desc",$desc);?>
                    </label>
                </td></tr>
                <tr><td>
                    <label for="file">Image: 
                        <input type="file" value="" title="Image" accesskey="f" style="border: 0pt none; background: url('img/login_text.gif') no-repeat scroll 0% 0% transparent; color: rgb(217, 222, 218); width:50px;" size="50" id="file" name="file" />
                    </label>
                </td></tr>
                <tr><td>
                    <input type="submit" value="Submit" />
                    <input name="edit" type="hidden" value="edit" />
                </td></tr>
                </table>
                </form>
                <?php
			}
		}
		break;
	case 'delete':

		if (isset($id) && isset($_GET['confirm']) && $id != null && $user->mod())
		{
			$news = $sql->query($q[6], array("db" => $webdb, "news_id" => $id));
			if ($sql->num_rows($news))
			{
				$new = $sql->fetch_array($news);
				$sql->query($q[7], array("db" => $webdb, "news_id" => $id));
				$md5 = explode(".", $news['image']);
                $ext = $md5[1];
				$md5 = $md5[0];
				
				if (file_exists('news/' . $md5 . '.html'))
				{
					if (unlink('news/' . $md5 . '.html'))
					{
						echo 'File <b>news/' . $md5 . '.html</b> deleted!<br />';
					}
				}
				if (file_exists('news/' . $md5 . '.' . $ext))
				{
					if (unlink('news/' . $md5 . '.' . $ext))
					{
						echo 'File <b>news/' . $md5 . '.' . $ext . '</b> deleted!<br />';
					}
				}
				if (file_exists('news/' . $md5 . '_thumb.' . $ext))
				{
					if (unlink('news/' . $md5 . '_thumb.' . $ext))
					{
						echo 'File <b>news/' . $md5 . '_thumb.' . $ext . '</b> deleted!<br />';
					}
				}
				$sql->query($q[10], array('db' => $webdb, 'page' => 'index'));
				echo 'Deleted from DataBase!';
			}
			else
			{
				echo 'Not Found!';
			}
		}
		else
		{
			if ($user->mod())
			{
				echo '<a href="news.php?action=delete&amp;confirm=1&amp;id=' . $id . '">';
				echo menubutton($Lang['delete']);
				echo '</a>';
			}
		}
		break;
	default:
		if (isset($id) && $id != null)
		{
			$new = $sql->query($q[6], array("db" => $webdb, "news_id" => $id));
			if ($sql->num_rows($new))
			{
				$newid = $sql->fetch_array($new);

				$md5 = explode(".", $newid['image']);
				$md5 = $md5[0];

				if (file_exists('news/' . $md5 . '.html'))
				{
					$parse += $newid;
					$parse['desc'] = format_body(file_get_contents('news/' . $md5 . '.html'), 'false');
					$parse['read_more'] = '';
					$parse['thumb'] = $newid['image'];
					if ($newid['edited_by'] != '')
					{
						$parse['edited'] = 'Last edited <strong>' . $newid['edited'] . '</strong> by <strong>' . $newid['edited_by'] . '</strong>';
					}
					if ($user->mod())
					{
						$parse['add'] = '<a href="news.php?action=add"><img src="img/add.png" alt="' . $Lang['add'] . '" title="' . $Lang['add'] . '" border="0" /></a>';
						$parse['edit'] = '<a href="news.php?action=edit&amp;id=' . $newid['news_id'] . '"><img src="img/edit.png" alt="' . $Lang['edit'] . '" title="' . $Lang['edit'] . '" border="0" /></a>';
						$parse['delete'] = '<a href="news.php?action=delete&amp;id=' . $newid['news_id'] . '"><img src="img/delete.png" alt="' . $Lang['delete'] . '" title="' . $Lang['delete'] . '" border="0" /></a>';
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
			$newsq = $sql->query($q[5], array("db" => $webdb, "limit" => $Config['news_limit']));
			while ($news = $sql->fetch_array($newsq))
			{
				$parse = $Lang;
				$parse += $news;

				$parse['read_more'] = '<a href="news.php?id=' . $news['news_id'] . '">' . $Lang['read_more'] . '</a>';
				$md5 = explode(".", $news['image']);
				$parse['thumb'] = $md5[0] . '_thumb.' . $md5[1];
				if ($news['edited_by'] != '')
				{
					$parse['edited'] = 'Last edited <strong>' . $news['edited'] . '</strong> by <strong>' . $news['edited_by'] . '</strong>';
				}
				if ($user->mod())
				{
					$parse['add'] = '<a href="news.php?action=add"><img src="img/add.png" alt="' . $Lang['add'] . '" title="' . $Lang['add'] . '" border="0" /></a>';
					$parse['edit'] = '<a href="news.php?action=edit&amp;id=' . $news['news_id'] . '"><img src="img/edit.png" alt="' . $Lang['edit'] . '" title="' . $Lang['edit'] . '" border="0" /></a>';
					$parse['delete'] = '<a href="news.php?action=delete&amp;id=' . $news['news_id'] . '"><img src="img/delete.png" alt="' . $Lang['delete'] . '" title="' . $Lang['delete'] . '" border="0" /></a>';
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