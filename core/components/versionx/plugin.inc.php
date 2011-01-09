<?php
/*
 * VersionX 1.0-alpha1
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
 */
/*
 * Installation instructions:
 * - Upload the core and assets folder to the related folder on your server
 * - 
 */
   if (!defined('versionx')) {
		die ('Unauthorized access.');
	}
	
   // Register VersionX with MODx.
   $path = MODX_CORE_PATH . 'components/versionx/model/';
   $fetchModel = $modx->addPackage('versionx', $path, 'extra_');
	
	// Check if we got the model running. If not, write to the error.log.
	if (!$fetchModel) {
	  $modx->log(modX::LOG_LEVEL_ERROR, 'Error fetching versionX package in xPDO');
	  exit;
	}
	else {
	  // A list of all the fields, except from, revision (primary key) and content.
	  $vX_allfields = array('id', 'type', 'contentType', 'pagetitle', 'longtitle', 'description', 'alias', 'link_attributes', 'published', 'pub_date', 'unpub_date', 'parent', 'isfolder', 'introtext', 'richtext', 'template', 'menuindex', 'searchable', 'cacheable', 'createdby', 'createdon', 'editedby', 'editedon', 'deleted', 'deletedon', 'deletedby', 'publishedon', 'publishedby', 'menutitle', 'donthit', 'haskeywords', 'hasmetatags', 'privateweb', 'privatemgr', 'content_dispo', 'hidemenu', 'context_key', 'content_type');
	  
	  // Let's see what type of resource we're dealing with, and determine what fields to save. Currently all for all. But ya never know!
	  switch ($resource->get('class_key')) {
		 case 'modDocument':
			$vX_fields = $vX_allfields;
			break;
		 
		 case 'modWebLink':
			$vX_fields = $vX_allfields;
			break;
			
		 case 'modSymLink':
			$vX_fields = $vX_allfields;
			break;
			
		 case 'modStaticResource':
			$vX_fields = $vX_allfields;
			break;
			
		 default:
			$modx->log(modX::LOG_LEVEL_ERROR, 'Invalid class_key');
			break;
	  }
	  // Now make the new object
	  $vX_new = $modx->newObject('Versionx');
	  
	  // Set the content & class key seperately to avoid errors
	  $vX_new->set('contentField',$resource->getContent());
	  $vX_new->set('class',$resource->get('class_key'));
	  
	  // Loop through the selected fields and set its data from the resource being saved.
	  foreach ($vX_fields as $field) {
		 $vX_new->set($field, $resource->get($field));
	  }
	  
	  // Find out what the last revision was and set the mode.
	  switch ($mode) {
		 case 'new': // New resource created
			$vX_new->set('fromRev', 0);
			$vX_new->set('mode', 'new');
			break;
		 case 'upd': // Resource edited
			$vX_new->set('mode', 'upd');
			// Try to find the last revision ("fromRev").   
			$vX_findlastrev = $modx->newQuery('Versionx');
			$vX_findlastrev->where(array(
			  'id' => $resource->get('id')));
			$vX_findlastrev->sortby('time', 'DESC');
			$vX_lastrev = $modx->getObject('Versionx',$vX_findlastrev);
			  
			// No prior revision found? Debug + set to 0
			if (!$vX_lastrev) {
			  $modx->log(modX::LOG_LEVEL_DEBUG, 'No prior revision found. Setting last revision to 0');
			  $vX_new->set('fromRev', 0);
			}
			// Found a revision? Set "from" to its id.
			else {
			  $vX_new->set('fromRev', $vX_lastrev->get('revision'));
			  //$vX_new->set('from', 99999);
			  }
		 break;
	}
	  $vX_new->set('time', time());
	  // Save the new revision.
	  $vX_new->save();
	}