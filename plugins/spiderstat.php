<?php
/**
 * @return array
 */
function spiderstat_xsd()
{
    $xsd                                    = [];
    $i                                      = 0;
    $data                                   = [];
    $data[]                                 = ['name' => 'username', 'type' => 'string'];
    $data[]                                 = ['name' => 'password', 'type' => 'string'];
    $datab                                  = [];
    $datab[]                                = ['name' => 'uri', 'type' => 'string'];
    $datab[]                                = ['name' => 'useragent', 'type' => 'string'];
    $datab[]                                = ['name' => 'netaddy', 'type' => 'string'];
    $datab[]                                = ['name' => 'ip', 'type' => 'string'];
    $datab[]                                = ['name' => 'server-ip', 'type' => 'string'];
    $datab[]                                = ['name' => 'when', 'type' => 'string'];
    $datab[]                                = ['name' => 'sitename', 'type' => 'string'];
    $datab[]                                = ['name' => 'robot-id', 'type' => 'string'];
    $datab[]                                = ['name' => 'robot-name', 'type' => 'string'];
    $data[]                                 = ['items' => ['statistic' => $datab, 'objname' => 'statistic']];
    $xsd['request'][$i]['items']['data']    = $data;
    $xsd['request'][$i]['items']['objname'] = 'data';

    $xsd['response'][] = ['name' => 'ban_made', 'type' => 'boolean'];
    $xsd['response'][] = ['name' => 'made', 'type' => 'integer'];
    return $xsd;
}

function spiderstat_wsdl()
{
}

function spiderstat_wsdl_service()
{
}

// Define the method as a PHP function
/**
 * @param $username
 * @param $password
 * @param $statistic
 * @return array
 */
function spiderstat($username, $password, $statistic)
{
    global $xoopsModuleConfig, $xoopsDB;

    if ($xoopsModuleConfig['site_user_auth'] == 1) {
        if ($ret = check_for_lock(basename(__FILE__), $username, $password)) {
            return $ret;
        }
        if (!checkright(basename(__FILE__), $username, $password)) {
            mark_for_lock(basename(__FILE__), $username, $password);
            return ['ErrNum' => 9, 'ErrDesc' => 'No Permission for plug-in'];
        }
    }

    $spiderHandler = xoops_getModuleHandler('spiders', 'spiders');
    $memberHandler = xoops_getHandler('member');

    $modulehandler = xoops_getHandler('module');
    $confighandler = xoops_getHandler('config');
    $xoModule      = $modulehandler->getByDirname('spiders');
    $xoConfig      = $confighandler->getConfigList($xoModule->getVar('mid'), false);

    $statisticsHandler = xoops_getModuleHandler('statistics', 'spiders');

    $ban = $spiderHandler->banDetails($statistic['netaddy']);

    if ($ban !== false) {
        return ['ban_made' => $ban, 'made' => time()];
    }

    $spiders = $spiderHandler->getObjects(null);

    foreach ($spiders as $spider) {
        if (strtolower($spider->getVar('robot-id')) == strtolower($statistic['robot-id'])) {
            $id        = $spider->getVar('id');
            $thespider = $spider;
        }
    }

    $stat = $statisticsHandler->create();
    $stat->setVar('id', $id);
    $stat->setVar('useragent', $statistic['useragent']);
    $stat->setVar('uri', $statistic['uri']);
    $stat->setVar('netaddy', $statistic['netaddy']);
    $stat->setVar('ip', $statistic['ip']);
    $stat->setVar('server-ip', $statistic['server-ip']);
    $stat->setVar('when', $statistic['when']);
    $stat->setVar('sitename', $statistic['sitename']);

    $status = $statisticsHandler->insert($stat) ? true : false;

    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('spiders_statistics') . " WHERE `when` < '" . (time() - (24 * 60 * 60 * 3)) . "'";
    @$GLOBALS['xoopsDB']->queryF($sql);

    if (stripos($_SERVER['HTTP_HOST'], 'xortify.com')) {
        define('XORTIFY_API_URI', 'http://xortify.chronolabs.coop/soap/');
    } else {
        define('XORTIFY_API_URI', 'http://xortify.com/soap/');
    }

    define('XORTIFY_USER_AGENT', 'Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.0.2) XOOPS/20100101 XoopsAuth/1.xx (php)');

    if (!$ch = curl_init(str_replace('soap', 'ban', XORTIFY_API_URI))) {
        trigger_error('Could not intialise CURLSERIAL file: ' . XORTIFY_API_URI);
        return ['stat_made' => $status, 'made' => time()];
    }
    $cookies = XOOPS_VAR_PATH . '/cache/xoops_cache/authcurl_' . md5(XORTIFY_API_URI) . '.cookie';

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, XORTIFY_USER_AGENT);

    $data = curl_exec($ch);
    curl_close($ch);

    if (stripos($data, 'solve puzzel') > 0) {
        $sc     = new soapclient(null, ['location' => XORTIFY_API_URI, 'uri' => XORTIFY_API_URI]);
        $result = $sc->__soapCall('rep_spiderstat', [
            'username'  => $username,
            'password'  => $password,
            'statistic' => $statistic
        ]);
    }
    return ['stat_made' => $status, 'made' => time()];
}
