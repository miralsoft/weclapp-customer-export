<?php

require_once '../../vendor/autoload.php';

use miralsoft\weclapp\api\Config;
use miralsoft\weclapp\customerexport\Export;

Config::$URI = 'https://xxx.weclapp.com/webapp/api/v1/';
Config::$TOKEN = 'xxx';

$export = new Export(true,'', 'datevExport.csv');
$ok = $export->exportDatevOnline('XXX', 'XXX');

echo $ok ? 'File successfull created' : 'Error while export';
