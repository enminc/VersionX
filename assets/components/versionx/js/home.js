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
 * Instantiate the first (only) page.
 *
 * @package versionx
 * @subpackage core
 */

/*
Ext.onReady(function() { // Load the xtype (= "template") when ready
    MODx.load({ xtype: 'versionx-page-home'}); // xtype should match the first parameter of Ext.reg
});

VersionX.page.Home = function(config) { // Config for page.Home
    config = config || {};
    Ext.applyIf(config,{ 
        components: [{ 
            xtype: 'versionx-panel-hometabs',
            renderTo: 'versionx-panel-home-div' // Div that should be in your page
        }]
    }); 
    VersionX.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Home,MODx.Component); // Extend it from the MODx.Component class.
Ext.reg('versionx-page-home',VersionX.page.Home); // First parameter is the xtype to be referenced, second the config*/