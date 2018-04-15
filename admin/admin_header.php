<?php
/**
 * $Id$
 * Module: WF-Downloads
 * Version: v2.0.5a
 * Release Date: 26 july 2004
 * Author: WF-Sections
 * Licence: GNU
 */

use XoopsModules\Xcurl;

error_reporting(E_ALL);
require_once  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
include  dirname(__DIR__) . '/include/functions.php';

require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$moduleDirName = basename(dirname(__DIR__));
$helper = Xcurl\Helper::getInstance();
/** @var Xmf\Module\Admin $adminObject */
$adminObject = Xmf\Module\Admin::getInstance();

if (is_object($GLOBALS['xoopsUser'])) {
    if (!$helper->isUserAdmin()) {
        $helper->redirect(XOOPS_URL . '/', 3, _NOPERM);
    }
} else {
    $helper->redirect(XOOPS_URL . '/', 1, _NOPERM);
}
$myts = \MyTextSanitizer::getInstance();
error_reporting(E_ALL);
