<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * found_itemes
 *
 * @ORM\Table(name="lost_itemes")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\lost_itemesRepository")
 */
class lost_itemes
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lost_on", type="datetime")
     */
    private $lostOn;

    /**
     * @var string
     *
     * @ORM\Column(name="lost_area", type="string", length=255)
     */
    private $lostArea;

    /**
     * @var string
     *
     * @ORM\Column(name="other_info", type="string", length=255)
     */
    private $otherInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_info", type="string", length=255)
     */
    private $contactInfo;


    /**
     * @ORM\ManyToOne(targetEntity="adminBundle\Entity\category_itemes")
     * @ORM\JoinColumn(name="categoy_id",referencedColumnName="id",onDelete="CASCADE")
     */
    public $category;

    /**
     * @ORM\ManyToOne(targetEntity="adminBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id",onDelete="CASCADE")
     */
    public $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return \DateTime
     */
    public function getLostOn()
    {
        return $this->lostOn;
    }

    /**
     * @param \DateTime $lostOn
     */
    public function setLostOn($lostOn)
    {
        $this->lostOn = $lostOn;
    }

    /**
     * @return string
     */
    public function getLostArea()
    {
        return $this->lostArea;
    }

    /**
     * @param string $lostArea
     */
    public function setLostArea($lostArea)
    {
        $this->lostArea = $lostArea;
    }

    /**
     * @return string
     */
    public function getOtherInfo()
    {
        return $this->otherInfo;
    }

    /**
     * @param string $otherInfo
     */
    public function setOtherInfo($otherInfo)
    {
        $this->otherInfo = $otherInfo;
    }

    /**
     * @return string
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * @param string $contactInfo
     */
    public function setContactInfo($contactInfo)
    {
        $this->contactInfo = $contactInfo;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



}

