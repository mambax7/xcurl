<?php
/**
 * $Id$
 * Module: WF-Downloads
 * Version: v2.0.5a
 * Release Date: 26 july 2004
 * Author: WF-Sections
 * Licence: GNU
 */
error_reporting(E_ALL);
require_once __DIR__ . '/../../../include/cp_header.php';
include __DIR__ . '/../include/functions.php';

include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$moduleDirName = basename(dirname(__DIR__));

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}
/** @var Xmf\Module\Admin $adminObject */
$adminObject = Xmf\Module\Admin::getInstance();

if (is_object($GLOBALS['xoopsUser'])) {
    if (!$moduleHelper->isUserAdmin()) {
        $moduleHelper->redirect(XOOPS_URL . '/', 3, _NOPERM);
    }
} else {
    $moduleHelper->redirect(XOOPS_URL . '/', 1, _NOPERM);

}
$myts = MyTextSanitizer::getInstance();
error_reporting(E_ALL);
