<?php
	include('top.php');
	/* Module access */
    if (!empty($user) and $user['admin'] != 1) {
    	$security->denied();
	}

	$playlistEdit = PlaylistEdit::create();

	if ($request->hasGetVar('playlist_id')) {
		$playlistEdit->setId($request->getGetVar('playlist_id'));
		$playlistEdit->prepare();
	}

	$playlistEdit->handler();
	$playlist_id = $playlistEdit->getId();
	$next_sort = $playlistEdit->getNextSort();
?>
	<div class="body">
		<div class="navi"><a href="playlist.php"><?php echo _('Playlists');?></a></div>
		<div class="navi_white"><a href="playlist_edit.php"><?php echo _('Create playlist');?></a></div>
		<div class="navi"><a href="playlist_zakaz.php"><?php echo _('Orders');?></a></div>
		<div class="navi"><a href="playlist_proverki.php"><?php echo _('Checks');?></a></div>
		<br><br>
		<div class="title"><?php echo _('Create and edit playlists');?></div>
		<form method="post" action="">
			<div class="border playlist_edit">
				<input type="hidden" name="playlist_id" value="<?php echo $playlist_id; ?>">
				<table border="0" width="97%" cellspacing="0" cellpadding="0" class="table1 tableaddedit">
				<tr>
					<td width="300">
						<?php echo _('Title');?><br>
						<div class="podpis"><?php echo _('playlist title on the main page');?></div>
					</td>
					<td width="70%">
						<input title="name" type="text" name="name" size="50" value="<?= $playlistEdit->getName() ? htmlspecialchars($playlistEdit->getName()) : _('New').' '.$next_sort ?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php echo _('Sort order');?><br>
						<div class="podpis"><?php echo _('with other playlists');?></div>
					</td>
					<td>
						<input title="sort" type="text" name="sort" size="11" value="<?= $playlistEdit->getSort() ? $playlistEdit->getSort() : $next_sort ?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php echo _('Enabled');?><br>
						<div class="podpis"><?php echo _('disable playlist without deletion');?></div>
					</td>
					<td>
						<input id="enable1" type="radio" value="1" name="enable" <?= $playlistEdit->isEnabled() ? 'checked' : '' ?>>
						<label for="enable1"><?php echo _('Yes');?></label>
						<input id="enable2" type="radio" value="0" name="enable" <?= $playlistEdit->isEnabled() ? '' : 'checked' ?>>
						<label for="enable2"><?php echo _('No');?></label>
					</td>
				</tr>
				<tr>
					<td>
						Allow orders<br>
						<div class="podpis"><?php echo _('allow to order songs during this playlist');?></div>
					</td>
					<td>
						<input id="allow_zakaz1" type="radio" value="1" name="allow_zakaz" <?= $playlistEdit->isAllowOrder() ? 'checked' : '' ?>>
						<label for="allow_zakaz1"><?php echo _('Yes');?></label>
						<input id="allow_zakaz2" type="radio" value="0" name="allow_zakaz" <?= $playlistEdit->isAllowOrder() ? '' : 'checked' ?>>
						<label for="allow_zakaz2"><?php echo _('No');?></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo _('Show on the main page');?><br>
						<div class="podpis"><?php echo _('show  tracks from this playlist on the main page');?></div>
					</td>
					<td>
						<input id="show1" type="radio" value="1" name="show" <?= $playlistEdit->isShow() ? 'checked' : '' ?>>
						<label for="show1"><?php echo _('Yes');?></label>
						<input id="show2" type="radio" value="0" name="show" <?= $playlistEdit->isShow() ? '' : 'checked' ?>>
						<label for="show2"><?php echo _('No');?></label>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo _('Play order');?><br>
						<div class="podpis"><?php echo _('Choose radomly to mix the order');?></div>
					</td>
					<td>
						<input id="playmode0" type="radio" value="0" name="playmode" <?= $playlistEdit->getPlaymode()==0 ? 'checked' : '' ?>>
						<label for="playmode0">По порядку</label>
						<input id="playmode1" type="radio" value="1" name="playmode" <?= $playlistEdit->getPlaymode()==1 ? 'checked' : '' ?>>
						<label for="playmode1">Случайно</label>
						<input id="playmode2" type="radio" value="2" name="playmode" <?= $playlistEdit->getPlaymode()==2 ? 'checked' : '' ?>>
						<label for="playmode2">Случайно один</label>
						<input id="i_program" onclick="prog_rasp();" type="radio" value="3" name="playmode" <?= $playlistEdit->getPlaymode()==3 ? 'checked' : '' ?>>
						<label for="i_program">Программа</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<input id="i_rasp" onclick="rasp_chasi();" type="radio" name="event" value="2" <?= $playlistEdit->isEvent2() ? 'checked' : '' ?>>
									<font size="2">
										<label for='i_rasp'>Воспроизводить по расписанию</label>
									</font>

