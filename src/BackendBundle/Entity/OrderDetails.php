<?php

namespace BackendBundle\Entity;

/**
 * OrderDetails
 */
class OrderDetails
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
     * @var \BackendBundle\Entity\Orders
     */
    private $order;

    /**
     * @var \BackendBundle\Entity\Products
     */
    private $product;
	
	private $products;
 public function setProducts(\BackendBundle\Entity\Products $product = null)
    {
        $this->products = $product;

        return $this;
    }

    public function getProducts()
    {
        return $this->products;
    }

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
     * @return OrderDetails
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
     * Set order
     *
     * @param \BackendBundle\Entity\Orders $order
     *
     * @return OrderDetails
     */
    public function setOrder(\BackendBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \BackendBundle\Entity\Orders
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \BackendBundle\Entity\Products $product
     *
     * @return OrderDetails
     */
    public function setProduct(\BackendBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \BackendBundle\Entity\Products
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * @var integer
     */
    private $quantity = '1';


    /**
     * Set quantity
     *
     * @param boolean $quantity
     *
     * @return OrderDetails
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return boolean
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
