<?php

namespace BackendBundle\Entity;

/**
 * Restaurants
 */
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;
 /**
     * @SWG\Definition(
     *   definition="restaurant"
     * )
     */

class Restaurants
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
	 * @SWG\Property(example="doggie")
     */

    private $description;

    /**
     * @var string
     */
    private $minOrder;

    /**
     * @var string
     */
    private $deliveryCost;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $num;

    /**
     * @var string
     */
    private $postCode;

    /**
     * @var string
     */
    private $days;

    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var \BackendBundle\Entity\Users
     */
    private $user;


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
     * Set description
     *
     * @param string $description
     *
     * @return Restaurants
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set minOrder
     *
     * @param string $minOrder
     *
     * @return Restaurants
     */
    public function setMinOrder($minOrder)
    {
        $this->minOrder = $minOrder;

        return $this;
    }

    /**
     * Get minOrder
     *
     * @return string
     */
    public function getMinOrder()
    {
        return $this->minOrder;
    }

    /**
     * Set deliveryCost
     *
     * @param string $deliveryCost
     *
     * @return Restaurants
     */
    public function setDeliveryCost($deliveryCost)
    {
        $this->deliveryCost = $deliveryCost;

        return $this;
    }

    /**
     * Get deliveryCost
     *
     * @return string
     */
    public function getDeliveryCost()
    {
        return $this->deliveryCost;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Restaurants
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Restaurants
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Restaurants
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set num
     *
     * @param string $num
     *
     * @return Restaurants
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return Restaurants
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set days
     *
     * @param string $days
     *
     * @return Restaurants
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return string
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Restaurants
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Restaurants
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\Users $user
     *
     * @return Restaurants
     */
    public function setUser(\BackendBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BackendBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Restaurants
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
}
