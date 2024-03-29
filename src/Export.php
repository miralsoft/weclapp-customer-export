<?php

namespace miralsoft\weclapp\customerexport;


use miralsoft\weclapp\api\Customer;

class Export
{
    /** @var Customer The api call for customers */
    protected Customer $customer;

    /** @var array The customers loaded from weclapp */
    protected array $customers = array();

    /** @var int The number of the last exported customer */
    protected int $lastCustomerNo = 0;

    /** @var bool if true the file will be generated, otherwise, the date will get as array */
    protected bool $generateCSVFile = false;

    /** @var string The path were the file will be saved */
    protected string $path = '';

    /** @var string The name of the export file */
    protected string $fileName = 'export.csv';

    /**
     * @param bool $generateCSVFile if true the file will be generated, otherwise, the date will get as array
     * @param string $path The path were the file will be saved
     * @param string $fileName the filename for export file
     * @param int $startCustNo The customer number where the export start
     */
    public function __construct(bool $generateCSVFile = false, string $path = '', string $fileName = 'export.csv', int $startCustNo = 0)
    {
        $this->setGenerateCSVFile($generateCSVFile);
        $this->setPath($path);
        $this->setFileName($fileName);
        $this->customer = new Customer();
        $this->getCustomers($startCustNo);
    }

    /**
     * Set the path for the export file
     *
     * @param string $path the path for export file
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        if ($this->path != '' && substr($this->path, -1) != DIRECTORY_SEPARATOR) {
            $this->path .= DIRECTORY_SEPARATOR;
        }
    }

    /**
     * Sets the filename of the export
     *
     * @param string $fileName the filename
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Sets wheather a csv file will be generated
     *
     * @param bool $generate true = file will be generated
     */
    public function setGenerateCSVFile(bool $generate)
    {
        $this->generateCSVFile = $generate;
    }

    /**
     * Will a csv file be generated
     *
     * @return bool true = file will generated | false = no file will generated
     */
    public function isGenerateCSVFile(): bool
    {
        return $this->generateCSVFile;
    }

    /**
     * The path for the csv file
     *
     * @return string the path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * The filename for the csv file
     *
     * @return string the filename
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Loads the customers from weclapp
     *
     * @param int $startCustNo The customer number where the export start
     * @return array
     */
    protected function getCustomers(int $startCustNo = 0)
    {
        if (!is_array($this->customers) || count($this->customers) <= 0) {
            $customers = $this->customer->getAll('customerNumber');
            $startKey = 0;

            if ($startCustNo > 0) {
                foreach ($customers as $key => $customer) {
                    $cCustomer = new WeclappCustomer($customer);
                    if (intval($cCustomer->getCustomerNumber()) >= $startCustNo) {
                        $startKey = $key;
                        break;
                    }
                }

                // Gets only the customers from startID
                $this->customers = array_slice($customers, $startKey);
            } else {
                $this->customers = $customers;
            }
        }

        return $this->customers;
    }

    /**
     * Get the last customer number that was exported
     *
     * @return int The last exported customer number
     */
    public function getLastCustomerNo(): int
    {
        return $this->lastCustomerNo;
    }

    /**
     * Exports the customers in a csv for datev
     * @return bool|array true = erfolgreich | false = nicht erfolgreich
     *                      if a array, all csv-data as array
     */
    public function exportDatevOnline()
    {
        // If some customers are found
        if (is_array($this->customers) && count($this->customers) > 0) {
            $csvData = [];
            $weclappFields = array('company', 'city', 'customerNumber', 'customerNumber', 'vatRegistrationNumber',
                '', '', '', '', '', '', '', '', 'street1', 'zipcode', '', '', 'phone', 'email', 'fax', 'website',
                'countryCode', '');

            // loop all customers and add the data
            foreach ($this->customers as $customer) {
                $cCustomer = new WeclappCustomer($customer);

                // Anonymous company will be ignoerd
                if ($cCustomer->get('company') == 'ANONYMOUS_COMPANY') continue;

                // Gets the customer number and saves if it is the biggest
                $cusNo = $cCustomer->get('customerNumber');
                if (isset($cusNo) && is_numeric($cusNo) && $this->lastCustomerNo < $cusNo) {
                    $this->lastCustomerNo = $cusNo;
                }

                $customerData = [];

                // Gets all data from weclappfields
                foreach ($weclappFields as $field) {
                    if ($field != '') {
                        array_push($customerData, $cCustomer->get($field));
                    } else {
                        array_push($customerData, '');
                    }
                }

                array_push($csvData, $customerData);
            }

            return $this->isGenerateCSVFile() ? $this->generateCSV($csvData, true) : $csvData;
        }
    }

    /**
     * Generates the CSV file with the given data
     *
     * @param array $csvData the data for the csv
     * @return bool
     */
    protected function generateCSV(array $csvData, bool $withoutEnclosure = false)
    {
        // If dirs not can be maked, abort here
        if (!$this->makedirs($this->path)) return false;

        $file = fopen($this->path . $this->fileName, 'w');
        foreach ($csvData as $data) {
            if ($withoutEnclosure) {
                // In datev we need ansi format
                fwrite($file, utf8_decode(implode(';', $data) . "\r\n"));
            } else {
                if (!fputcsv($file, $data, ';')) {
                    fclose($file);
                    return false;
                }
            }
        }

        fclose($file);

        return true;
    }

    /**
     * Make dirs if not exists
     *
     * @param $dirpath
     * @param $mode
     * @return bool
     */
    protected function makedirs(string $dirpath, $mode = 0777)
    {
        // Only if a path is set
        if ($dirpath == '') return true;

        return is_dir($dirpath) || mkdir($dirpath, $mode, true);
    }
}