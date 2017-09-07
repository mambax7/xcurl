<?php

$moduleDirName = basename(dirname(__DIR__));

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}


$pathIcon32    = \Xmf\Module\Admin::menuIconPath('');

$adminmenu[] = [
    'title' => _XC_ADMINMENU_1,
    'link'  => 'admin/index.php?op=tables',
    'icon'  => 'images/dbtables.png',
];

$adminmenu[] = [
    'title' => _XC_ADMINMENU_2,
    'link'  => 'admin/index.php?op=fields',
    'icon'  => 'images/dbfields.png',
];

$adminmenu[] = [
    'title' => _XC_ADMINMENU_3,
    'link'  => 'admin/index.php?op=views',
    'icon'  => 'images/dbviews.png',
];

$adminmenu[] = [
    'title' => _XC_ADMINMENU_4,
    'link'  => 'admin/index.php?op=plugins',
    'icon'  => 'images/plugins.png',
];

$adminmenu[] = [
    'title' => _XC_ADMINMENU_5,
    'link'  => 'admin/permissions.php',
    'icon'  => 'images/permissions.png',
];

$adminmenu[] = [
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
];
