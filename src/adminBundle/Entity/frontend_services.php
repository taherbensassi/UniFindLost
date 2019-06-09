<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * frontend_services
 *
 * @ORM\Table(name="frontend_services")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\frontend_servicesRepository")
 */
class frontend_services
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
     * @ORM\Column(name="heading_section", type="string", length=255)
     */
    private $headingSection;

    /**
     * @var string
     *
     * @ORM\Column(name="service_name", type="string", length=255)
     */
    private $serviceName;

    /**
     * @var string
     *
     * @ORM\Column(name="service_icon", type="string", length=255)
     */
    private $serviceIcon;

    /**
     * @var string
     *
     * @ORM\Column(name="service_description", type="string", length=255)
     */
    private $serviceDescription;


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
     * @return frontend_services
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
     * Set serviceName
     *
     * @param string $serviceName
     *
     * @return frontend_services
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * Get serviceName
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Set serviceIcon
     *
     * @param string $serviceIcon
     *
     * @return frontend_services
     */
    public function setServiceIcon($serviceIcon)
    {
        $this->serviceIcon = $serviceIcon;

        return $this;
    }

    /**
     * Get serviceIcon
     *
     * @return string
     */
    public function getServiceIcon()
    {
        return $this->serviceIcon;
    }

    /**
     * Set serviceDescription
     *
     * @param string $serviceDescription
     *
     * @return frontend_services
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    /**
     * Get serviceDescription
     *
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }
}

