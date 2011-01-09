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

VersionX.panel.Hometabs = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel' // Basic class to use -> styles the whole thing.
        ,items: [{ // Multidimensional array of items in the panel.Hometabs config
            html: '<h2>'+_('versionx.versionx')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header' // Header class
        },{
            xtype: 'modx-tabs' // Use the MODx class template
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,stateful: true
            ,stateId: 'versionx-home-tabpanel'
            ,items: [{
                title: _('versionx.overviewTitle')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('versionx.overviewDescription')+'</p>'
                    ,border: false
                    ,bodyStyle: 'padding: 10px'
                },{ 
						html: '<h3>'+_('versionx.devTitle')+'</h3>'+
							'<p>'+_('versionx.devDescription')+'</p>'
						,border: false
						,bodyStyle: 'padding: 10px'
					 }]	
            },{
                title: _('versionx.resourcesTitle')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('versionx.resourcesDescription')+'</p>'
                    ,border: false
                    ,bodyStyle: 'padding: 10px'
                },{
                    xtype: 'versionx-grid-resources'
                    ,preventRender: true
                }]
            },{
					title: _('versionx.chunksTitle')+' and '+_('versionx.snippetsTitle')+' coming in 1.1'
					,disabled: true
				}
				
				/*{
                title: _('versionx.chunksTitle')
                ,defaults: { autoHeight: true }
					 ,disabled: true
                ,items: [{
                    html: '<p>'+_('versionx.chunksDescription')+'</p>'
                    ,border: false
                    ,bodyStyle: 'padding: 10px'
                }]
            },{
                title: _('versionx.snippetsTitle')
                ,defaults: { autoHeight: true }
					 ,disabled: true
                ,items: [{
                    html: '<p>'+_('versionx.snippetsDescription')+'</p>'
                    ,border: false
                    ,bodyStyle: 'padding: 10px'
                }]
				}*/]
        }]
    });
    VersionX.panel.Hometabs.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Hometabs,MODx.Panel); // Extend it from the base MODx Panel
Ext.reg('versionx-panel-hometabs',VersionX.panel.Hometabs); // Register xtype (template)

VersionX.grid.Resources = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		  url: MODx.config.assets_url+'components/versionx/connector.php'
		  ,id: 'resourcegrid'
		  ,baseParams: { action: 'getlist' }
		  ,fields: ["revision","fromRev","mode","time","type","contentType","pagetitle","longtitle","description","alias","link_attributes","published","pub_date","unpub_date","parent","isfolder","introtext","contentField","richtext","template","menuindex","searchable","cacheable","createdby","createdon","editedby","editedon","deleted","deletedon","deletedby","publishedon","publishedby","menutitle","donthit","haskeywords","hasmetatags","privateweb","privatemgr","content_dispo","hidemenu","class","context_key","content_type","docid","editor"]
		  ,paging: true
		  ,autosave: false
		  ,remoteSort: false
		  ,primaryKey: 'revision'
		  ,columns: [{
            header: _('versionx.grid.revNum') //'#' 
            ,dataIndex: 'revision'
            ,sortable: true
            ,width: 20
			},{
			header: _('versionx.grid.docID') //'Res. ID' 
            ,dataIndex: 'docid'
            ,sortable: true
            ,width: 40
         },{
				header: _('versionx.grid.mode') 
				,dataIndex: 'mode'
				,sortable: true
				,width: 55
				,renderer: function(val, meta, record) {
					if (val=='upd') { return 'modified'; }
					if (val=='new') { return 'created'; }
					if (val.substr(0,3)=='rev') { return 'restored ('+val.substr(3)+')'; }
				}
			},{
            header: _('versionx.grid.fromRev') //'Prior' 
            ,dataIndex: 'fromRev'
            ,sortable: true
            ,width: 40
			},{
            header: _('versionx.grid.class') //'Class' 
            ,dataIndex: 'class'
            ,sortable: true
            ,width: 100
         },{
            header: _('versionx.grid.time') //'Time' 
            ,dataIndex: 'time'
            ,sortable: true
            ,width: 100
        },{
            header: _('versionx.grid.editor') //'Editor' 
            ,dataIndex: 'editedby'
            ,sortable: true
            ,width: 100
        }]
			,listeners: {
				'cellcontextmenu': function(grid, row, col, eventObj){
					var _contextMenu = new Ext.menu.Menu({
						items: [{
							text: _('versionx.grid.details') //'View details'
							//,icon: '../assets/components/versionx/images/star.gif'
							,handler: function() {
								resourcewindow(grid, eventObj, row)
							}
						},{
							text: _('versionx.grid.compare') //'Compare'
							,handler: function() {
								comparewindow(grid, eventObj, row)
							}
						},{
							text: _('versionx.grid.restore') //'Restore'
							,handler: function() {
								Ext.MessageBox.confirm(_('versionx.grid.restoreTitle'), _('versionx.grid.restoreMsg'), function(btn){
								if(btn === 'yes'){
									var conn = new Ext.data.Connection();
									var pGrid = Ext.ComponentMgr.get('resourcegrid'); //ID as specified in the gridPanel config
									var gridrecord = pGrid.getSelectionModel().getSelected().json;
									var x = gridrecord.revision;
									if (x==undefined) { x = 'Error, please try again'; }
									conn.request({
										url: MODx.config.assets_url+'components/versionx/connector.php', 
										method: 'POST',
										params: { action: 'restoreRevision', revision: x },
										success: function(responseObject) {
											var returned = responseObject.responseText;
											if (returned == 'OK') {
												window.alert(_('versionx.grid.restore.done'));
												window.location.reload(true);
											}
											//window.alert(responseObject.responseText); 
										},
										failure: function() {
											window.alert('Oops. Unable to restore the revision (ajax failure).');
										}
									});
								}
								else{
									// User pressed no.
								}
							 });
							}
						}]
					});
					_contextMenu.showAt(eventObj.getXY());
				}
			}
    });
    VersionX.grid.Resources.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Resources,MODx.grid.Grid);
