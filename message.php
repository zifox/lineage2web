<?php
define('INWEB', True);
require_once("include/config.php");

if(!$user->logged())
{
    err('Error', 'You need to login');
}
define('PM_DELETED',0); // Message was deleted
define('PM_INBOX',1); // Message located in Inbox for reciever
define('PM_SENTBOX',2); // GET value for sent box
includeLang('message');
$a = getVar('a');
if (!$a)
{
    $a = 'viewmailbox';
}
switch($a)
{
    case "viewmailbox":
            // Get Mailbox Number
        $mailbox = getVar('box');
        if (!$mailbox)
        {
                $mailbox = PM_INBOX;
        }
                if ($mailbox == PM_INBOX)
                {
                        $mailbox_name = $Lang['inbox'];
                }
                else
                {
                        $mailbox_name = $Lang['outbox'];
                }

        // Start Page

        head($mailbox_name); ?>
        <script language="Javascript" type="text/javascript">
        <!-- Begin
        var checkflag = "false";
        var marked_row = new Array;
        function check(field) {
                if (checkflag == "false") {
                        for (i = 0; i < field.length; i++) {
                                field[i].checked = true;}
                                checkflag = "true";
                        }
                else {
                        for (i = 0; i < field.length; i++) {
                                field[i].checked = false; }
                                checkflag = "false";
                        }
                }
                //  End -->
        </script>
        <script language="javascript" type="text/javascript" src="js/functions.js"></script>
        <h1><?php echo $mailbox_name;?></h1>
        <div align="right"><form action="message.php" method="get">
        <input type="hidden" name="a" value="viewmailbox" /><?php echo $Lang['go_to'];?>: <select name="box">
        <option value="1"<?php echo ($mailbox == PM_INBOX ? " selected" : "");?>><?php echo $Lang['inbox'];?></option>
        <option value="2"<?php echo ($mailbox == PM_SENTBOX ? " selected" : "");?>><?php echo $Lang['outbox'];?></option>
        </select> <input type="submit" value="<?php echo $Lang['go_go_go'];?>" /></form>
        </div>
        <table border="0" cellpadding="4" cellspacing="0" width="100%">
        <form action="message.php" method="post" name="form1">
        <input type="hidden" name="action" value="moveordel" />
        <tr>
        <td width="2%" class="colhead">&nbsp;&nbsp;</td>
        <td width="51%" class="colhead"><?php echo $Lang['subject'];?></td>
        <?php
        if ($mailbox == PM_INBOX )
                echo '<td width="35%" class="colhead">'.$Lang['sender'].'</td>';
        else
                echo '<td width="35%" class="colhead">'.$Lang['receiver'].'</td>';
        ?>
        <td width="10%" class="colhead"><?php echo $Lang['date'];?></td>
        <td width="2%" class="colhead"><input type="checkbox" title="<?php echo $Lang['mark_all'];?>" value="<?php echo $Lang['mark_all'];?>" onclick="this.value=check(document.form1.elements);" /></td>
        </tr>
        <?php if ($mailbox != PM_SENTBOX) {
                $res=$sql->query('SELECT * FROM l2web.messages WHERE receiver=\''.$_SESSION['account'].'\' AND location=\''.$mailbox.'\' ORDER BY id DESC');
        } else {
                $res=$sql->query('SELECT * FROM l2web.messages WHERE sender=\''.$_SESSION['account'].'\' AND saved=\'yes\' ORDER BY id DESC');
        }
        if (!$sql->num_rows()) {
                echo'<td colspan="6" align="center">'.$Lang['no_messages'].'.</td><br />';
        }
        else
        {
                while ($row = $sql->fetch_array())
                {
                        if ($row['sender'] != 0) {
                            $username = "<a href=\"userdetails.php?id=" . $row['sender'] . "\">" . $row["sender"] . "</a>";
                                
                        }
                        else {
                                $username = $Lang['from_system'];
                        }
                        if ($row['receiver'] != 0) {
                                $receiver = "<a href=\"userdetails.php?id=" . $row['receiver'] . "\">" . $row["receiver"] . "</a>";
                        }
                        else {
                                $receiver = $Lang['from_system'];
                        }
                        $subject = htmlspecialchars($row['subject']);
                        if (strlen($subject) <= 0) {
                                $subject = $Lang['no_subject'];
                        }
                        if ($row['unread'] == 'yes' && $mailbox != PM_SENTBOX) {
                                echo'<tr><td ><img src="img/pn_inboxnew.gif" alt="'.$Lang['mail_unread'].'" /></td>';
                        }
                        else {
                                echo'<tr><td><img src="img/pn_inbox.gif" alt="'.$Lang['mail_read'].'"></td>';
                        }
                        echo'<td><a href="message.php?a=viewmessage&amp;id=' . $row['id'] . '">' . $subject . '</a></td>';
                        if ($mailbox != PM_SENTBOX) {
                            echo'<td>'.$username.'</td>';
                        }
                        else {
                            echo'<td>'.$receiver.'</td>';
                        }
                        echo'<td nowrap>' . display_date_time(strtotime($row['added']), 2) . '</td>';
                        echo'<td><input type="checkbox" name="messages[]" title="'.$Lang['mark'].'" value="' . $row['id'] . '" id="checkbox_tbl_' . $row['id'] . '"></td></tr>';
                }
        }
        ?>
        <tr class="colhead">
        <td colspan="6" align="right" class="colhead">
        <input type="hidden" name="box" value="<?php echo $mailbox;?>" />
        <input type="submit" name="delete" title="<?php echo $Lang['delete_marked_messages'];?>" value="<?php echo $Lang['delete'];?>" onclick="return confirm('<?php echo $Lang['sure_mark_delete'];?>')" />
        <input type="submit" name="markread" title="<?php echo $Lang['mark_as_read'];?>" value="<?php echo $Lang['mark_read'];?>" onclick="return confirm('<?php echo $Lang['sure_mark_read'];?>')" /></form>
        </td>
        </tr>
        </form>
        </table>
        <div align="left"><img src="img/pn_inboxnew.gif" alt="<?php echo $Lang['mail_unread_desc'];?>" /> <?php echo $Lang['mail_unread_desc'];?><br />
        <img src="img/pn_inbox.gif" alt="<?php echo $Lang['mail_read_desc'];?>" /> <?php echo $Lang['mail_read_desc'];?></div>
        <?php
        foot();
        break;
    case "viewmessage":
    break;
}


