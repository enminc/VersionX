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

	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.core.php';
	require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
	require_once MODX_CONNECTORS_PATH.'index.php';
	/* setup default properties */
	$isLimit = !empty($scriptProperties['limit']);
	$isCombo = !empty($scriptProperties['combo']);
	$start = $modx->getOption('start',$scriptProperties,0);
	$limit = $modx->getOption('limit',$scriptProperties,20);
	$sort = $modx->getOption('sort',$scriptProperties,'revision');
	$dir = $modx->getOption('dir',$scriptProperties,'DESC');
	$dateFormat = $modx->getOption('dateformat',$scriptProperties,$modx->getOption('manager_date_format').' '.$modx->getOption('manager_time_format'));

	$path = MODX_CORE_PATH . 'components/versionx/model/';
	$fetchModel = $modx->addPackage('versionx', $path, 'extra_');
			if (!$fetchModel) {
	  $modx->log(modX::LOG_LEVEL_ERROR, 'Error fetching versionX package in xPDO');
	}

	// Build query
	$c = $modx->newQuery('Versionx');
	$count = $modx->getCount('Versionx',$c);
	$c->sortby($sort,$dir);

	// Fetch items
	$revisions = $modx->getCollection('Versionx', $c);
	$list = array();
	
	$userID = array(); // Will be used to "cache" the userIDs and their names.
	
	foreach ($revisions as $rev) {
		// Set an empty array to hold the data for this revision.
		$resArray = array();
		
		// Fetch all data
		$resArray = $rev->toArray();
		// Start processing fields in the $rev object.
		// First process the fields with user IDs.
		$userfields = array('createdby', 'editedby', 'publishedby', 'deletedby');
		foreach ($userfields as $x => $uf) {
			if ($rev->get($uf) > 0) {
				$uid = $rev->get($uf); 
				if (!empty($userID['u'.$uid])) { 
					$resArray[$uf] = $userID['u'.$uid];
				}
				else {
					$u = $modx->getObject('modUser',$uid);
					if (!$u) { // No user found with that ID
						$resArray[$uf] = 'User ID '.$uid.' not found';
						$userID['u'.$uid] = 'User ID '.$uid.' not found';
					} else {
						$up = $u->getOne('Profile');
						$ufn = $up->get('fullname').' ('.$uid.')';
						$resArray[$uf] = $ufn;
						$userID['u'.$uid] = $ufn;
					}
				}
			}
			else {
				$resArray[$uf] = '-';
			}
		}
		// As editedby is viewed in the grid, make sure to set editedby to createdby on a new resource
		if ($rev->get('mode') == 'new') {
			$resArray['editedby'] = $resArray['createdby'];
		}
		
		// Display the template name
		$tpl = $resArray['template'];
		$tplObj = $modx->getObject('modTemplate',$tpl);
		if (!$tplObj) { $resArray['template'] = 'Not found.'; }
		else { $resArray['template'] = $tplObj->get('templatename').' ('.$tpl.')'; }
		
		// Display the parent's resource_tree_node_name
		$parent = $resArray['parent'];
		if ($parent > 0) {
			$parObj = $modx->getObject('modResource',$parent);
			if ($parObj) { $resArray['parent'] = $parObj->get($modx->getOption('resource_tree_node_name')); }
		} 
		
		// "id" is rendered as unique in extjs, so change the id field to docid
		$resArray['docid'] = $resArray['id']; 	
		unset ($resArray['id']); 
		
		// Render boolean values (0,1) as yes or no
		$boolFields = array('published', 'isfolder', 'richtext', 'searchable', 'cacheable', 'deleted', 'donthit', 'haskeywords', 'hasmetatags', 'privateweb', 'privatemgr', 'content_dispo', 'hidemenu');
		foreach ($boolFields as $fld) {
			$resArray[$fld] = ($resArray[$fld] > 0) ? 'Yes' : 'No'; // Lexicon-ify
		}
		
		// Format the time, using $dateFormat which is set to the manager date + time format
		$resArray['time'] = date($dateFormat,$rev->get('time')); 
		
		// If fromRev = 0, set it to '' (empty string)
		$resArray['fromRev'] = ($resArray['fromRev'] > 0) ? $resArray['fromRev'] : '';  
		
		// To show line breaks in the revision. 
		$resArray['contentField'] = nl2br($resArray['contentField']); 
		
		// JS breaks on the use of "class", so change the field name to return.
		$resArray['classKey'] = $resArray['class']; 
		unset($resArray['class']); 
		
		$list[] = $resArray;
	}
	$outputArray['total'] = $count;
	$outputArray['results'] = $list;
	echo json_encode($outputArray);