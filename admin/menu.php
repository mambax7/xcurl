<?php

use XoopsModules\Xcurl;

require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = Xcurl\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

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
    'title' => _XC_ADMINMENU_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
];