if ($a == "viewmessage") {
        $pm_id = getVar('id');
        if (!$pm_id)
        {
                msg('Error','Missing ID','error');
        }
        
        
        $res=$sql->query('SELECT * FROM l2web.messages WHERE id=\''.$pm_id.'\' AND (receiver=\'' . $_SESSION['account'] . '\' OR (sender=\'' . $_SESSION['account']. '\' AND saved=\'yes\')) LIMIT 1');
        if (!$sql->num_rows())
        {
                msg($Lang['error'],'Message Not Found!','error');
        }
        $message = $sql->fetch_array();
        if ($message['sender'] == $_SESSION['account'])
        {
                $sender = "<a href=\"userdetails.php?id=" . $message['receiver'] . "\">" . $message['receiver'] . "</a>";
                $reply = "";
                $from = "Me";
        }
        else
        {
                $from = "From";
                if ($message['sender'] == 0)
                {
                        $sender = "System";
                        $reply = "";
                }
                else
                {
                        $sender = "<a href=\"userdetails.php?id=" . $message['sender'] . "\">" . $message['sender'] . "</a>";
                        $reply = " [ <a href=\"message.php?a=sendmessage&amp;receiver=" . $message['sender'] . "&amp;replyto=" . $pm_id . "\">Reply</a> ]";
                }
        }
        $body = format_body($message['msg']);
        $added = display_date_time(strtotime($message['added']), 2);
        if ($user->mod() && $message['sender'] == $_SESSION['account'])
        {
                $unread = ($message['unread'] == 'yes' ? "<span style=\"color: #FF0000;\"><b>(New)</b></a>" : "");
        }
        else
        {
                $unread = "";
        }
        $subject = htmlspecialchars($message['subject']);
        if (strlen($subject) <= 0)
        {
                $subject = "No subject";
        }
        $sql->query("UPDATE l2web.messages SET unread='no' WHERE id='" . $pm_id . "' AND receiver='" . $_SESSION['account'] . "' LIMIT 1");
        head("Private Message (Subject: $subject)"); ?>
        <table width="660" border="0" cellpadding="4" cellspacing="0">
        <tr><td class="colhead" colspan="2">Subject: <?php echo $subject; ?></td></tr>
        <tr>
        <td width="50%" class="colhead"><?php echo $from; ?></td>
        <td width="50%" class="colhead">Date</td>
        </tr>
        <tr>
        <td><?php echo $sender; ?></td>
        <td><?php echo $added; ?>&nbsp;&nbsp;<?php echo $unread; ?></td>
        </tr>
        <tr>
        <td colspan="2"><?php echo $body; ?></td>
        </tr>
        <tr>
        <td align="right" colspan="2">[ <a href="message.php?a=deletemessage&id=<?php echo $pm_id; ?>">Delete</a> ]<?php echo $reply; ?> [ <a href="message.php?a=forward&id=<?php echo $pm_id; ?>">Forward</a> ]</td>
        </tr>
        </table><?php
        foot();
}

