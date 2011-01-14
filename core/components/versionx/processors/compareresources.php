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
	  $modx->log(modX::LOG_LEVEL_ERROR, 'Error fetching versionX package in compareResources.php'); // @LEXICON
	  die ('Error fetching versionx package in compareResources.php'); // @LEXICON
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
	
	// If the script got down here, let's compare some fields. Array does not include content.
	$fields = array('contentType', 'pagetitle', 'longtitle', 'description', 'alias', 'link_attributes', 'published', 'pub_date', 'unpub_date', 'parent', 'isfolder', 'introtext', 'richtext', 'template', 'menuindex', 'searchable', 'cacheable', 'deleted', 'deletedon', 'deletedby', 'publishedon', 'publishedby', 'menutitle', 'donthit', 'haskeywords', 'hasmetatags', 'privateweb', 'privatemgr', 'content_dispo', 'hidemenu', 'context_key', 'content_type');
	$changed = array(); $unchanged = array();
	foreach ($fields as $field) {
		$revNewArr[$field] = $revNewObj->get($field);
		$revOldArr[$field] = $revOldObj->get($field);
		if ($revNewArr[$field] != $revOldArr[$field]) {
			$changed[] = array(
				'field' => $field,
				'oldvalue' => $revOldArr[$field],
				'newvalue' => $revNewArr[$field]);
		} else {
			$unchanged[] = $field;
		}
	}
	
	$unchanged = implode(', ',$unchanged);
	$result = array(
		'total' => count($changed),
		'results' => $changed,
		'unchanged' => $unchanged);
		
	echo json_encode($result);
	
?>