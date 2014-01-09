<?php
    $skinurl = 'skins/high5';
if($foot){
    ?></div>
				</div>
                </div>
			<!--/content-->
			<!--right_part-->
			<div class="right_part">
				<div class="block">
					<div class="block_top">
					  <div class="block_bt">
                      <div class="title">Stats</div>
						<?php echo includeBlock('stats', 'Stats',0,'false');?>
						</div>
					</div>
				</div>
				<div class="block1">
					<div class="block_top">
						<div class="block_bt">
							<div class="title">Top 10</div>
						<?php echo includeBlock('top10', 'TOP 10',0,'false');
                        $timeparts = explode(" ",microtime());
$endtime = $timeparts[1].substr($timeparts[0],1);
                        ?>
						</div>
					</div>
				</div>
			<!--/right_part-->
				<div class="cl"></div>
			</div>
		<!--/main_content-->
		<!--footer-->
			<div id="footer">
				<div class="footer_logo_left"><img src="<?php echo $skinurl;?>/img/footer_logo_01.gif" alt="" height="17" width="83" /></div>
				<div class="footer_logo_right"><img src="<?php echo $skinurl;?>/img/footer_logo_02.gif" alt="" height="9" width="62" /></div>
				<div class="footer_center">
					<b>Lineage II</b> is a trademark of NCsoft Corporation. Copyright © <b>NCsoft Corporation</b>. All rights reserved.<br /><?php echo getConfig('head', 'CopyRight', '<a href="mailto:antons007@gmail.com">80MXM08</a> &copy; LineageII PvP Land'); ?><br /><?php echo sprintf($Lang['page_generated'], bcsub($endtime,$startTime,6), $sql->totalSqlTime, $sql->queryCount);?>
                    
			  </div>
				<div class="cl"></div>
			</div>
           
		</div>
         <?php } ?>
	</div>
<?php
if (getConfig('debug', 'sql', '0'))
    $sql->debug();
if (getConfig('debug', 'user', '0'))
    $user->debug();
?>

</body></html>