if ($a == "sendmessage") {

        $receiver = getVar('receiver');
        $replyto = getVar('replyto');

        $auto = getVar('auto');
        $std = getVar('std');

        if (($auto || $std ) && !$user->mod())
                msg($Lang['error'], "Wrong place");

        //$res = sql_query("select * FROM users WHERE id=$receiver") or die(mysql_error());
        //$user = mysql_fetch_assoc($res);
        //if (!$user)
        //        stderr($Lang['error'], "ѕользовател€ с таким ID не существует.");
        if ($auto)
                $body = $pm_std_reply[$auto];
        if ($std)
                $body = $pm_template[$std][1];

        if ($replyto) {
                $res = $sql->query("SELECT * FROM l2web.messages WHERE id=$replyto");
                $msga = $sql->fetch_array();
                if ($msga["receiver"] != $_SESSION['account'])
                        err($Lang['error'], "Incorrect message!");

                $body .= "\n\n\n-------- {$msga['sender']} wrote: --------\n".htmlspecialchars($msga['msg'])."\n";
                // Change
                $subject = "Re: " . htmlspecialchars($msga['subject']);
                // End of Change
        }

        head("Send Private Message");
        ?>
        <table class="main" border="0" cellspacing="0" cellpadding="0"><tr><td class="embedded">
        <form name="message" method="post" action="message.php">
        <input type="hidden" name="a" value="takemessage" />
        <table class="message" cellspacing="0" cellpadding="5">
        <tr><td colspan="2" class="colhead">To <a class="altlink_white" href="userdetails.php?id=<?php echo $receiver; ?>"><?php echo $receiver; ?></a></td></tr>
        <tr>
        <td colspan="2"><b>Subject:&nbsp;&nbsp;</b>
        <input name="subject" type="text" size="60" value="<?php echo $subject; ?>" maxlength="255" /></td>
        </tr>
        <tr><td<?php echo $replyto?" colspan=\"2\"":"";?>>
        <?php
        textbbcode("message","msg","$body");
        ?>
        </td></tr>
        <tr>
        <?php if ($replyto) { ?>
        <td align="center"><input type="checkbox" name="delete" value="yes" />Delete PM after reply
        <input type="hidden" name="origmsg" value="<?php echo $replyto; ?>" /></td>
        <?php } ?>
        <td align="center"><input type="checkbox" name="save" value="yes" />Save PM in outbox</td></tr>
        <tr><td<?php echo $replyto?" colspan=2":"";?> align="center"><input type="submit" value="Send!" class="btn" /></td></tr>
        </table>
        <input type="hidden" name="receiver" value="<?php echo $receiver; ?>" />
        </form>
        </div></td></tr></table>
        <?php
        foot();
}

