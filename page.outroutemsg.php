<?php /* $Id: page.outroutemsg.php  $ */
//Copyright (C) 2009 Philippe Lindheimer 
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation version 2
//of the License.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

define (DEFAULT_MSG, -1);
define (CONGESTION_TONE, -2);

$dispnum = 'outroutemsg'; //used for switch on config.php
$tabindex = 0;

$action  = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$type  = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'tool';
$tresults = recordings_list();

// do if we are submitting a form
if($action){
	$default_msg_id      = isset($_REQUEST['default_msg_id'])      ? trim($_REQUEST['default_msg_id'])      : DEFAULT_MSG;
	$intracompany_msg_id = isset($_REQUEST['intracompany_msg_id']) ? trim($_REQUEST['intracompany_msg_id']) : DEFAULT_MSG;
	$emergency_msg_id    = isset($_REQUEST['emergency_msg_id'])    ? trim($_REQUEST['emergency_msg_id'])    : DEFAULT_MSG;

	if ($action == 'submit') {
		outroutemsg_add($default_msg_id, $intracompany_msg_id, $emergency_msg_id);
		needreload();
	}
}
?>
</div>
<div class="content">
<?php

// get the outroutemsg settings if not a submit
//
if ($action != 'submit') {
	$outroutemsg_settings = outroutemsg_get();
	$default_msg_id      = $outroutemsg_settings['default_msg_id'];
	$intracompany_msg_id = $outroutemsg_settings['intracompany_msg_id'];
	$emergency_msg_id    = $outroutemsg_settings['emergency_msg_id'];
}

?>
<h2><?php echo _("Route Congestion Messages")?></h2>
<form name="outroutemsg" action="config.php" method="post">
<input type="hidden" name="display" value="<?php echo $dispnum ?>"/>
<input type="hidden" name="action" value="submit"/>
<table>
<tr><td colspan="2"><h5><?php echo _("Congested Route Options")?><hr></h5></td></tr>

<tr><td colspan="2"><br><h5><?php echo _("Standard Routes")?><hr></h5></td></tr>
<tr>
	<td><a href="#" class="info"><?php echo _("Message or Tone")?><span><?php echo _("Message or tone to be played if no trunks are available.")?></span></a></td>
	<td align=right>
		<select name="default_msg_id" id="default_msg_id" tabindex="<?php echo ++$tabindex;?>">
		<?php
			echo '<option value="'.DEFAULT_MSG.'"'.(DEFAULT_MSG == $default_msg_id ? ' SELECTED' : '').'>'._("Default Message")."</option>\n";
			echo '<option value="'.CONGESTION_TONE.'"'.(CONGESTION_TONE == $default_msg_id ? ' SELECTED' : '').'>'._("Congestion Tones")."</option>\n";
			if (isset($tresults[0])) {
				foreach ($tresults as $tresult) {
					echo '<option value="'.$tresult['id'].'"'.($tresult['id'] == $default_msg_id ? ' SELECTED' : '').'>'.$tresult['displayname']."</option>\n";
				}
			}
		?>
		</select>
	</td>
</tr>

<tr><td colspan="2"><br><h5><?php echo _("Intra-Company Routes")?><hr></h5></td></tr>
<tr>
	<td><a href="#" class="info"><?php echo _("Message or Tone")?><span><?php echo _("Message or tone to be played if no trunks are available. Used on routes marked as intra-company only.")?></span></a></td>
	<td align=right>
		<select name="intracompany_msg_id" id="intracompany_msg_id" tabindex="<?php echo ++$tabindex;?>">
		<?php
			echo '<option value="'.DEFAULT_MSG.'"'.(DEFAULT_MSG == $intracompany_msg_id ? ' SELECTED' : '').'>'._("Default Message")."</option>\n";
			echo '<option value="'.CONGESTION_TONE.'"'.(CONGESTION_TONE == $intracompany_msg_id ? ' SELECTED' : '').'>'._("Congestion Tones")."</option>\n";
			if (isset($tresults[0])) {
				foreach ($tresults as $tresult) {
					echo '<option value="'.$tresult['id'].'"'.($tresult['id'] == $intracompany_msg_id ? ' SELECTED' : '').'>'.$tresult['displayname']."</option>\n";
				}
			}
		?>
		</select>
	</td>
</tr>

<tr><td colspan="2"><br><h5><?php echo _("Emergency Routes")?><hr></h5></td></tr>
<tr>
	<td><a href="#" class="info"><?php echo _("Message or Tone")?><span><?php echo _("Message or tone to be played if no trunks are available. Used on all emergency routes. Consider a message instructing callers to find an alternative means of calling emergency services such as a cell phone or alarm system panel.")?></span></a></td>
	<td align=right>
		<select name="emergency_msg_id" id="emergency_msg_id" tabindex="<?php echo ++$tabindex;?>">
		<?php
			echo '<option value="'.DEFAULT_MSG.'"'.(DEFAULT_MSG == $emergency_msg_id ? ' SELECTED' : '').'>'._("Default Message")."</option>\n";
			echo '<option value="'.CONGESTION_TONE.'"'.(CONGESTION_TONE == $emergency_msg_id ? ' SELECTED' : '').'>'._("Congestion Tones")."</option>\n";
			if (isset($tresults[0])) {
				foreach ($tresults as $tresult) {
					echo '<option value="'.$tresult['id'].'"'.($tresult['id'] == $emergency_msg_id ? ' SELECTED' : '').'>'.$tresult['displayname']."</option>\n";
				}
			}
		?>
		</select>
	</td>
</tr>
<tr>
	<td colspan="2"><br><h6><input name="Submit" type="submit" value="<?php echo _("Submit Changes")?>" tabindex="<?php echo ++$tabindex;?>"></h6></td>
</tr>
</table>

</form>
