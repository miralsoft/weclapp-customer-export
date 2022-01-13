<?php

namespace miralsoft\weclapp\customerexport;


use miralsoft\weclapp\api\Customer;

class Export
{
    /** @var Customer The api call for customers */
    protected Customer $customer;

    /** @var array The customers loaded from weclapp */
    protected array $customers = array();

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
     */
    public function __construct(bool $generateCSVFile = false, string $path = '', string $fileName = 'export.csv')
    {
        $this->setGenerateCSVFile($generateCSVFile);
        $this->setPath($path);
        $this->setFileName($fileName);
        $this->customer = new Customer();
        $this->getCustomers();
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
     * @return array
     */
    protected function getCustomers()
    {
        if (!is_array($this->customers) || count($this->customers) <= 0) {
            $this->customers = $this->customer->getAll();
        }

        return $this->customers;
    }

    /**
     * Exports the customers in a csv for datev
     * @return bool|array true = erfolgreich | false = nicht erfolgreich
     *                      if a array, all csv-data as array
     */
    public function exportDatevOnline($consultantNo, $clientNo)
    {
        // If some customers are found
        if (is_array($this->customers) && count($this->customers) > 0) {
            $csvData = [
                ["EXTF", 700, 16, "Debitoren/Kreditoren", 4, date('YmdHisu'), "", "", "", "", $consultantNo,
                    $clientNo, 20210101, 4, "", "", "", "", "", "", "", "", "", "", "", 0, ""],
                ["Konto", "Name (Adressattyp Unternehmen)", "Unternehmensgegenstand", "Name (Adressattyp natürl. Person)",
                    "Vorname (Adressattyp natürl. Person)", "Name (Adressattyp keine Angabe)", "Adressattyp", "Kurzbezeichnung",
                    "EU-Land", "EU-UStID", "Anrede", "Titel/Akad. Grad", "Adelstitel", "Namensvorsatz", "Adressart", "Straße",
                    "Postfach", "Postleitzahl", "Ort", "Land", "Versandzusatz", "Adresszusatz", "Abweichende Anrede",
                    "Abw. Zustellbezeichnung 1", "Abw. Zustellbezeichnung 2", "Kennz. Korrespondenzadresse", "Adresse Gültig von",
                    "Adresse Gültig bis", "Telefon", "Bemerkung (Telefon)", "Telefon GL", "Bemerkung (Telefon GL)", "E-Mail",
                    "Bemerkung (E-Mail)", "Internet", "Bemerkung (Internet)", "Fax", "Bemerkung (Fax)", "Sonstige",
                    "Bemerkung (Sonstige)", "Bankleitzahl 1", "Bankbezeichnung 1", "Bank-Kontonummer 1", "Länderkennzeichen 1",
                    "IBAN-Nr. 1", "Leerfeld", "SWIFT-Code 1", "Abw. Kontoinhaber 1", "Kennz. Hauptbankverb. 1", "Bankverb 1 Gültig von",
                    "Bankverb 1 Gültig bis", "Bankleitzahl 2", "Bankbezeichnung 2", "Bank-Kontonummer 2", "Länderkennzeichen 2",
                    "IBAN-Nr. 2", "Leerfeld", "SWIFT-Code 2", "Abw. Kontoinhaber 2", "Kennz. Hauptbankverb. 2", "Bankverb 2 Gültig von",
                    "Bankverb 2 Gültig bis", "Bankleitzahl 3", "Bankbezeichnung 3", "Bank-Kontonummer 3", "Länderkennzeichen 3",
                    "IBAN-Nr. 3", "Leerfeld", "SWIFT-Code 3", "Abw. Kontoinhaber 3", "Kennz. Hauptbankverb. 3", "Bankverb 3 Gültig von",
                    "Bankverb 3 Gültig bis", "Bankleitzahl 4", "Bankbezeichnung 4", "Bank-Kontonummer 4", "Länderkennzeichen 4",
                    "IBAN-Nr. 4", "Leerfeld", "SWIFT-Code 4", "Abw. Kontoinhaber 4", "Kennz. Hauptbankverb. 4", "Bankverb 4 Gültig von",
                    "Bankverb 4 Gültig bis", "Bankleitzahl 5", "Bankbezeichnung 5", "Bank-Kontonummer 5", "Länderkennzeichen 5",
                    "IBAN-Nr. 5", "Leerfeld", "SWIFT-Code 5", "Abw. Kontoinhaber 5", "Kennz. Hauptbankverb. 5", "Bankverb 5 Gültig von",
                    "Bankverb 5 Gültig bis", "Leerfeld", "Briefanrede", "Grußformel", "Kunden-/Lief.-Nr.", "Steuernummer",
                    "Sprache", "Ansprechpartner", "Vertreter", "Sachbearbeiter", "Diverse-Konto", "Ausgabeziel", "Währungssteuerung",
                    "Kreditlimit (Debitor)", "Zahlungsbedingung", "Fälligkeit in Tagen (Debitor)", "Skonto in Prozent (Debitor)",
                    "Kreditoren-Ziel 1 Tg.", "Kreditoren-Skonto 1 %", "Kreditoren-Ziel 2 Tg.", "Kreditoren-Skonto 2 %",
                    "Kreditoren-Ziel 3 Brutto Tg.", "Kreditoren-Ziel 4 Tg.", "Kreditoren-Skonto 4 %", "Kreditoren-Ziel 5 Tg.",
                    "Kreditoren-Skonto 5 %", "Mahnung", "Kontoauszug", "Mahntext 1", "Mahntext 2", "Mahntext 3", "Kontoauszugstext",
                    "Mahnlimit Betrag", "Mahnlimit %", "Zinsberechnung", "Mahnzinssatz 1", "Mahnzinssatz 2", "Mahnzinssatz 3",
                    "Lastschrift", "Leerfeld", "Mandantenbank", "Zahlungsträger", "Indiv. Feld 1", "Indiv. Feld 2", "Indiv. Feld 3",
                    "Indiv. Feld 4", "Indiv. Feld 5", "Indiv. Feld 6", "Indiv. Feld 7", "Indiv. Feld 8", "Indiv. Feld 9", "Indiv. Feld 10"]
            ];

            // This are the fields from weclapp, to use for csv file
            $weclappFields = array('customerNumber', 'company', '', '', '', '', '', 'companyShort', '', '', 'salutation',
                'title', '', '', '', 'street1', '', 'zipcode', 'city', 'countryCode', '', '', '', '', '', '', '', '', 'phone', '',
                '', '', 'email', '', 'website', '', 'fax', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'customerNumber', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '');

            // loop all customers and add the data
            foreach ($this->customers as $customer) {
                $cCustomer = new WeclappCustomer($customer);
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

            return $this->isGenerateCSVFile() ? $this->generateCSV($csvData) : $csvData;
        }
    }

    /**
     * Generates the CSV file with the given data
     *
     * @param array $csvData the data for the csv
     * @return bool
     */
    protected function generateCSV(array $csvData)
    {
        // If dirs not can be maked, abort here
        if (!$this->makedirs($this->path)) return false;

        $file = fopen($this->path . $this->fileName, 'w');
        foreach ($csvData as $data) {
            if (!fputcsv($file, $data, ';')) {
                fclose($file);
                return false;
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