if ($a == 'takemessage') {

        $receiver = getVar('receiver');
        $origmsg = getVar('origmsg');
        $save = getVar('save');
        $returnto = getVar('returnto');
        //if (!is_valid_id($receiver) || ($origmsg && !is_valid_id($origmsg)))
        //        stderr($Lang['error'],"Ќеверный ID");
        $msg = getVar('msg');
        if (!$msg)
                err($Lang['error'],"Body cannot be empty!");
        $subject = getVar('subject');
        if (!$subject)
                err($Lang['error'],"Subject cannot be empty!");
        $save = ($save == 'yes') ? "yes" : "no";
        $sql->query("INSERT INTO l2web.messages (sender, receiver, added, msg, subject, saved, location) VALUES('" . $_SESSION['account'] . "',
        '$receiver', '" . get_date_time() . "', '" . $msg . "', '" . $subject . "', '" . $save . "', 1)");

        $delete = getVar('delete');
        if ($origmsg)
        {
                if ($delete == "yes")
                {
                        // Make sure receiver of $origmsg is current user
                        $res = $sql->query("SELECT * FROM messages WHERE id=$origmsg");
                        if ($sql->num_rows())
                        {
                                $arr = $sql->fetch_array();
                                if ($arr["receiver"] != $_SESSION['account'])
                                        err($Lang['error'],"Incorrect message!");
                                if ($arr["saved"] == "no")
                                        $sql->query("DELETE FROM messages WHERE id=$origmsg");
                                elseif ($arr["saved"] == "yes")
                                        $sql->query("UPDATE messages SET unread = 'no', location = '0' WHERE id=$origmsg");
                        }
                }
                if (!$returnto)
                        $returnto = "message.php";
        }
        if ($returnto) {
                header("Location: $returnto");
                die;
        }
        else {
                header ("Refresh: 2; url=message.php");
                head('Message sent!');
                msg($Lang['success'] , "Message successfully sent!");
                foot();
                exit();
        }


}

if ($a == 'mass_pm') {
        if (!$user->mod())
                err($Lang['error'], $Lang['access_denied']);
        $n_pms = getVar('n_pms');
        $pmees = getVar('pmees');
        $auto = getVar('auto');

        if ($auto)
                $body=$mm_template[$auto][1];

        head("Send PM");
        ?>
        <table class="main" border="0" cellspacing="0" cellpadding="0">
        <tr><td class="embedded"><div align="center">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" name="message">
        <input type="hidden" name="a" value="takemass_pm" />
        <?php if ($_SERVER["HTTP_REFERER"]) { ?>
        <input type="hidden" name="returnto" value="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]);?>" />
        <?php } ?>
        <table border="1" cellspacing="0" cellpadding="5">
        <tr><td class="colhead" colspan="2">Mass PM <?php echo $n_pms;?> user<?php echo($n_pms>1?"s":"");?></td></tr>
        <tr>
        <td colspan="2"><b>Subject:&nbsp;&nbsp;</b>
        <input name="subject" type="text" size="60" maxlength="255" /></td>
        </tr>
        <tr><td colspan="2"><div align="center">
        <?php echo textbbcode("message","msg","$body");?>
        </div></td></tr>
        <tr><td colspan="2"><div align="center"><b>Body:&nbsp;&nbsp;</b>
        <input name="comment" type="text" size="70" />
        </div></td></tr>
        <tr><td><div align="center"><b>From:&nbsp;&nbsp;</b>
        <?php echo $_SESSION['account']?>
        <input name="sender" type="radio" value="self" checked="checked" />
        &nbsp; System
        <input name="sender" type="radio" value="system" />
        </div></td>
        <td><div align="center"><b>Take snapshot:</b>&nbsp;<input name="snap" type="checkbox" value="1" />
         </div></td></tr>
        <tr><td colspan="2" align="center"><input type="submit" value="Send!" class="btn" />
        </td></tr></table>
        <input type="hidden" name="pmees" value="<?php echo $pmees;?>" />
        <input type="hidden" name="n_pms" value="<?php echo $n_pms;?>" />
        </form><br /><br />
        </div>
        </td>
        </tr>
        </table>
        <?php
        foot();

}

