<?php

require_once '../../vendor/autoload.php';

use miralsoft\weclapp\api\Config;
use miralsoft\weclapp\customerexport\Export;

Config::$URI = 'https://xxx.weclapp.com/webapp/api/v1/';
Config::$TOKEN = 'xxx';

$customerStart = 12070;

$export = new Export(true, 'export', 'datevExport.csv', $customerStart);
$data = $export->exportDatevOnline();
$lastCustomerNo = $export->getLastCustomerNo();

if ($export->isGenerateCSVFile()) {
    echo $data ? 'File successfull created' : 'Error while export';
    echo '<br><br>The last exported customer no is: ' . $lastCustomerNo;
}
else    print_r($data);
