<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * found_itemes
 *
 * @ORM\Table(name="found_itemes")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\found_itemesRepository")
 */
class found_itemes
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
     * @ORM\Column(name="found_on", type="datetime")
     */
    private $foundOn;

    /**
     * @var string
     *
     * @ORM\Column(name="found_area", type="string", length=255)
     */
    private $foundArea;

    /**
     * @var string
     *
     * @ORM\Column(name="other_info", type="string", length=255,nullable=true)
     */
    private $otherInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_info", type="string", length=255,nullable=true)
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return found_itemes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return found_itemes
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set foundOn
     *
     * @param \DateTime $foundOn
     *
     * @return found_itemes
     */
    public function setFoundOn($foundOn)
    {
        $this->foundOn = $foundOn;

        return $this;
    }

    /**
     * Get foundOn
     *
     * @return \DateTime
     */
    public function getFoundOn()
    {
        return $this->foundOn;
    }

    /**
     * Set foundArea
     *
     * @param string $foundArea
     *
     * @return found_itemes
     */
    public function setFoundArea($foundArea)
    {
        $this->foundArea = $foundArea;

        return $this;
    }

    /**
     * Get foundArea
     *
     * @return string
     */
    public function getFoundArea()
    {
        return $this->foundArea;
    }

    /**
     * Set otherInfo
     *
     * @param string $otherInfo
     *
     * @return found_itemes
     */
    public function setOtherInfo($otherInfo)
    {
        $this->otherInfo = $otherInfo;

        return $this;
    }

    /**
     * Get otherInfo
     *
     * @return string
     */
    public function getOtherInfo()
    {
        return $this->otherInfo;
    }

    /**
     * Set contactInfo
     *
     * @param string $contactInfo
     *
     * @return found_itemes
     */
    public function setContactInfo($contactInfo)
    {
        $this->contactInfo = $contactInfo;

        return $this;
    }

    /**
     * Get contactInfo
     *
     * @return string
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
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

