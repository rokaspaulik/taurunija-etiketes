<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XLabel
 *
 * @ORM\Table(name="x_label")
 * @ORM\Entity(repositoryClass="App\Repository\XLabelRepository")
 */
class XLabel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="fabric", type="string", length=255)
     */
    private $fabric;

    /**
     * @var string
     *
     * @ORM\Column(name="structure", type="string", length=255)
     */
    private $structure;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="string", length=255)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=14)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=14)
     */
    private $info;

    /**
     * @var string
     *
     * @ORM\Column(name="symbols", type="string", length=10, nullable=true)
     */
    private $symbols;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_ip", type="string", length=45)
     */
    private $ownerIp;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return XLabel
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return XLabel
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return XLabel
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set symbols
     *
     * @param string $symbols
     *
     * @return XLabel
     */
    public function setSymbols($symbols)
    {
        $this->symbols = $symbols;

        return $this;
    }

    /**
     * Get symbols
     *
     * @return string
     */
    public function getSymbols()
    {
        return $this->symbols;
    }

    /**
     * @return string
     */
    public function getFabric()
    {
        return $this->fabric;
    }

    /**
     * @param string $fabric
     */
    public function setFabric($fabric)
    {
        $this->fabric = $fabric;
    }

    /**
     * @return string
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     * @param string $structure
     */
    public function setStructure($structure)
    {
        $this->structure = $structure;
    }

    /**
     * @return string
     */
    public function getOwnerIp()
    {
        return $this->ownerIp;
    }

    /**
     * @param $ip
     */
    public function setOwnerIp($ip)
    {
        $this->ownerIp = $ip;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }
}