Ext.reg('versionx-grid-resources',VersionX.grid.Resources);

function resourcewindow(g, eventObj, row) {
	var pGrid = Ext.ComponentMgr.get('resourcegrid'); //ID as specified in the gridPanel config
	var gridrecord = pGrid.getSelectionModel().getSelected().json;
	var x = gridrecord.revision;
	if (x==undefined) { x = 'Error, please try again'; }
	if (win) { win.close(); }
	var win = new Ext.Window({
		title: _('versionx.detailwindow.title') //'Resource Revision '+x
		,closeable: true
		,closeAction: 'close'
		,id: 'resourcewindow'
		,hidden: false
		,resizable: false
		,renderTo: 'viewdetails-window'
		,width: 500 // Width required to properly display tabs in the window
		,autoHeight: true

		,items: [{
			xtype: 'modx-tabs'
			,bodyStyle: 'padding: 10px'
			,defaults: { border: false }
			,items: [{
				title: _('versionx.detailwindow.basictab') //'Basic Fields'
				,cls: 'modx-panel'
				,bodyStyle: 'padding: 10px'
				,html: '<table><tr><td width="120px">Template</td><td>'+gridrecord.template+'</td></tr><tr><td>Pagetitle</td><td>'+gridrecord.pagetitle+'</td></tr><tr><td>Longtitle</td><td>'+gridrecord.longtitle+'</td></tr><tr><td>Description</td><td>'+gridrecord.description+'</td></tr><tr><td>Alias</td><td>'+gridrecord.alias+'</td></tr><tr><td>Link attributes</td><td>'+gridrecord.link_attributes+'</td></tr><tr><td>Introtext</td><td>'+gridrecord.introtext+'</td></tr><tr><td>Parent</td><td>'+gridrecord.parent+'</td></tr><tr><td>Menutitle</td><td>'+gridrecord.menutitle+'</td></tr><tr><td>Menu index</td><td>'+gridrecord.menuindex+'</td></tr><tr><td>Hide from menu</td><td>'+gridrecord.hidemenu+'</td></tr></td></tr></table><h3>Content</h3><blockquote style="padding: 10px;">'+gridrecord.contentField+'</blockquote>'
			},{
				title: _('versionx.detailwindow.settingstab') //'Settings'
				,bodyStyle: 'padding: 10px'
				,html: '<table><tr><td width="120px">Container?</td><td>'+gridrecord.isfolder+'</td></tr><tr><td>Richtext</td><td>'+gridrecord.richtext+'</td></tr><tr><td>Published on</td><td>'+gridrecord.publishedon+'</td></tr><tr><td>Published by</td><td>'+gridrecord.publishedby+'</td></tr><tr><td>Publish date</td><td>'+gridrecord.pub_date+'</td></tr><tr><td>Unpublish date</td><td>'+gridrecord.unpub_date+'</td></tr><tr><td>Searchable</td><td>'+gridrecord.searchable+'</td></tr><tr><td>Cacheable</td><td>'+gridrecord.cacheable+'</td></tr><tr><td>Deleted</td><td>'+gridrecord.deleted+'</td></tr><tr><td>Content type</td><td>'+gridrecord.content_type+'</td></tr><tr><td>Content disposition</td><td>'+gridrecord.content_dispo+'</td></tr><tr><td>Class key</td><td>'+gridrecord.class+'</td></tr></table>'
			}]
		}] 
	});
}
function comparewindow(g, eventObj, row) {
	var pGrid = Ext.ComponentMgr.get('resourcegrid'); //ID as specified in the gridPanel config
	var gridrecord = pGrid.getSelectionModel().getSelected().json;
	var newRev = gridrecord.revision;
	if (newRev==undefined) { newRev = 'Error, please try again'; }
	var old = gridrecord.fromRev;
	if (win) { win.close(); }
	var win = new Ext.Window({
		title: 'Comparing Revision '+newRev+' and '+old // @ LEXICON
		,closeable: true
		,closeAction: 'close'
		,id: 'comparewindow'
		,hidden: false
		,resizable: false
		,renderTo: 'viewdetails-window'
		,width: 600 // Width required to properly display tabs in the window
		,autoHeight: true

		,items: [{
			xtype: 'modx-tabs'
			,bodyStyle: 'padding: 10px'
			,defaults: { border: false }
			,items: [{
				title: _('versionx.comparewindow.fieldstab') //'Fields &amp; settings'
				,cls: 'modx-panel'
				,bodyStyle: 'padding: 10px'
				//,html: 'The grid below displays differences between the new and old revision. Please see the other tab for a line-per-line comparison of the content.'
				,xtype: 'versionx-grid-resources-compare'	
			},{
				title: _('versionx.comparewindow.contenttab') //'Content'
				,cls: 'modx-panel'
				,bodyStyle: 'padding: 10px'
				,xtype: 'versionx-grid-resources-compare-content'
			}]
		}] 
	});
}
VersionX.grid.Resources.Compare = function(config) {
	var pGrid = Ext.ComponentMgr.get('resourcegrid'); //ID as specified in the gridPanel config
	var gridrecord = pGrid.getSelectionModel().getSelected().json;
	var newRev = gridrecord.revision;
	if (newRev==undefined) { newRev = 'Error, please try again'; }
	var fromRev = gridrecord.fromRev;
	
    config = config || {};
    //this.sm = new Ext.grid.CheckboxSelectionModel();
    Ext.applyIf(config,{
        url: MODx.config.assets_url+'components/versionx/connector.php'
		  //url: '../core/components/versionx/processors/mgr/hometabs/compareResources.php'
		  ,id: 'resourcecomparegrid'
		  ,baseParams: { action: 'compareResources', old: fromRev, new: newRev }
        ,fields: ["field","oldvalue","newvalue"]
        ,paging: false
        ,autosave: false
        ,remoteSort: false
        ,primaryKey: 'field'
        //,sm: this.sm // Checkbox selection model
        ,columns: [{
            header: _('versionx.comparewindow.fields.field') //'Field' 
            ,dataIndex: 'field'
            ,sortable: true
            ,width: 60
        },{
            header: _('versionx.comparewindow.fields.old')+' (R'+fromRev+')'
            ,dataIndex: 'oldvalue'
            ,sortable: true
            ,width: 100
				,forcefit: true
        },{
            header: _('versionx.comparewindow.fields.new')+' (R'+newRev+')' 
            ,dataIndex: 'newvalue'
            ,sortable: true
				,forcefit: true
            //,width: 100
        }]
    });
    VersionX.grid.Resources.Compare.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Resources.Compare,MODx.grid.Grid);
