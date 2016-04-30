<?php
	include('top.php');
	/* Module access */
    if (!empty($user) and $user['admin'] != 1) {
    	$security->denied();
	}

	$song = Song::create();
	$meneger = Meneger::create();
	$start = $meneger->getStart();
	$playlist_id_get = $meneger->getPlaylistId();
	$fold = $meneger->getFold();
	$search = $meneger->getSearch();

	$in = 0;
	$i = 0;
	$ipr = 0;
	$ipk = 0;
	$ips = 0;

	$dirct = $meneger->getDirct();
	$dirct2 = $meneger->getDirct2();
    $back = $meneger->getBack();
    $begin = $meneger->getBegin();

	$dirct_f = str_replace(" ", "%20", $dirct);
echo '
	<div class="body">
		<br>
		<div class="title">';

	if (!empty($playlist_id_get)) {

echo _('Добавление файлов в'). $meneger->getPlaylistName($playlist_id_get). $dirct2;
	} else {
		echo _('Файловый менеджер'). $dirct2;
	}
?>
		</div>
	<div class="border">
		<form name='fman' action='meneger_zapros.php?folder=<?=$dirct_f?>&start=<?=$start?>&search=<?=$search?>' method='POST'>
		<table border=0 cellspacing="0" cellpadding="0" width="97%" class="table1">
			<tr>
				<td width=25>Выб.</td>
				<td>Имя файла</td>
				<td width=80% align="right">
<?php
	if ($dirct!=$begin) {
					echo '<b><a href="meneger.php?fold=<?=$back?>&playlist_id=<?=$playlist_id_get?>">'._('Came back').'</a></b>';
	}
?>
				</td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" width="97%" class="table1">
