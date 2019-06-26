<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * frontend_about
 *
 * @ORM\Table(name="frontend_about")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\frontend_aboutRepository")
 */
class frontend_about
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
     * @ORM\Column(name="heading_section", type="string", length=255,nullable=true)
     */
    private $headingSection;

    /**
     * @var string
     *
     * @ORM\Column(name="description_section", type="string", length=1000)
     */
    private $descriptionSection;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


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
     * Set headingSection
     *
     * @param string $headingSection
     *
     * @return frontend_about
     */
    public function setHeadingSection($headingSection)
    {
        $this->headingSection = $headingSection;

        return $this;
    }

    /**
     * Get headingSection
     *
     * @return string
     */
    public function getHeadingSection()
    {
        return $this->headingSection;
    }

    /**
     * Set descriptionSection
     *
     * @param string $descriptionSection
     *
     * @return frontend_about
     */
    public function setDescriptionSection($descriptionSection)
    {
        $this->descriptionSection = $descriptionSection;

        return $this;
    }

    /**
     * Get descriptionSection
     *
     * @return string
     */
    public function getDescriptionSection()
    {
        return $this->descriptionSection;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return frontend_about
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
}