if ($a == 'takemass_pm') {
        if (!$user->mod())
                err($Lang['error'], $Lang['access_denied']);
        $msg = getVar('msg');
        if (!$msg)
                err($Lang['error'],"Empty message");
        $sender_id = (getVar('sender') == 'system' ? 0 : $_SESSION['account']);
        $from_is = getVar('pmees');
        // Change
        $subject = getVar('subject');
        $query = "INSERT INTO messages (sender, receiver, added, msg, subject, location, poster) ". "select $sender_id, u.id, '" . get_date_time(time()) . "', " .
        $msg . ", " . $subject . ", 1, $sender_id " . $from_is;
        // End of Change
        $sql->query($query);
        $n = $sql->row_count;
        $n_pms = getVar('n_pms');

        header ("Refresh: 3; url=message.php");
        
        suc($Lang['success'], (($n_pms > 1) ? "$n messages from $n_pms was" : "Message was")." successfully sent!");
}

if ($a == "moveordel") {
        $pm_id = getVar('id');
        $pm_box = getVar('box');
        $pm_messages = getvar('messages');
        if (getVar('move')) {
                if ($pm_id) {
                        // Move a single message
                        $sql->query("UPDATE l2web.messages SET location=" . $pm_box . ", saved = 'yes' WHERE id=" . $pm_id . " AND receiver=" . $_SESSION['account'] . " LIMIT 1");
                }
                else {
                        // Move multiple messages
                        $sql->query("UPDATE l2web.messages SET location=" . $pm_box . ", saved = 'yes' WHERE id IN (" . implode(", ",$pm_messages) . ') AND receiver=' . $_SESSION['account']);
                }
                // Check if messages were moved
                if (!$sql->row_count) {
                        err($Lang['error'], "Unable to move messages!");
                }
                header("Location: message.php?a=viewmailbox&box=" . $pm_box);
                exit();
        }
        elseif (getVar('delete')) {
                if ($pm_id) {
                        // Delete a single message
                        $res = $sql->query("SELECT * FROM messages WHERE id=" . $pm_id);
                        $message = $sql->fetch_array();
                        if ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'no') {
                                $sql->query("DELETE FROM l2web.messages WHERE id=" . $pm_id);
                        }
                        elseif ($message['sender'] ==$_SESSION['account'] && $message['location'] == PM_DELETED) {
                                $sql->query("DELETE FROM l2web.messages WHERE id=" . $pm_id);
                        }
                        elseif ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'yes') {
                                $sql->query("UPDATE l2web.messages SET location=0 WHERE id=" . $pm_id);
                        }
                        elseif ($message['sender'] == $_SESSION['account'] && $message['location'] != PM_DELETED) {
                                $sql->query("UPDATE l2web.messages SET saved='no' WHERE id=" . $pm_id);
                        }
                } else {
                        // Delete multiple messages
                        if (is_array($pm_messages))
                        foreach ($pm_messages as $id) {
                            $id=int_val($id);
                                $res = $sql->query("select * FROM l2web.messages WHERE id=" . $id);
                                $message = mysql_fetch_assoc($res);
                                if ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'no') {
                                        $sql->query("DELETE FROM l2web.messages WHERE id=" .$id);
                                }
                                elseif ($message['sender'] == $_SESSION['account'] && $message['location'] == PM_DELETED) {
                                        $sql->query("DELETE FROM l2web.messages WHERE id=" . $id);
                                }
                                elseif ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'yes') {
                                        $sql->query("UPDATE l2web.messages SET location=0 WHERE id=" . $id);
                                }
                                elseif ($message['sender'] == $_SESSION['account'] && $message['location'] != PM_DELETED) {
                                        $sql->query("UPDATE l2web.messages SET saved='no' WHERE id=" . $id);
                                }
                        }
                }
                // Check if messages were moved
                if (!$sql->row_count) {
                        err($Lang['error'],"Failed to delete messages");
                }
                else {
                        header("Location: message.php?a=viewmailbox&box=" . $pm_box);
                        exit();
                }
        }
        elseif (getVar('markread')) {
                if ($pm_id) {
                        $sql->query("UPDATE l2web.messages SET unread='no' WHERE id = " . $pm_id);
                }
                else {
                		if (is_array($pm_messages))
                        foreach ($pm_messages as $id) {
                            $id=int_val($id);
                                $res = $sql->query("select * FROM l2web.messages WHERE id=" . $id);
                                $message = mysql_fetch_assoc($res);
                                $sql->query("UPDATE l2web.messages SET unread='no' WHERE id = " . $id) ;
                        }
                }
                if (!$sql->row_count) {
                        err($Lang['error'], "Nothing to mark! ");
                }
                else {
                        header("Location: message.php?action=viewmailbox&box=" . $pm_box);
                        exit();
                }
        }

