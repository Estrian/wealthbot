<?php

namespace Wealthbot\ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountTwrValue
 */
class AccountTwrValue
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var float
     */
    protected $netValue;

    /**
     * @var float
     */
    protected $grossValue;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $accountNumber;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set net value
     *
     * @param float $netValue
     * @return this
     */
    public function setNetValue($netValue)
    {
        $this->netValue = $netValue;

        return $this;
    }

    /**
     * Get net value
     *
     * @return float
     */
    public function getNetValue()
    {
        return $this->netValue;
    }

    /**
     * Set gross value
     *
     * @param float $grossValue
     * @return this
     */
    public function setGrossValue($grossValue)
    {
        $this->grossValue = $grossValue;

        return $this;
    }

    /**
     * Get gross value
     *
     * @return float
     */
    public function getGrossValue()
    {
        return $this->grossValue;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set account_number
     *
     * @param string $accountNumber
     * @return this
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get account_number
     *
     * @return string 
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
}
