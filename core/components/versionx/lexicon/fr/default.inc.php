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
 * @subpackage lexicon-fr
 * @author rtripault (4/1/2011)
 */
 $vxp = 'versionx.'; // I'm lazy, I know.
 
// Translation last updated: 4/1/2010

// Global 
$_lang[$vxp.'versionx'] = 'VersionX';

// Manager: Component menu
$_lang[$vxp.'menuDesc'] = 'Un composant de versioning.';

// CMP: Overview
$_lang[$vxp.'overviewTitle'] = 'Panorama';
$_lang[$vxp.'overviewDescription'] = 'VersionX enregistre toutes les modifications de ressources, chunks et snippets et offre la possibilité de restaurer une ancienne version en un clic. Dans l\'onglet Panorama vous trouverez les trois dernières versions par section. Allez sur les onglets relatifs pour plus d\'informations et d\'options.';
$_lang[$vxp.'devTitle'] = 'Développement';
$_lang[$vxp.'devDescription'] = 'VersionX a été développé par <a href="http://www.markhamstra.nl" title="Mark Hamstra">Mark Hamstra</a> comme composant de versioning pour <a href="http://www.modxcms.com" title="MODx: Content Management Framework">MODx CMF</a>.<br />
Veuillez repporter les bugs ou bizarreries sur <a href="https://github.com/Mark-H/VersionX" title="VersionX on Github">Github</a>.';
	
// CMP: Resources
$_lang[$vxp.'resourcesTitle'] = 'Ressources';
$_lang[$vxp.'resourcesDescription'] = 'VersionX prend soin de votre bien le plus précieux - votre contenu.';

//// Resource detail window
$_lang[$vxp.'detailwindow.title'] = 'Version de la ressource';
$_lang[$vxp.'detailwindow.basictab'] = 'Champs basics';
$_lang[$vxp.'detailwindow.settingstab'] = 'Propriétés';

//// Resource compare window
//$_lang[$vxp.'resources.comparewindow.title'] = ''; 
$_lang[$vxp.'comparewindow.fieldstab'] = 'Champs &amp; propriétés'; 
$_lang[$vxp.'comparewindow.contenttab'] = 'Contenu';
$_lang[$vxp.'comparewindow.fields.field'] = 'Champ';
$_lang[$vxp.'comparewindow.fields.old'] = 'Ancien';
$_lang[$vxp.'comparewindow.fields.new'] = 'Nouveau';
$_lang[$vxp.'comparewindow.fields.change'] = 'Changement';

// CMP: Chunks
$_lang[$vxp.'chunksTitle'] = 'Chunks';
$_lang[$vxp.'chunksDescription']  = 'Objects which can be used globally are better watched after. VersionX does that, and can show you the differences between different revisions.';

// CMP: Snippets
$_lang[$vxp.'snippetsTitle'] = 'Snippets';
$_lang[$vxp.'snippetsDescription'] = 'Ever had a working snippet that changed after making a change? Revert easily with VersionX.';

// CMP: Grid headings
$_lang[$vxp.'grid.revNum'] = '#';
$_lang[$vxp.'grid.docID'] = 'Res. ID';
$_lang[$vxp.'grid.mode'] = 'État';
$_lang[$vxp.'grid.mode.upd'] = 'modifié';
$_lang[$vxp.'grid.mode.new'] = 'créé';
$_lang[$vxp.'grid.mode.rev'] = 'restoré (';
$_lang[$vxp.'grid.fromRev'] = 'Avant';
$_lang[$vxp.'grid.class'] = 'Classe';
$_lang[$vxp.'grid.time'] = 'Date';
$_lang[$vxp.'grid.editor'] = 'Édité par';


// CMP: Grid context menu
$_lang[$vxp.'grid.details'] = 'Voir les détails';
$_lang[$vxp.'grid.compare'] = 'Comparer';
$_lang[$vxp.'grid.restore'] = 'Restorer';
$_lang[$vxp.'grid.restoreTitle'] = 'Restorer la version';
$_lang[$vxp.'grid.restoreMsg'] = 'Êtes-vous sûr de vouloir remplacer la ressource par la version sélectionnée?';
$_lang[$vxp.'grid.restore.done'] = 'La version a été restorée.';







?>