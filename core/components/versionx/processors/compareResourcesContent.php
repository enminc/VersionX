<?php
/*
 * VersionX
 *
 * Copyright 2010-2011 by Mark Hamstra (contact via www.markhamstra.nl)
 *
 * This file is part of VersionX, a basic versioning addon for MODx CMF.
 *
 * VersionX is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * VersionX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * VersionX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package versionx
 * @subpackage processors
 */
 
	// Include the MODx object
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.core.php';
	require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
	require_once MODX_CONNECTORS_PATH.'index.php';

	// Find revisions from the $_POST data
	$revNew = (is_numeric($_REQUEST['new'])) ? $_REQUEST['new'] : '';
	$revOld = (is_numeric($_REQUEST['old'])) ? $_REQUEST['old'] : '';
	if (($revNew == '') || ($revOld == '')) { 
		$err = array(
			'total' => 1,
			'results' => array(
				0 => array(
					'field' => 'ERROR',
					'oldvalue' => 'Error uncovering revision numbers.'))); // @LEXICON
		die(json_encode($err));
	}
	
	// If the script got here, let's load up Versionx..
	$path = MODX_CORE_PATH . 'components/versionx/model/';
	$fetchModel = $modx->addPackage('versionx', $path, 'extra_');
	if (!$fetchModel) {
	  $modx->log(modX::LOG_LEVEL_ERROR, 'Error fetching versionX package in compareResourcesContent.php'); // @LEXICON
	  die ('Error fetching versionx package in compareResourcesContent.php'); // @LEXICON
	}
	
	// Get the two objects for the new and old revision
	$revNewObj = $modx->getObject('Versionx', $revNew);
	if (!$revNewObj) { die ('Error fetching new revision'); } // @LEXICON
	$revOldObj = $modx->getObject('Versionx', $revOld);
	if (!$revOldObj) { die ('Error fetching old revision'); } // @LEXICON
	
	// Check if the IDs match.. if they don't, comparing is quite useless.
	$revNewArr = array(); $revOldArr = array();
	$revNewArr['id'] = $revNewObj->get('id');
	$revOldArr['id'] = $revOldObj->get('id');
	if ($revNewArr['id'] !== $revOldArr['id']) { die ('Revision id mismatch'); } // @LEXICON
	
	// If the script got down here, let's compare the content.
	$c1 = $revNewObj->get('contentField');
	$rev2 = $modx->getObject('Versionx',$from);
	$c2 = $revOldObj->get('contentField');
	$changed = array();

	// Rewrite, improve, comparing class?
	include (MODX_CORE_PATH.'/xpdo/revision/xpdorevisioncontrol.class.php');
	$compare = new xPDORevisionControl;
	$result = $compare->diff($c1,$c2);

	$result = explode('---',$result);

	$rl = explode("\n",trim($result[0]));
	$rr = explode("\n",trim($result[1]));

	$count1 = count($rl) -1;
	$count2 = count($rr);
	$count = ($count1 > $count2) ? $count1 : $count2;
	for ($i = 0;$i < $count;$i++) {
		$skip = 0;
		$new = $rl[$i+1]; // Due to "summary" of xpdorevisioncontrol
		$old = $rr[$i];
		$newC = ''; $oldC = ''; $change = '';
		$change = '';
		switch (substr($new,0,1).substr($old,0,1)) {
			case '<>':
				$change = 'modified'; 
				$newC = substr($new,2);
				$oldC = substr($old,2);
				break;
			case '<':
				$change = 'added'; 
				$newC = substr($new,2);
				$oldC = substr($old,2);
				break;
			case '>':
				$change = 'removed'; 
				//$newC = substr($new,2);
				$oldC = substr($new,2);
				break;
			case '\\':
				$skip = 1;
				break;
			default:
				$skip = 1;
				break;
		}
		if ($skip == 0) {
			$newC = nl2br(htmlentities($newC));
			$oldC = nl2br(htmlentities($oldC));
			$changed[] = array (
				'oldvalue' => $oldC,
				'newvalue' => $newC,
				'change' => $change);
		}
	}
	
	$result = array (
		'total' => count($changed),
		'results' => $changed,
		'xpdoresult' => $rl[0]);
		
	echo json_encode($result);
	
?>