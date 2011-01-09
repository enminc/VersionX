<?php
/**
* Adds modActions and modMenus into package
*
* @package quip
* @subpackage build
*/
$action= $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 1,
    'namespace' => 'versionx',
    'parent' => 0,
    'controller' => 'index',
    'haslayout' => 1,
    'lang_topics' => 'versionx:default',
    'assets' => '',
),'',true,true);

/* load menu into action */
$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'parent' => 'components',
    'text' => 'versionx.versionx',
    'description' => 'versionx.menuDesc',
    'icon' => '',
    'menuindex' => '0',
    'params' => '',
    'handler' => '',
),'',true,true);
$menu->addOne($action);

return $menu;