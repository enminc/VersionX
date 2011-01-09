<?php
/*
 * VersionX build script
 *
 * @package versionx
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0); /* makes sure our script doesnt timeout */

$root = dirname(dirname(__FILE__)).'/';
$sources= array (
    'root' => $root,
    'build' => $root .'_build/',
    'resolvers' => $root . '_build/resolvers/',
    'data' => $root . '_build/data/',
    'source_core' => $root.'core/components/versionx',
    'lexicon' => $root . 'core/components/versionx/lexicon/',
    'source_assets' => $root.'assets/components/versionx',
    //'docs' => $root.'core/components/versionx/docs/',
);
unset($root); /* save memory */

require_once dirname(__FILE__) . '/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(MODX_LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage('versionx','1.0','alpha1');
$builder->registerNamespace('versionx',false,true,'{core_path}components/versionx/');

/* load action/menu */
$action = include $sources['data'].'transport.actions.php';

$vehicle= $builder->createVehicle($action,array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => array ('namespace','controller'),
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Menus' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array ('action', 'text'),
        ),
    ),
));
$builder->putVehicle($vehicle);
unset($vehicle,$action);

/* load system settings
$settings = array();
include_once $sources['data'].'transport.settings.php';

$attributes= array(
    xPDOTransport::UNIQUE_KEY => 'key',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => false,
);
foreach ($settings as $setting) {
    $vehicle = $builder->createVehicle($setting,$attributes);
    $builder->putVehicle($vehicle);
}
unset($settings,$setting,$attributes);*/


/* create category */
$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category','VersionX');

$plugins = array();
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','VersionX');
$plugins[0]->set('description','Manages storing revisions in your website.');
$plugins[0]->set('plugincode', 'just to make sure it aint empty'.file_get_contents($sources['source_core'] . '/plugin.versionx.php'));
$plugins[0]->set('category', 1);
$events = array(); // include $sources['events'].'events.quipresourcecleaner.php';
$events['OnDocFormSave']= $modx->newObject('modPluginEvent');
$events['OnDocFormSave']->fromArray(array(
    'event' => 'OnDocFormSave',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for VersionX.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for QuipResourceCleaner!');
}
unset($events);

/* add chunks */
/*$chunks = include $sources['data'].'transport.chunks.php';
if (is_array($chunks)) {
    $category->addMany($chunks);
} else { $modx->log(MODX_LOG_LEVEL_FATAL,'Adding chunks failed.'); }*/

/* create category vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'modPlugin' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    )
);
$vehicle = $builder->createVehicle($category,$attr);
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$vehicle->resolve('file',array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
/*$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'setupoptions.resolver.php',
));*/
$builder->putVehicle($vehicle);

/* load lexicon strings */
$builder->buildLexicon($sources['lexicon']);

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => 'GNU you-know-what.', //file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => 'No promises for anything. But you know that right?', //file_get_contents($sources['docs'] . 'readme.txt'),
    /*'setup-options' => array(
        'source' => $sources['build'].'setup.options.php',
    ),*/
));

$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(MODX_LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");

exit ();