<?php
	$list = $meneger->getList();
	foreach ($list['list'] as $k) {

    	if ($i == 0) {
    		$bg = " bgcolor='#F5F4F7'";
   	 	} else {
    		$bg = "";
    	}

    	if ($in == 0) {
?>
			<tr <?=$bg?>>
<?php
    	}

		$full = $dirct."/".$k;
		$k_size = $meneger->getFilesize($full);

    	if (is_dir($full) === true) {
?>
				<td width="25" valign="top">
					<span style='display: none;' id=t_"<?=$ipr?>"></span>
					<span style='display: none;' id=t2_"<?=$ipr?>"></span>
<?php
    	$kp = urlencode($k);
    	if (!empty($playlist_id_get)) {
?>
					<a href="add_tracks.php?start=<?=$start?>&search=<?=$search?>&add_directory=<?=urlencode($full)?>&playlist_id=<?=$playlist_id_get?>">
    					<img src="images/plus.gif" width="16" height="16" border="0" title="<?php echo ('Add folder to playlist');?>">
    				</a>
<?php
    	} else {
?>
					<input id="<?=$ipr?>" name="fl[]" value="<?=$kp?>" type="checkbox">
<?php
    	}

?>
				</td>
<?php
    	} else {
	   		if ($ipk > 2) {
	    		$cvet = "white";
	    	} else {
	    		$cvet = "#F5F4F7";
	    	}
?>
				<td width="25" valign="top" id="t2_<?=$ipr?>">
<?php

	    	$kp = urlencode($k);
	        if ($dirct2 == "/music") {
	            if ($meneger->isMp3($k)) {
	    			if (!empty($playlist_id_get)) {
?>
	    				<img src="images/delete2.gif" width="16" height="16" border="0" title="<?php echo _('You need to move this song to any folder for adding it to playlist');?>">
<?php
	    			} else {
?>
						<input id="<?=$ipr?>" name="fl[]" value="<?=$kp?>" type="checkbox" onclick="iprClick('<?=$ipr?>', '<?=$cvet?>')">
<?php
	    			}
	    		} else {
	                if (!empty($playlist_id_get)) {
	    			echo ('<img src="images/delete2.gif" width="16" height="16" border="0" title="'._('It is not the mp3-file').'">');
	    			} else {
?>
	    				<input id="<?=$ipr?>" name="fl[]" value="<?=$kp?>" type="checkbox" onclick="iprClick('<?=$ipr?>', '<?=$cvet?>')">
<?php
	    			}
	    		}


	        } else {
	        	if ($meneger->isMp3($k)) {
	    			if (!empty($playlist_id_get)) {
?>
						<a href="add_tracks.php?start=<?=$start?>&search=<?=$search?>&filename=<?=urlencode($full)?>&playlist_id=<?=$playlist_id_get?>">
	    					<img src="images/plus.gif" width="16" height="16" border="0" title="<?php echo_('Add song to the playlist');?>">
	    				</a>
<?php
	    			} else {
?>
						<input id="<?=$ipr?>" name="fl[]" value="<?=$kp?>" type="checkbox" onclick="iprClick('<?=$ipr?>', '<?=$cvet?>')">
<?php
	    			}

	        	} else {
	            	if (!empty($playlist_id_get)) {
                        echo ('<img src="images/delete2.gif" width="16" height="16" border="0" title="'._('It is not the mp3-file').'">');
	    			} else {
?>
						<input id="<?=$ipr?>" name="fl[]" value="<?=$kp?>" type="checkbox" onclick="iprClick('<?=$ipr?>', '<?=$cvet?>')">
<?php
	    			}
	    		}
	    	}
?>
				</td>
<?php
		}

  		$playlist_name = $meneger->getUseIn($full);

    	$old_k = $k;
   		$k = wordwrap($k, 30, "\n", 1);
    	if (is_dir($full) === true) {
       		$full = str_replace(" ", "%20", $full);
?>
				<td width=31% valign=top>
<?php
			if (!empty($playlist_id_get)) {
?>
					<img src="images/m_folder.gif" border="0" width="13" height="11">
					<a href="meneger.php?fold=<?=$full?>&playlist_id=<?=$playlist_id_get?>"><b><?=$k?></b></a>
					<br><div class="podpis">Папка номер <?=$ips?></div>
<?php
			} else {
?>
					<img src="images/m_folder.gif" border="0" width="13" height="11">
					<a href="meneger.php?fold=<?=$full?>"><b><?=$k?></b></a>
					<br><div class="podpis">Папка номер <?=$ips+1?></div>
<?php
			}
?>
				</td>
<?php
     	} else {
?>
				<td id="t_<?=$ipr?>" width="31%" valign="top">
					<label for="<?=$ipr?>"><div><img src="images/m_file.png" border="0" width="9" height="12"> <?=$k?></div><div class=podpis><?php echo _('File number');?> <?=$ips+1?> (<?=$k_size?>)</div></label>
<?php
				if ($meneger->isTempUpload($full)) {
					$afl = $song->getPlayerPath($full);
                    if ($meneger->isMp3($old_k)) {
?>
						<div class="podpis">
							<div style="height: 20px; margin-top: 3px;">
	      						<span id="play_<?=$ipr?>">
	      							<a href="javascript: playmedia(<?=$ipr?>,'<?=$afl?>');"><img width="16" height="16" border="0" src="/radio/images/play.gif"></a>&nbsp;
	      							<span onclick="playmedia(<?=$ipr?>,'<?=$afl?>');" style="cursor: pointer;position: absolute;margin-top: 2px;">
	      								<?php echo _('listen'); ?>
	      							</span>&nbsp;
	      						</span>
	      					</div>
	      				</div>
<?php
					}
      			} else {

					if (!$playlist_name) {
echo '<div class="podpis"><font color="#993333">'._('Not used!').'</font></div>';

					} else {
          	  	echo'<div class="podpis"><font color="#669999">'._('Used in'). '<i>'.$playlist_name.'</i></font></div>';
					}
				}
				echo '</td>';
     	}
        $ipr = $ipr+1;
        $ips = $ips+1;
    	if ($i == 1) {
    		$i = 0;
    	} else {
    		$i++;
    	}
    	if ($in == 2) {
?>
    		</tr>
<?php
    	}
		if ($in == 2) {
    	 	$in = 0;
    	} else {
    		$in++;
    	}
		if ($ipk == 5) {
			$ipk = 0;
		} else {
			$ipk++;;
		}
	}
?>
			<tr>
				<td width=25></td><td width=31%></td>
				<td width=25></td><td width=31%></td>
				<td width=25></td><td width=31% align=right></td>
			</tr>
		</table>
 		<br>
		<table border="0" cellspacing="0" cellpadding="0" width="97%" class="table1">
			<tr>
				<td width="50%">
