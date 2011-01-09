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
	$rev = $_POST['revision'];
	
	// Include the MODx object
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.core.php';
	require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
	require_once MODX_CONNECTORS_PATH.'index.php';

	if (!is_numeric($rev)) {
		die( json_encode(array(
			'error' => 1,
			'message' => 'Revision is not numeric')));
	}
	// Load up VersionX
	$path = MODX_CORE_PATH . 'components/versionx/model/';
	$fetchModel = $modx->addPackage('versionx', $path, 'extra_');
	if (!$fetchModel) {
		$modx->log(modX::LOG_LEVEL_ERROR, 'Error fetching versionX package in restoreRevision.php');
		die(json_encode(array(
			'error' => 1,
			'message' => 'Unable to fetch the VersionX model.')));
	}
	// Fetch the revision data
	$revObj = $modx->getObject('Versionx',$rev);
	if ($revObj == '') { die(json_encode(array(
			'error' => 1,
			'message' => 'Could not load revision data.')));
	}

	$vX_allfields = array('id', 'type', 'contentType', 'pagetitle', 'longtitle', 'description', 'alias', 'link_attributes', 'published', 'pub_date', 'unpub_date',
		'parent', 'isfolder', 'introtext', 'richtext', 'template', 'menuindex', 'searchable', 'cacheable', 'createdby', 'createdon', 'deleted',
		'deletedon', 'deletedby', 'publishedon', 'publishedby', 'menutitle', 'donthit', 'haskeywords', 'hasmetatags', 'privateweb', 'privatemgr', 'content_dispo',
		'hidemenu', 'context_key', 'content_type'); //Excludes: fromRev, revision, contentField, editedby, editedon, time, class
	$resID = $revObj->get('id');
	$newRev = $modx->newObject('Versionx');
	$resource = $modx->getObject('modResource',$resID);
	foreach ($vX_allfields as $field) {
		$newRev->set($field,$revObj->get($field));
		$resource->set($field,$revObj->get($field));
	}

	// @@ 4/1/2011
	$vX_findlastrev = $modx->newQuery('Versionx');
	$vX_findlastrev->where(array(
	  'id' => $revObj->get('id')));
	$vX_findlastrev->sortby('time', 'DESC');
	$vX_lastrev = $modx->getObject('Versionx',$vX_findlastrev);
	$newRev->set('fromRev',$vX_lastrev->get('revision'));
	
	// END
	$newRev->set('mode','rev'.$rev);
	$newRev->set('contentField',$revObj->get('contentField'));
	$resource->setContent($revObj->get('contentField'));
	
	
	$user = $modx->user->get('id');
	$newRev->set('editedby',$user);
	$resource->set('editedby',$user);
	/*$newRev->set('editedon',time());
	$resource->set('editedon',time());*/
	$newRev->set('time',time());
	$newRev->set('class',$revObj->get('class'));
	$resource->set('class_key',$revObj->get('class'));
	
	$newRev->save();
	$resource->save();
	die('OK');
		
