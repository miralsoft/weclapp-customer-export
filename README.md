# weclapp-customer-export
Export customers from weclapp with the weclapp PHP api.

# How to use
You can download the Package over composer with following line in composer File:

```
"require": {
    "php": ">=7.4.0",<br>
    "miralsoft/weclapp-customer-export": ">=v1"
}
```

# Configuration
The configuration have to been set in your PHP-Project. You must define 2 constants like this:

```
use miralsoft\weclapp\api\Config;

Config::$URI = 'https://xxx.weclapp.com/webapp/api/v1/';
Config::$TOKEN = 'xxx';
```

Replace the xxx with your own data.

# Call the export
With following code you can call the export:

```
$export = new Export();
$csvData = $export->exportDatevOnline('XXX', 'XXX');
```
Here you get the array for the csv file.
<br><br>
```
$export = new Export(true);
$csvData = $export->exportDatevOnline('XXX', 'XXX');
```
Here it will be created a csv file in your actual path with the filename 'datevExport.csv'.
<br><br>
```
$export = new Export(true, 'export', 'filename.csv');
$csvData = $export->exportDatevOnline('XXX', 'XXX');
```
Here a file will be created in the folder export with the name 'filename.csv'.

# Full example
To get a list of customers, here is a example:

```
require_once '../../vendor/autoload.php';

use miralsoft\weclapp\api\Config;
use miralsoft\weclapp\customerexport\Export;

Config::$URI = 'https://xxx.weclapp.com/webapp/api/v1/';
Config::$TOKEN = 'xxx';

$export = new Export(true, '', 'datevExport.csv');
$ok = $export->exportDatevOnline('XXX', 'XXX');

echo $ok ? 'File successfull created' : 'Error while export';
```