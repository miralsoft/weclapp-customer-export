<?php

require_once '../../vendor/autoload.php';

use miralsoft\weclapp\api\Config;
use miralsoft\weclapp\customerexport\Export;

Config::$URI = 'https://xxx.weclapp.com/webapp/api/v1/';
Config::$TOKEN = 'xxx';

$export = new Export(true, 'export', 'datevExport.csv');
$data = $export->exportDatevOnline();

if ($export->isGenerateCSVFile()) echo $data ? 'File successfull created' : 'Error while export';
else    print_r($data);
