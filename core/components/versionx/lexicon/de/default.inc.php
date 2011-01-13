<?php
/*
 * VersionX
 *
 * Copyright 2010-2011 by Mark Hamstra (contact via www.markhamstra.nl)
 * Credit for german translation to Anselm Hannemann (contact via www.anselm-hannemann.de)
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
 * @subpackage lexicon-de
 * @author Anselm Hannemann
 * @date 2011-01-11
 * 
*/

$vxp = 'versionx.'; // I'm lazy, I know.

// Global 
$_lang[$vxp.'versionx'] = 'VersionX';

// Manager: Component menu
$_lang[$vxp.'menuDesc'] = 'Komponente für Inhalt-Versionierung';

// CMP: Overview
$_lang[$vxp.'overviewTitle'] = 'Übersicht';
$_lang[$vxp.'overviewDescription'] = 'VersionX überwacht sämtliche Änderungen in Ressourcen, Chunks und Snippets. Es bietet die Möglichkeit ältere Versionen per One-Click wiederherzustellen und Versionen zu vergleichen.<br>Für detaillierte Informationen wechseln Sie in den Reiter der gewünschten Ressourcengruppe.';
$_lang[$vxp.'devTitle'] = 'Entwicklung';
$_lang[$vxp.'devDescription'] = 'VersionX wurde von <a href="http://www.markhamstra.nl" title="Mark Hamstra">Mark Hamstra</a> als einfaches Versionierungs-Addon für <a href="http://www.modxcms.com" title="MODx: Content Management Framework">MODx CMF</a> entwickelt.<br>Bitte melden Sie sämtliche Bugs, unerwartetes Verhalten oder Feature-Requests im <a href="https://github.com/Mark-H/VersionX" title="VersionX on Github">Github Repository</a>.';
	
// CMP: Resources
$_lang[$vxp.'resourcesTitle'] = 'Ressourcen';
$_lang[$vxp.'resourcesDescription'] = 'VersionX erfasst sämtliche Änderungen an Ihren Inhalten.';

//// Resource detail window
$_lang[$vxp.'detailwindow.title'] = 'Ressourcen Änderung';
$_lang[$vxp.'detailwindow.basictab'] = 'Dokument Felder';
$_lang[$vxp.'detailwindow.settingstab'] = 'Seiteneinstellungen';

//// Resource compare window
//$_lang[$vxp.'resources.comparewindow.title'] = ''; 
$_lang[$vxp.'comparewindow.fieldstab'] = 'Felder &amp; Seiteneinstellungen'; 
$_lang[$vxp.'comparewindow.contenttab'] = 'Inhalt';
$_lang[$vxp.'comparewindow.fields.field'] = 'Feld';
$_lang[$vxp.'comparewindow.fields.old'] = 'alt';
$_lang[$vxp.'comparewindow.fields.new'] = 'neu';
$_lang[$vxp.'comparewindow.fields.change'] = 'geändert';

// CMP: Chunks
$_lang[$vxp.'chunksTitle'] = 'Chunks';
$_lang[$vxp.'chunksDescription']  = 'Objekte, die global verwendet werden können sollten überprüfbar sein. VersionX ermöglicht das und kann die Unterschiede zwischen den verschiedenen Änderungen anzeigen.';

// CMP: Snippets
$_lang[$vxp.'snippetsTitle'] = 'Snippets';
$_lang[$vxp.'snippetsDescription'] = 'Änderungen an Snippets können es schnell unbrauchbar machen. Stellen Sie es mit VersionX wieder her';

// CMP: Grid headings
$_lang[$vxp.'grid.revNum'] = '#';
$_lang[$vxp.'grid.docID'] = 'Ressource ID';
$_lang[$vxp.'grid.mode'] = 'Modus';
$_lang[$vxp.'grid.mode.upd'] = 'geändert';
$_lang[$vxp.'grid.mode.new'] = 'erstellt';
$_lang[$vxp.'grid.mode.rev'] = 'wiederhergestellt';
$_lang[$vxp.'grid.fromRev'] = 'vorherige Version';
$_lang[$vxp.'grid.class'] = 'Klasse';
$_lang[$vxp.'grid.time'] = 'Datum';
$_lang[$vxp.'grid.editor'] = 'Editor';

// CMP: Grid context menu
$_lang[$vxp.'grid.details'] = 'Details ansehen';
$_lang[$vxp.'grid.compare'] = 'Vergleichen';
$_lang[$vxp.'grid.restore'] = 'Wiederherstellen';
$_lang[$vxp.'grid.restoreTitle'] = 'Version wiederherstellen';
$_lang[$vxp.'grid.restoreMsg'] = 'Sind Sie sicher, dass Sie diese Ressource mit der gewählten (evtl. veralteten) Version ersetzen möchten?';
$_lang[$vxp.'grid.restore.done'] = 'Die ausgewählte Version wurde wiederhergestellt.';

?>