<?php
	$fold = str_replace(" ","%20",$fold);
	$a2ostalos = $list['vsego']-$list['start'];
	$posl = (int)($list['vsego']/$list['limit']);
	$posl = $posl*$list['limit'];

	if (empty($playlist_id_get)) {
?>
					<label for="se_all">Выбрать всё</label>&nbsp;&nbsp;<input type="checkbox" name="se_all" id="se_all" onClick="s_all(this);">&nbsp;&nbsp;&nbsp;
<?php
	}
	if (!empty($search) ) {
					echo '<a href="?start=0&fold=<?=$fold?>&playlist_id=<?=$playlist_id_get?>">'._('Drop search').'</a>';
	}

   	if ( !empty($search) and (($list['vsego'] > $list['limit']) and ($list['start'] != 0) or ($list['vsego'] > $list['limit']) and ($a2ostalos >= $list['limit'])) ) {
   		echo " | ";
   	}

	if ( ($list['vsego'] > $list['limit']) and ($list['start'] != 0) ) {
    	$a2prev = $list['start']-$list['limit'];
?>
					<a href="?start=<?=$a2prev?>&search=<?=$search?>&fold=<?=$fold?>&playlist_id=<?=$playlist_id_get?>"><?php echo _('Back');?></a>
<?php
	}


	if ( ($list['vsego'] > $list['limit']) and ($a2ostalos >= $list['limit']) and ($list['vsego'] > $list['limit']) and ($list['start'] != 0) ) {
		echo " | ";
	}

	if ( ($list['vsego'] > $list['limit']) and ($a2ostalos >= $list['limit']) ) {
    	$a2next = $list['start']+$list['limit'];
?>
					<a href="?start=<?=$a2next?>&search=<?=$search?>&fold=<?=$fold?>&playlist_id=<?=$playlist_id_get?>"><?php echo _('Туче');?></a>
<?php
	}

	if ($a2ostalos <= $list['limit']) {
		$list['end'] = $list['start']+$a2ostalos;
	}
	$list['start'] = $list['start']+1;
?>
				</td>
				<td width="50%" valign="top" align="right">
                    <?php echo _('Showed:');?> <b><?=$list['start']?>-<?=$list['end']?></b>. <?php echo _('Files total');?>: <b><?=$list['vsego']?></b>.
				</td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" width="97%" class="table1">
			<tr>
				<td width="100">
<?php
	if (!empty($playlist_id_get)) {
?>
					<input class="button" type="button" value="<?php echo _('Finish addition');?>" name="back" onClick="location.href='playlist_view.php?playlist_id=<?=$playlist_id_get?>'">
<?php
	} else {
?>
					<input type=image src="images/m_new_folder.png" width="32" height="32" title="<?php echo _('Create folder');?>" name="md">
					<input type="hidden" name="md" value="md">
				</td>
				<td width="100">
					<input type=image src="images/m_copy_file.png" title="<?php echo _('Copy');?>" width="32" height="32" name="copy">
					<input type="hidden" name="copy" value="copy">
				</td>
				<td width="100">
					<input type=image src="images/m_move.png" title="<?php echo _('Move');?>" width="32" height="32" name="move">
					<input type="hidden" name="move" value="move">
				</td>
				<td width="100">
					<input type=image src="images/m_rename.png" title="<?php echo _('Rename');?>" width="32" height="32" name="ren">
					<input type="hidden" name="ren" value="ren">
				</td>
				<td width="100">
					<input type=image src="images/m_del.png" title="<?php echo _('Delete');?>" width="32" height="32" name="udal">
					<input type="hidden" name="udal" value="udal">
<?php
	}
?>
				</td>
				<td width="80%" valign="top" align="right">
				</td>
			</tr>
		</table>
		</form>
		<table border="0" cellspacing="0" cellpadding="0" width="97%" class="table1">
			<tr>
				<td width="20%">&nbsp;</td>
				<td width="80%" valign="top" align="right">
					<div class="searcht">
						<form action='meneger_zapros.php?folder=<?=$dirct_f?>&start=<?=$start?>&playlist_id=<?=$playlist_id_get?>' method='post'>
                            <?php echo _('Search in this folder');?> <input type="text" name="search" size="20" value="<?=$search?>">
							<input type="submit" value="<?php echo _('Find');?>" name="search_button">
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div>
	</div>
<?php
    include('Tpl/footer.tpl.html');
?>  	