<?php
	if ($playlistEdit->isEvent2()) {
?>
		<div id="rasp" style="display: block;">
<?php
	} else {
?>
		<div id="rasp" style="display: none;">
<?php
	}
?>

<?php
	$event2 = $playlistEdit->getEvent2();

	for ($i=0; $i<=2; $i++) {
		$event = $event2[$i];
?>
      <div id="event2_timeblock_<?=$i?>" style="<?=($i!=0 and empty($event['days']))?'display:none':''?>">
			<p>
				<input name="event2[<?=$i?>][days][Monday]" id="e2_<?=$i?>_1" type="checkbox" value="Monday" <?=!empty($event['days']['Monday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_1">Пн</label>

				<input name="event2[<?=$i?>][days][Tuesday]" id="e2_<?=$i?>_2" type="checkbox" value="Tuesday" <?=!empty($event['days']['Tuesday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_2">Вт</label>

				<input name="event2[<?=$i?>][days][Wednesday]" id="e2_<?=$i?>_3" type="checkbox" value="Wednesday" <?=!empty($event['days']['Wednesday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_3">Ср</label>

				<input name="event2[<?=$i?>][days][Thursday]" id="e2_<?=$i?>_4" type="checkbox" value="Thursday" <?=!empty($event['days']['Thursday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_4">Чт</label>

				<input name="event2[<?=$i?>][days][Friday]" id="e2_<?=$i?>_5" type="checkbox" value="Friday" <?=!empty($event['days']['Friday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_5">Пт</label>

				<input name="event2[<?=$i?>][days][Saturday]" id="e2_<?=$i?>_6" type="checkbox" value="Saturday" <?=!empty($event['days']['Saturday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_6">Сб</label>

				<input name="event2[<?=$i?>][days][Sunday]" id="e2_<?=$i?>_7" type="checkbox" value="Sunday" <?=!empty($event['days']['Sunday']) ? 'checked' : '' ?>>
				<label for="e2_<?=$i?>_7">Вс</label>
			</p>

			<select title="hours" size="1" name="event2[<?=$i?>][start1][h]">
				<option <?= $event['start1']['h'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start1']['h'] == '01' ? 'selected' : '' ?>>01</option>
				<option <?= $event['start1']['h'] == '02' ? 'selected' : '' ?>>02</option>
				<option <?= $event['start1']['h'] == '03' ? 'selected' : '' ?>>03</option>
				<option <?= $event['start1']['h'] == '04' ? 'selected' : '' ?>>04</option>
				<option <?= $event['start1']['h'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start1']['h'] == '06' ? 'selected' : '' ?>>06</option>
				<option <?= $event['start1']['h'] == '07' ? 'selected' : '' ?>>07</option>
				<option <?= $event['start1']['h'] == '08' ? 'selected' : '' ?>>08</option>
				<option <?= $event['start1']['h'] == '09' ? 'selected' : '' ?>>09</option>
				<option <?= $event['start1']['h'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start1']['h'] == '11' ? 'selected' : '' ?>>11</option>
				<option <?= $event['start1']['h'] == '12' ? 'selected' : '' ?>>12</option>
				<option <?= $event['start1']['h'] == '13' ? 'selected' : '' ?>>13</option>
				<option <?= $event['start1']['h'] == '14' ? 'selected' : '' ?>>14</option>
				<option <?= $event['start1']['h'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start1']['h'] == '16' ? 'selected' : '' ?>>16</option>
				<option <?= $event['start1']['h'] == '17' ? 'selected' : '' ?>>17</option>
				<option <?= $event['start1']['h'] == '18' ? 'selected' : '' ?>>18</option>
				<option <?= $event['start1']['h'] == '19' ? 'selected' : '' ?>>19</option>
				<option <?= $event['start1']['h'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start1']['h'] == '21' ? 'selected' : '' ?>>21</option>
				<option <?= $event['start1']['h'] == '22' ? 'selected' : '' ?>>22</option>
				<option <?= $event['start1']['h'] == '23' ? 'selected' : '' ?>>23</option>
			</select>
			:
			<select title="minutes" size="1" name="event2[<?=$i?>][start1][m]">
				<option <?= $event['start1']['m'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start1']['m'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start1']['m'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start1']['m'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start1']['m'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start1']['m'] == '25' ? 'selected' : '' ?>>25</option>
				<option <?= $event['start1']['m'] == '30' ? 'selected' : '' ?>>30</option>
				<option <?= $event['start1']['m'] == '35' ? 'selected' : '' ?>>35</option>
				<option <?= $event['start1']['m'] == '40' ? 'selected' : '' ?>>40</option>
				<option <?= $event['start1']['m'] == '45' ? 'selected' : '' ?>>45</option>
				<option <?= $event['start1']['m'] == '50' ? 'selected' : '' ?>>50</option>
				<option <?= $event['start1']['m'] == '55' ? 'selected' : '' ?>>55</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<select title="hours end" size="1" name="event2[<?=$i?>][start2][h]">
				<option <?= $event['start2']['h'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start2']['h'] == '01' ? 'selected' : '' ?>>01</option>
				<option <?= $event['start2']['h'] == '02' ? 'selected' : '' ?>>02</option>
				<option <?= $event['start2']['h'] == '03' ? 'selected' : '' ?>>03</option>
				<option <?= $event['start2']['h'] == '04' ? 'selected' : '' ?>>04</option>
				<option <?= $event['start2']['h'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start2']['h'] == '06' ? 'selected' : '' ?>>06</option>
				<option <?= $event['start2']['h'] == '07' ? 'selected' : '' ?>>07</option>
				<option <?= $event['start2']['h'] == '08' ? 'selected' : '' ?>>08</option>
				<option <?= $event['start2']['h'] == '09' ? 'selected' : '' ?>>09</option>
				<option <?= $event['start2']['h'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start2']['h'] == '11' ? 'selected' : '' ?>>11</option>
				<option <?= $event['start2']['h'] == '12' ? 'selected' : '' ?>>12</option>
				<option <?= $event['start2']['h'] == '13' ? 'selected' : '' ?>>13</option>
				<option <?= $event['start2']['h'] == '14' ? 'selected' : '' ?>>14</option>
				<option <?= $event['start2']['h'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start2']['h'] == '16' ? 'selected' : '' ?>>16</option>
				<option <?= $event['start2']['h'] == '17' ? 'selected' : '' ?>>17</option>
				<option <?= $event['start2']['h'] == '18' ? 'selected' : '' ?>>18</option>
				<option <?= $event['start2']['h'] == '19' ? 'selected' : '' ?>>19</option>
				<option <?= $event['start2']['h'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start2']['h'] == '21' ? 'selected' : '' ?>>21</option>
				<option <?= $event['start2']['h'] == '22' ? 'selected' : '' ?>>22</option>
				<option <?= $event['start2']['h'] == '23' ? 'selected' : '' ?>>23</option>
			</select>
			:
			<select title="minutes end" size="1" name="event2[<?=$i?>][start2][m]">
				<option <?= $event['start2']['m'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start2']['m'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start2']['m'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start2']['m'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start2']['m'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start2']['m'] == '25' ? 'selected' : '' ?>>25</option>
				<option <?= $event['start2']['m'] == '30' ? 'selected' : '' ?>>30</option>
				<option <?= $event['start2']['m'] == '35' ? 'selected' : '' ?>>35</option>
				<option <?= $event['start2']['m'] == '40' ? 'selected' : '' ?>>40</option>
				<option <?= $event['start2']['m'] == '45' ? 'selected' : '' ?>>45</option>
				<option <?= $event['start2']['m'] == '50' ? 'selected' : '' ?>>50</option>
				<option <?= $event['start2']['m'] == '55' ? 'selected' : '' ?>>55</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<select title="hours2" size="1" name="event2[<?=$i?>][start3][h]">
				<option <?= $event['start3']['h'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start3']['h'] == '01' ? 'selected' : '' ?>>01</option>
				<option <?= $event['start3']['h'] == '02' ? 'selected' : '' ?>>02</option>
				<option <?= $event['start3']['h'] == '03' ? 'selected' : '' ?>>03</option>
				<option <?= $event['start3']['h'] == '04' ? 'selected' : '' ?>>04</option>
				<option <?= $event['start3']['h'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start3']['h'] == '06' ? 'selected' : '' ?>>06</option>
				<option <?= $event['start3']['h'] == '07' ? 'selected' : '' ?>>07</option>
				<option <?= $event['start3']['h'] == '08' ? 'selected' : '' ?>>08</option>
				<option <?= $event['start3']['h'] == '09' ? 'selected' : '' ?>>09</option>
				<option <?= $event['start3']['h'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start3']['h'] == '11' ? 'selected' : '' ?>>11</option>
				<option <?= $event['start3']['h'] == '12' ? 'selected' : '' ?>>12</option>
				<option <?= $event['start3']['h'] == '13' ? 'selected' : '' ?>>13</option>
				<option <?= $event['start3']['h'] == '14' ? 'selected' : '' ?>>14</option>
				<option <?= $event['start3']['h'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start3']['h'] == '16' ? 'selected' : '' ?>>16</option>
				<option <?= $event['start3']['h'] == '17' ? 'selected' : '' ?>>17</option>
				<option <?= $event['start3']['h'] == '18' ? 'selected' : '' ?>>18</option>
				<option <?= $event['start3']['h'] == '19' ? 'selected' : '' ?>>19</option>
				<option <?= $event['start3']['h'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start3']['h'] == '21' ? 'selected' : '' ?>>21</option>
				<option <?= $event['start3']['h'] == '22' ? 'selected' : '' ?>>22</option>
				<option <?= $event['start3']['h'] == '23' ? 'selected' : '' ?>>23</option>
			</select>
			:
			<select title="minutes2" size="1" name="event2[<?=$i?>][start3][m]">
				<option <?= $event['start3']['m'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start3']['m'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start3']['m'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start3']['m'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start3']['m'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start3']['m'] == '25' ? 'selected' : '' ?>>25</option>
				<option <?= $event['start3']['m'] == '30' ? 'selected' : '' ?>>30</option>
				<option <?= $event['start3']['m'] == '35' ? 'selected' : '' ?>>35</option>
				<option <?= $event['start3']['m'] == '40' ? 'selected' : '' ?>>40</option>
				<option <?= $event['start3']['m'] == '45' ? 'selected' : '' ?>>45</option>
				<option <?= $event['start3']['m'] == '50' ? 'selected' : '' ?>>50</option>
				<option <?= $event['start3']['m'] == '55' ? 'selected' : '' ?>>55</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="event2_button_<?=$i?>" onclick="pokazat('event2', <?=$i+1?>);" type="button" value="+" style="width:25px;">
		</div>
<?php
	}
?>
	</div>
									</td>
								</tr>
							</table>
							<br />
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<input id="i_chasi" onclick="rasp_chasi();" type="radio" name="event" value="1" <?= $playlistEdit->isEvent1() ? 'checked' : '' ?>>
										<div style="font-size:2px">
											<label for='i_chasi'><?php echo _('Play after some time');?></label>
										</div>
<?php
	if($playlistEdit->isEvent1()) {
?>
		<div id="chasi" style="display: block;">
<?php
	} else {
?>
		<div id="chasi" style="display: none;">
<?php
	}
?>
		<br>
<?php
	$event1 = $playlistEdit->getEvent1();

	for ($i=0; $i<=2; $i++) {
		$event = $event1[$i];
?>
		<div id="event1_timeblock_<?=$i?>" style="<?=($i!=0 and empty($event['days']))?'display:none':''?>">
			<p>
				<input name="event1[<?=$i?>][days][Monday]" id="e1_<?=$i?>_1" type="checkbox" value="Monday" <?=!empty($event['days']['Monday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_1">Пн</label>

				<input name="event1[<?=$i?>][days][Tuesday]" id="e1_<?=$i?>_2" type="checkbox" value="Tuesday" <?=!empty($event['days']['Tuesday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_2">Вт</label>

				<input name="event1[<?=$i?>][days][Wednesday]" id="e1_<?=$i?>_3" type="checkbox" value="Wednesday" <?=!empty($event['days']['Wednesday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_3">Ср</label>

				<input name="event1[<?=$i?>][days][Thursday]" id="e1_<?=$i?>_4" type="checkbox" value="Thursday" <?=!empty($event['days']['Thursday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_4">Чт</label>

				<input name="event1[<?=$i?>][days][Friday]" id="e1_<?=$i?>_5" type="checkbox" value="Friday" <?=!empty($event['days']['Friday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_5">Пт</label>

				<input name="event1[<?=$i?>][days][Saturday]" id="e1_<?=$i?>_6" type="checkbox" value="Saturday" <?=!empty($event['days']['Saturday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_6">Сб</label>

				<input name="event1[<?=$i?>][days][Sunday]" id="e1_<?=$i?>_7" type="checkbox" value="Sunday" <?=!empty($event['days']['Sunday']) ? 'checked' : '' ?>>
				<label for="e1_<?=$i?>_7">Вс</label>
			</p>

			с
			<select title="hours" size="1" name="event1[<?=$i?>][start][h]">
				<option <?= $event['start']['h'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start']['h'] == '01' ? 'selected' : '' ?>>01</option>
				<option <?= $event['start']['h'] == '02' ? 'selected' : '' ?>>02</option>
				<option <?= $event['start']['h'] == '03' ? 'selected' : '' ?>>03</option>
				<option <?= $event['start']['h'] == '04' ? 'selected' : '' ?>>04</option>
				<option <?= $event['start']['h'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start']['h'] == '06' ? 'selected' : '' ?>>06</option>
				<option <?= $event['start']['h'] == '07' ? 'selected' : '' ?>>07</option>
				<option <?= $event['start']['h'] == '08' ? 'selected' : '' ?>>08</option>
				<option <?= $event['start']['h'] == '09' ? 'selected' : '' ?>>09</option>
				<option <?= $event['start']['h'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start']['h'] == '11' ? 'selected' : '' ?>>11</option>
				<option <?= $event['start']['h'] == '12' ? 'selected' : '' ?>>12</option>
				<option <?= $event['start']['h'] == '13' ? 'selected' : '' ?>>13</option>
				<option <?= $event['start']['h'] == '14' ? 'selected' : '' ?>>14</option>
				<option <?= $event['start']['h'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start']['h'] == '16' ? 'selected' : '' ?>>16</option>
				<option <?= $event['start']['h'] == '17' ? 'selected' : '' ?>>17</option>
				<option <?= $event['start']['h'] == '18' ? 'selected' : '' ?>>18</option>
				<option <?= $event['start']['h'] == '19' ? 'selected' : '' ?>>19</option>
				<option <?= $event['start']['h'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start']['h'] == '21' ? 'selected' : '' ?>>21</option>
				<option <?= $event['start']['h'] == '22' ? 'selected' : '' ?>>22</option>
				<option <?= $event['start']['h'] == '23' ? 'selected' : '' ?>>23</option>
			</select>
			:
			<select title="minutes" size="1" name="event1[<?=$i?>][start][m]">
				<option <?= $event['start']['m'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['start']['m'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['start']['m'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['start']['m'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['start']['m'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['start']['m'] == '25' ? 'selected' : '' ?>>25</option>
				<option <?= $event['start']['m'] == '30' ? 'selected' : '' ?>>30</option>
				<option <?= $event['start']['m'] == '35' ? 'selected' : '' ?>>35</option>
				<option <?= $event['start']['m'] == '40' ? 'selected' : '' ?>>40</option>
				<option <?= $event['start']['m'] == '45' ? 'selected' : '' ?>>45</option>
				<option <?= $event['start']['m'] == '50' ? 'selected' : '' ?>>50</option>
				<option <?= $event['start']['m'] == '55' ? 'selected' : '' ?>>55</option>
			</select>
			&nbsp;&nbsp;до&nbsp;&nbsp;
			<select title="hours" size="1" name="event1[<?=$i?>][end][h]">
				<option <?= $event['end']['h'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['end']['h'] == '01' ? 'selected' : '' ?>>01</option>
				<option <?= $event['end']['h'] == '02' ? 'selected' : '' ?>>02</option>
				<option <?= $event['end']['h'] == '03' ? 'selected' : '' ?>>03</option>
				<option <?= $event['end']['h'] == '04' ? 'selected' : '' ?>>04</option>
				<option <?= $event['end']['h'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['end']['h'] == '06' ? 'selected' : '' ?>>06</option>
				<option <?= $event['end']['h'] == '07' ? 'selected' : '' ?>>07</option>
				<option <?= $event['end']['h'] == '08' ? 'selected' : '' ?>>08</option>
				<option <?= $event['end']['h'] == '09' ? 'selected' : '' ?>>09</option>
				<option <?= $event['end']['h'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['end']['h'] == '11' ? 'selected' : '' ?>>11</option>
				<option <?= $event['end']['h'] == '12' ? 'selected' : '' ?>>12</option>
				<option <?= $event['end']['h'] == '13' ? 'selected' : '' ?>>13</option>
				<option <?= $event['end']['h'] == '14' ? 'selected' : '' ?>>14</option>
				<option <?= $event['end']['h'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['end']['h'] == '16' ? 'selected' : '' ?>>16</option>
				<option <?= $event['end']['h'] == '17' ? 'selected' : '' ?>>17</option>
				<option <?= $event['end']['h'] == '18' ? 'selected' : '' ?>>18</option>
				<option <?= $event['end']['h'] == '19' ? 'selected' : '' ?>>19</option>
				<option <?= $event['end']['h'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['end']['h'] == '21' ? 'selected' : '' ?>>21</option>
				<option <?= $event['end']['h'] == '22' ? 'selected' : '' ?>>22</option>
				<option <?= $event['end']['h'] == '23' ? 'selected' : '' ?>>23</option>
			</select>
			:
			<select title="minutes" size="1" name="event1[<?=$i?>][end][m]">
				<option <?= $event['end']['m'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['end']['m'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['end']['m'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['end']['m'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['end']['m'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['end']['m'] == '25' ? 'selected' : '' ?>>25</option>
				<option <?= $event['end']['m'] == '30' ? 'selected' : '' ?>>30</option>
				<option <?= $event['end']['m'] == '35' ? 'selected' : '' ?>>35</option>
				<option <?= $event['end']['m'] == '40' ? 'selected' : '' ?>>40</option>
				<option <?= $event['end']['m'] == '45' ? 'selected' : '' ?>>45</option>
				<option <?= $event['end']['m'] == '50' ? 'selected' : '' ?>>50</option>
				<option <?= $event['end']['m'] == '55' ? 'selected' : '' ?>>55</option>
			</select>
	        &nbsp;&nbsp;каждые&nbsp;&nbsp;
	        <select title="hours" size="1" name="event1[<?=$i?>][interval][h]">
				<option <?= $event['interval']['h'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['interval']['h'] == '01' ? 'selected' : '' ?>>01</option>
				<option <?= $event['interval']['h'] == '02' ? 'selected' : '' ?>>02</option>
				<option <?= $event['interval']['h'] == '03' ? 'selected' : '' ?>>03</option>
				<option <?= $event['interval']['h'] == '04' ? 'selected' : '' ?>>04</option>
				<option <?= $event['interval']['h'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['interval']['h'] == '06' ? 'selected' : '' ?>>06</option>
				<option <?= $event['interval']['h'] == '07' ? 'selected' : '' ?>>07</option>
				<option <?= $event['interval']['h'] == '08' ? 'selected' : '' ?>>08</option>
				<option <?= $event['interval']['h'] == '09' ? 'selected' : '' ?>>09</option>
				<option <?= $event['interval']['h'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['interval']['h'] == '11' ? 'selected' : '' ?>>11</option>
				<option <?= $event['interval']['h'] == '12' ? 'selected' : '' ?>>12</option>
				<option <?= $event['interval']['h'] == '13' ? 'selected' : '' ?>>13</option>
				<option <?= $event['interval']['h'] == '14' ? 'selected' : '' ?>>14</option>
				<option <?= $event['interval']['h'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['interval']['h'] == '16' ? 'selected' : '' ?>>16</option>
				<option <?= $event['interval']['h'] == '17' ? 'selected' : '' ?>>17</option>
				<option <?= $event['interval']['h'] == '18' ? 'selected' : '' ?>>18</option>
				<option <?= $event['interval']['h'] == '19' ? 'selected' : '' ?>>19</option>
				<option <?= $event['interval']['h'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['interval']['h'] == '21' ? 'selected' : '' ?>>21</option>
				<option <?= $event['interval']['h'] == '22' ? 'selected' : '' ?>>22</option>
				<option <?= $event['interval']['h'] == '23' ? 'selected' : '' ?>>23</option>
			</select>
			:
			<select title="minutes" size="1" name="event1[<?=$i?>][interval][m]">
				<option <?= $event['interval']['m'] == '00' ? 'selected' : '' ?>>00</option>
				<option <?= $event['interval']['m'] == '05' ? 'selected' : '' ?>>05</option>
				<option <?= $event['interval']['m'] == '10' ? 'selected' : '' ?>>10</option>
				<option <?= $event['interval']['m'] == '15' ? 'selected' : '' ?>>15</option>
				<option <?= $event['interval']['m'] == '20' ? 'selected' : '' ?>>20</option>
				<option <?= $event['interval']['m'] == '25' ? 'selected' : '' ?>>25</option>
				<option <?= $event['interval']['m'] == '30' ? 'selected' : '' ?>>30</option>
				<option <?= $event['interval']['m'] == '35' ? 'selected' : '' ?>>35</option>
				<option <?= $event['interval']['m'] == '40' ? 'selected' : '' ?>>40</option>
				<option <?= $event['interval']['m'] == '45' ? 'selected' : '' ?>>45</option>
				<option <?= $event['interval']['m'] == '50' ? 'selected' : '' ?>>50</option>
				<option <?= $event['interval']['m'] == '55' ? 'selected' : '' ?>>55</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
<?php
		if ($i < 2) {
?>
			<input id="event1_button_<?=$i?>" onclick="pokazat('event1', <?=$i+1?>);" type="button" value="+" style="width:25px;">
<?php
		}
?>
		</div>
<?php
	}
?>
									&nbsp;&nbsp;
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br>
				<input class="button" type="button" value=<?php echo _('Back');?> name="back" onClick="location.href='playlist.php'" />
				<input class="button" type="submit" value="<?php echo _('Save');?>" name="submit">
				<input class="button" type="submit" value=<?php echo _('Save and add tracks');?> name="submit_and_add">
			</div>
		</form>
	</div>
<?php
    include('Tpl/footer.tpl.html');
?>  	