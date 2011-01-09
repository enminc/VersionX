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
 */
/*
 * Instantiate the VersionX package.
 *
 * @package versionx
 * @subpackage cmp
 */
 
	// Get the assets_url and register the files used by ModExt
	$assetsUrl = $modx->getOption('versionx.assets_url',null,$modx->getOption('assets_url').'components/versionx/');
	$modx->regClientStartupScript($assetsUrl.'js/versionx.js');
	$modx->regClientStartupScript($assetsUrl.'js/hometabs.panel.js');
	$modx->regClientStartupScript($assetsUrl.'js/home.js');
	
	// Declare the package to use xPDO objects in the CMP.
	$path = MODX_CORE_PATH . 'components/versionx/model/';
   $fetchModel = $modx->addPackage('versionx', $path, 'extra_');
	if (!$fetchModel) {
      $modx->log(modX::LOG_LEVEL_ERROR, 'Error fetching versionX package in xPDO');
   } else {
		// If package found.. output some empty divs for modExt
		$o = '<div id="modx-panel-workspace-div"></div>
			<div id="versionx-panel-home-div"></div>
			<div id="viewdetails-window"></div>';
	}
	
	// Fetch the default lexicon for use later.
	$modx->lexicon->load('versionx:default');  

	// Return the empty divs
	return $o;

?>