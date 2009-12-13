                    </td>
                    <td class="head_right_border"></td>
                </tr>
                <tr>
                    <td class="bottom_left_corner"></td>
                    <td class="bottom_center" width="567"></td>
                    <td class="bottom_right_corner"></td>
                </tr>
            </table>
        </td>
        <td align="center" valign="top">
								<?php
                                //пароль
								includeBlock('stats', $Lang['stats'], true);
								includeBlock('top10', $Lang['top10'], true);
                                
								?>
        </td>
    </tr>
						
					</table>
				</td>
			</tr>
			<tr align="center" valign="top">
			 <td align="center" valign="middle"><?php echo $Config['CopyRight']; ?></td>
			</tr>
		</table>
</body>
</html>