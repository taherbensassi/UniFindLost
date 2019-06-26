<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * search_area
 *
 * @ORM\Table(name="search_area")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\search_areaRepository")
 */
class search_area
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="desciption", type="text",nullable=true)
     */
    private $desciption;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text",nullable=true)
     */
    private $html;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime",nullable=true)
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity="adminBundle\Entity\User")
     * @ORM\JoinColumn(name="customer_id",referencedColumnName="id",onDelete="CASCADE")
     */
    public $customer;

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
     * Set url
     *
     * @param string $url
     *
     * @return search_area
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getDesciption()
    {
        return $this->desciption;
    }

    /**
     * @param string $desciption
     */
    public function setDesciption($desciption)
    {
        $this->desciption = $desciption;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param string $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }



    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return search_area
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }


}