err($Lang['error'],"No action");
}

if ($a == "forward") {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                // Display form
                $pm_id = getVar('id');

                // Get the message
                $res = $sql->query('select * FROM l2web.messages WHERE id=' . $pm_id . ' AND (receiver=' . $_SESSION['account'] . ' OR sender=' . $_SESSION['account'] . ') LIMIT 1');

                if (!$res) {
                        err($Lang['error'], "Invalid ID");
                }
                if (!$sql->row_count) {
                        err($Lang['error'], "Invalid ID");
                }
                $message = $sql->fetch_array();

                // Prepare variables
                $subject = "Fwd: " . htmlspecialchars($message['subject']);
                $from = $message['sender'];
                $orig = $message['receiver'];

                //$res = sql_query("select username FROM users WHERE id=" . sqlesc($orig) . " OR id=" . sqlesc($from)) or sqlerr(__FILE__,__LINE__);

                //$orig2 = mysql_fetch_assoc($res);
                $orig_name = "<A href=\"userdetails.php?id=" . $message['sender'] . "\">" . $message['sender'] . "</A>";
                if ($from == 0) {
                        $from_name = "System";
                        $from2['username'] = "System";
                }
                else {
                        //$from2 = mysql_fetch_array($res);
                        $from_name = "<A href=\"userdetails.php?id=" . $message['sender'] . "\">" . $message['sender'] . "</A>";
                }

                $body = "-------- Original PM From " . $message['sender'] . ": --------<br />" . format_body($message['msg']);

                head($subject);?>

                <form action="message.php" method="post">
                <input type="hidden" name="action" value="forward" />
                <input type="hidden" name="id" value="<?php echo $pm_id;?>" />
                <table border="0" cellpadding="4" cellspacing="0">
                <tr><td class="colhead" colspan="2"><?php echo $subject;?></td></tr>
                <tr>
                <td>To:</td>
                <td><input type="text" name="to" value="Input name" size="83" /></td>
                </tr>
                <tr>
                <td>Original<br />sender</td>
                <td><?php echo $orig_name;?></td>
                </tr>
                <tr>
                <td>From:</td>
                <td><?php echo $from_name;?></td>
                </tr>
                <tr>
                <td>Subject:</td>
                <td><input type="text" name="subject" value="<?php echo $subject;?>" size="83" /></td>
                </tr>
                <tr>
                <td>Message:</td>
                <td><textarea name="msg" cols="80" rows="8"></textarea><br /><?php echo $body;?></td>
                </tr>
                <tr>
                <td colspan="2" align="center">Save message <input type="checkbox" name="save" value="1" />&nbsp;<input type="submit" value="Forward" /></td>
                </tr>
                </table>
                </form><?php
                foot();
        }

        else {

                // Forward the message
                $pm_id = getVar('id');

                // Get the message
                $res = $sql->query('select * FROM l2web.messages WHERE id=' . $pm_id . ' AND (receiver=' . $_SESSION['account'] . ' OR sender=' . $_SESSION['account'] . ') LIMIT 1');
                if (!$res) {
                        err($Lang['error'], "You don't have permission to forward this message");
                }

                if (!$sql->num_rows()) {
                        stderr($Lang['error'], "You don't have permission to forward this message");
                }

                $message = $sql->fetch_array();
                $subject = getVar('subject');
                $username = getVar('to');

                $res = $sql->query("select login FROM accounts WHERE LOWER(login)=LOWER(" . $username . ") LIMIT 1");
                if (!$res) {
                        err($Lang['error'], "User not found");
                }
                if (!$sql->num_rows()) {
                        err($Lang['error'], "User not found");
                }

                $to = $sql->fetch_array();
                $to = $to[0];

                // Get Orignal sender's username
                if ($message['sender'] == 0) {
                        $from = "System";
                }
                else {
                        $res = $sql->query("select * FROM users WHERE id=" . $message['sender']);
                        $from = $sql->fetch_array();
                        $from = $from['username'];
                }
                $body = getVar('msg');
                $body .= "\n-------- ќригинальное сообщение от " . $from . ": --------\n" . $message['msg'];
                $save = (int) $_POST['save'];
                if ($save) {
                        $save = 'yes';
                }
                else {
                        $save = 'no';
                }

                //Make sure recipient wants this message
                /*if (get_user_class() < UC_MODERATOR) {
                        if ($from["acceptpms"] == "yes") {
                                $res2 = sql_query("select * FROM blocks WHERE userid=$to AND blockid=" . $CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
                                if (mysql_num_rows($res2) == 1)
                                        stderr("ќтклонено", "Ётот пользователь добавил вас в черный список.");
                        }
                        elseif ($from["acceptpms"] == "friends") {
                                $res2 = sql_query("select * FROM friends WHERE userid=$to AND friendid=" . $CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
                                if (mysql_num_rows($res2) != 1)
                                        stderr("ќтклонено", "Ётот пользователь принимает сообщение только из списка своих друзей.");
                        }

                        elseif ($from["acceptpms"] == "no")
                                stderr("ќтклонено", "Ётот пользователь не принимает сообщени€.");
                }*/
                $sql->query("INSERT INTO l2web.messages (poster, sender, receiver, added, subject, msg, location, saved) VALUES(" . $_SESSION['account'] . ", " . $_SESSION['account'] . ", $to, '" . get_date_time() . "', " . $subject . "," . $body . ", " . PM_INBOX . ", " . $save . ")");
                        err("Success", "PM Forwarded");
        }
}

