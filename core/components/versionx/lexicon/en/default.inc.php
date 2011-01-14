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
 * @subpackage lexicon-en
 * @author Mark Hamstra 
 * @date 2011-01-04
 * 
*/

$vxp = 'versionx.'; // I'm lazy, I know.

// Global 
$_lang[$vxp.'versionx'] = 'VersionX';

// Manager: Component menu
$_lang[$vxp.'menuDesc'] = 'A simple versioning component.';

// CMP: Overview
$_lang[$vxp.'overviewTitle'] = 'Overview';
$_lang[$vxp.'overviewDescription'] = 'VersionX keeps record of all your changes in Resources, Chunks and Snippets and offers a one-click option to restore an old revision. Visit the relative tabs for detailed information..';
$_lang[$vxp.'devTitle'] = 'Development';
$_lang[$vxp.'devDescription'] = 'VersionX has been developed by <a href="http://www.markhamstra.nl" title="Mark Hamstra">Mark Hamstra</a> as a simple versioning addon for <a href="http://www.modxcms.com" title="MODx: Content Management Framework">MODx CMF</a>. 
	Please report any bugs or unexpected behaviour at <a href="https://github.com/Mark-H/VersionX" title="VersionX on Github">Github</a>.';
	
// CMP: Resources
$_lang[$vxp.'resourcesTitle'] = 'Resources';
$_lang[$vxp.'resourcesDescription'] = 'VersionX takes note of your most valuable assets - your content.';

//// Resource detail window
$_lang[$vxp.'detailwindow.title'] = 'Resource Revision ';
$_lang[$vxp.'detailwindow.basictab'] = 'Basic Fields';
$_lang[$vxp.'detailwindow.settingstab'] = 'Settings';
$_lang[$vxp.'detailwindow.contenttab'] = 'Content'; // New 14/1/2011

//// Resource compare window
//$_lang[$vxp.'resources.comparewindow.title'] = ''; 
$_lang[$vxp.'comparewindow.fieldstab'] = 'Fields &amp; Settings'; 
$_lang[$vxp.'comparewindow.contenttab'] = 'Content';
$_lang[$vxp.'comparewindow.fields.field'] = 'Field';
$_lang[$vxp.'comparewindow.fields.old'] = 'Old';
$_lang[$vxp.'comparewindow.fields.new'] = 'New';
$_lang[$vxp.'comparewindow.fields.change'] = 'Change';

// CMP: Chunks
$_lang[$vxp.'chunksTitle'] = 'Chunks';
$_lang[$vxp.'chunksDescription']  = 'Objects which can be used globally are better watched after. VersionX does that, and can show you the differences between different revisions.';

// CMP: Snippets
$_lang[$vxp.'snippetsTitle'] = 'Snippets';
$_lang[$vxp.'snippetsDescription'] = 'Ever had a working snippet that changed after making a change? Revert easily with VersionX.';

// CMP: Grid headings
$_lang[$vxp.'grid.revNum'] = '#';
$_lang[$vxp.'grid.docID'] = 'Res. ID';
$_lang[$vxp.'grid.mode'] = 'Mode';
$_lang[$vxp.'grid.mode.upd'] = 'modified';
$_lang[$vxp.'grid.mode.new'] = 'created';
$_lang[$vxp.'grid.mode.rev'] = 'restored';
$_lang[$vxp.'grid.fromRev'] = 'Prior';
$_lang[$vxp.'grid.class'] = 'Class';
$_lang[$vxp.'grid.time'] = 'Time';
$_lang[$vxp.'grid.editor'] = 'Editor';

// CMP: Grid context menu
$_lang[$vxp.'grid.details'] = 'View details';
$_lang[$vxp.'grid.compare'] = 'Compare';
$_lang[$vxp.'grid.restore'] = 'Restore';
$_lang[$vxp.'grid.restoreTitle'] = 'Restore revision';
$_lang[$vxp.'grid.restoreMsg'] = 'Are you sure you want to revert the resource to the selected revision?';
$_lang[$vxp.'grid.restore.done'] = 'The specified revision has been restored.';

?>