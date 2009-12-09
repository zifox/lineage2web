<?php 
includeLang('start');
?><img src="img/line.png" height="29" width="419" />
<br/>

<font color="#cc5500" face="arial black,avant garde" size="3">
:<?php echo $Lang['serverinfo'];?>: <br/>
<?php echo $Config['ServerName'];?><br/>
<?php echo $Lang['rates'];?> - Exp:<?php echo $Config['Exp'];?> SP:<?php echo $Config['SP'];?> Adena:<?php echo $Config['Adena'];?> Items:<?php echo $Config['Items'];?> Spoil:<?php echo $Config['Spoil'];?> <br/>
<?php echo $Lang['events'];?>: <font color="green"><?php echo $Config['Events'];?></font><br />
<?php echo $Lang['addinfo'];?>: <font color="blue"><?php echo $Config['Features'];?></font><br />
<img src="img/line.png" height="29" width="419" /><br />

<br/>
<font color="#ff9900" face="arial black,avant garde" size="3"><?php echo $Lang['Desc'];?></font>
<hr />
<br/>
<a href="index.php?id=vote"><?php echo $Lang['vote_and_receive'];?></a>
<br />
<hr />
<script src="http://wos.lv/d.php?11603"></script>
<br />
<p>
<a href="http://jigsaw.w3.org/css-validator/validator?uri=l2.pvpland.lv&profile=css3&usermedium=all&warning=1&lang=<?php echo $langfile;?>" target="_blank">
<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="<?php echo $Lang['ValidCSS'];?>!" title="<?php echo $Lang['ValidCSS'];?>!" /></a>
</p>