if ($a == "deletemessage") {
        $pm_id = getVar('id');

        $res = $sql->query("select * FROM l2web.messages WHERE id=" . $pm_id) ;
        if (!$res) {
                err($Lang['error'],"Message not found");
        }
        if (!$sql->num_rows()) {
                err($Lang['error'],"Message not found");
        }
        $message = $sql->fetch_array();
        if ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'no') {
                $res2 = $sql->query("DELETE FROM l2web.messages WHERE id=" . $pm_id);
        }
        elseif ($message['sender'] == $_SESSION['account'] && $message['location'] == PM_DELETED) {
                $res2 = $sql->query("DELETE FROM l2web.messages WHERE id=" . $pm_id);
        }
        elseif ($message['receiver'] == $_SESSION['account'] && $message['saved'] == 'yes') {
                $res2 = $sql->query("UPDATE l2web.messages SET location=0 WHERE id=" . $pm_id);
        }
        elseif ($message['sender'] == $_SESSION['account'] && $message['location'] != PM_DELETED) {
                $res2 = $sql->query("UPDATE l2web.messages SET saved='no' WHERE id=" . $pm_id);
        }
        if (!$res2) {
                err($Lang['error'],"Failed to delete");
        }
        if (!$sql->row_count) {
                err($Lang['error'],"Failed to delete");
        }
        else {
                header("Location: message.php?action=viewmailbox&id=" . $message['location']);
                exit();
        }
}

?>