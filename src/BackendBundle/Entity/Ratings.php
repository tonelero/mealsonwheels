<?php

namespace BackendBundle\Entity;

/**
 * Ratings
 */
class Ratings
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $text;

    /**
     * @var integer
     */
    private $points;

    /**
     * @var \BackendBundle\Entity\Restaurants
     */
    private $restaurant;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ratings
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
     * Set text
     *
     * @param string $text
     *
     * @return Ratings
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Ratings
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set restaurant
     *
     * @param \BackendBundle\Entity\Restaurants $restaurant
     *
     * @return Ratings
     */
    public function setRestaurant(\BackendBundle\Entity\Restaurants $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \BackendBundle\Entity\Restaurants
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\Users $user
     *
     * @return Ratings
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
}
