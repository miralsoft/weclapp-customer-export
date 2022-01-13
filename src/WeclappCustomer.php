<?php

namespace miralsoft\weclapp\customerexport;


use miralsoft\weclapp\customerexport\Traits\ArrayMappableTrait;
use miralsoft\weclapp\customerexport\Traits\IArrayMappable;

class WeclappCustomer implements IArrayMappable
{
    // use mappable trait
    use ArrayMappableTrait;

    /** @var array All Data from this customer */
    protected array $data = array();

    /** @var array The adresses from customer */
    protected array $addresses;

    protected $birthDate;

    /** @var bool Is the customer blocked */
    protected bool $blocked;

    /** @var string The notice why customer is blocked */
    protected string $blockNotice;

    /** @var string Company name */
    protected string $company;

    /** @var string Company name */
    protected string $company2;

    /** @var string The customer number */
    protected string $customerNumber;

    /** @var string Mail from customer */
    protected string $email;

    /** @var string Firstname from customer */
    protected string $firstName;

    /** @var string Lastname from customer */
    protected string $lastName;

    /** @var string The mobile phone number from customer */
    protected string $mobilePhone1;

    /** @var string The phone number from customer */
    protected string $phone;

    /** @var string The VAT number from customer */
    protected string $vatRegistrationNumber;

    /** @var string The website from customer */
    protected string $website;

    /** @var int The date, when the customer were modifed last */
    protected int $lastModifiedDate;

    /**
     * @param array|null $data The data from customer
     */
    public function __construct(?array $data)
    {
        if ($data != null) {
            $this->setData($data);
            // If data is set, map to the cariables
            $this->mapFromArray($data);
        }
    }

    /**
     * Gives the data from field
     *
     * @param string $field the field wich is searched
     * @return mixed|string the correct data
     */
    public function get(string $field)
    {
        $data = '';

        if (is_array($this->data) && count($this->data) > 0) {
            switch ($field) {
                // if a field is from a address, get it from the first address
                case 'street1':
                case 'street2':
                case 'city':
                case 'zipcode':
                case 'countryCode':
                    $address = $this->getAddresses();
                    if (is_array($address) && count($address) > 0 && isset($address[0]) && isset($address[0][$field])) {
                        $data = $address[0][$field];
                    }
                    break;
                case 'company':
                    if(isset($this->data[$field]) && $this->data[$field] != ''){
                        $data = $this->data[$field];
                    } else {
                        $data = isset($this->data['lastName']) ? $this->data['lastName'] : '';
                        $data .= ($data != '' ? ', ' : '') . (isset($this->data['firstName']) ? $this->data['firstName'] : '');
                    }
                    break;
                case 'phone':
                    $data = isset($this->data[$field]) && $this->data[$field] != '' ? $this->data[$field] : (isset($this->data['mobilephone1']) ? $this->data['mobilephone1'] : '');
                    break;
                default:
                    // if the field in the data, take it
                    if (isset($this->data[$field])) {
                        $data = $this->data[$field];
                    }
            }
        }

        return $data;
    }

    /**
     * Sets the data from the customer
     *
     * @param array $data the data from customer
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param array $addresses
     */
    public function setAddresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->blocked;
    }

    /**
     * @param bool $blocked
     */
    public function setBlocked(bool $blocked): void
    {
        $this->blocked = $blocked;
    }

    /**
     * @return string
     */
    public function getBlockNotice(): string
    {
        return $this->blockNotice;
    }

    /**
     * @param string $blockNotice
     */
    public function setBlockNotice(string $blockNotice): void
    {
        $this->blockNotice = $blockNotice;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getCompany2(): string
    {
        return $this->company2;
    }

    /**
     * @param string $company2
     */
    public function setCompany2(string $company2): void
    {
        $this->company2 = $company2;
    }

    /**
     * @return string
     */
    public function getCustomerNumber(): string
    {
        return $this->customerNumber;
    }

    /**
     * @param string $customerNumber
     */
    public function setCustomerNumber(string $customerNumber): void
    {
        $this->customerNumber = $customerNumber;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getMobilePhone1(): string
    {
        return $this->mobilePhone1;
    }

    /**
     * @param string $mobilePhone1
     */
    public function setMobilePhone1(string $mobilePhone1): void
    {
        $this->mobilePhone1 = $mobilePhone1;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getVatRegistrationNumber(): string
    {
        return $this->vatRegistrationNumber;
    }

    /**
     * @param string $vatRegistrationNumber
     */
    public function setVatRegistrationNumber(string $vatRegistrationNumber): void
    {
        $this->vatRegistrationNumber = $vatRegistrationNumber;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite(string $website): void
    {
        $this->website = $website;
    }

    /**
     * @return int
     */
    public function getLastModifiedDate(): int
    {
        return $this->lastModifiedDate;
    }

    /**
     * @param int $lastModifiedDate
     */
    public function setLastModifiedDate(int $lastModifiedDate): void
    {
        $this->lastModifiedDate = $lastModifiedDate;
    }


}