Ext.reg('versionx-grid-resources-compare',VersionX.grid.Resources.Compare);



VersionX.grid.Resources.CompareContent = function(config) {
	var pGrid = Ext.ComponentMgr.get('resourcegrid'); //ID as specified in the gridPanel config
	var gridrecord = pGrid.getSelectionModel().getSelected().json;
	var newRev = gridrecord.revision;
	if (newRev==undefined) { newRev = 'Error, please try again'; }
	var fromRev = gridrecord.fromRev;
	
    config = config || {};
    //this.sm = new Ext.grid.CheckboxSelectionModel();
    Ext.applyIf(config,{
        //url: '../assets/components/versionx/connector.php'
		  url: '../core/components/versionx/processors/mgr/hometabs/compareResourcesContent.php'
		  ,id: 'resourcecomparecontentgrid'
		  ,baseParams: { old: fromRev, new: newRev }
        ,fields: ["oldvalue","newvalue","change"]
        ,paging: false
        ,autosave: false
        ,remoteSort: false
        ,primaryKey: 'oldvalue'
        //,sm: this.sm // Checkbox selection model
        ,columns: [{
				header: _('versionx.comparewindow.fields.change')
				,dataIndex: 'change'
				,sortable: true
			},{
            header: _('versionx.comparewindow.fields.old')+' (R'+newRev+')'
            ,dataIndex: 'oldvalue'
            ,sortable: true
				,forceFit: true
            ,width: 100
        },{
            header: _('versionx.comparewindow.fields.new')+' (R'+newRev+')'
            ,dataIndex: 'newvalue'
            ,sortable: true
				,forceFit: true
            //,width: 100
        }]
    });
    VersionX.grid.Resources.CompareContent.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Resources.CompareContent,MODx.grid.Grid);
Ext.reg('versionx-grid-resources-compare-content',VersionX.grid.Resources.CompareContent);