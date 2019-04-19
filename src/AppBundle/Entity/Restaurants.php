<?php
/**
 * This file is part of the TakeawayDemoApplication package.
 * (c) Ahmad Sajid <ahmadsajid1989@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\AccessType;
use Swagger\Annotations as SWG;

/**
 * Restaurants
 *
 * @AccessType("public_method")
 * @SWG\Definition()
 * @codeCoverageIgnore
 */
class Restaurants
{
    /**
     * @var integer
     * @SWG\Property(description="restaurant id")
     */
    private $id;

    /**
     * @var string
     * @SWG\Property(description="restaurant name")
     */
    private $name;

    /**
     * @var string
     */
    private $branch;

    /**
     * @var integer
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $housenumber;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $open;

    /**
     * @var integer
     */
    private $best_match;

    /**
     * @var integer
     */
    private $newest_score;

    /**
     * @var integer
     */
    private $rating_average;

    /**
     * @var integer
     */
    private $popularity;

    /**
     * @var string
     */
    private $average_product_price;

    /**
     * @var string
     */
    private $delivery_costs;

    /**
     * @var string
     */
    private $minimum_order_amount;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }



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

    /**
     * Set branch
     *
     * @param string $branch
     *
     * @return Restaurants
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Restaurants
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Restaurants
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Restaurants
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Restaurants
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set housenumber
     *
     * @param string $housenumber
     *
     * @return Restaurants
     */
    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;

        return $this;
    }

    /**
     * Get housenumber
     *
     * @return string
     */
    public function getHousenumber()
    {
        return $this->housenumber;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Restaurants
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Restaurants
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Restaurants
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Restaurants
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Restaurants
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
     * Set open
     *
     * @param integer $open
     *
     * @return Restaurants
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return integer
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set bestMatch
     *
     * @param integer $bestMatch
     *
     * @return Restaurants
     */
    public function setBestMatch($bestMatch)
    {
        $this->best_match = $bestMatch;

        return $this;
    }

    /**
     * Get bestMatch
     *
     * @return integer
     */
    public function getBestMatch()
    {
        return $this->best_match;
    }

    /**
     * Set newestScore
     *
     * @param integer $newestScore
     *
     * @return Restaurants
     */
    public function setNewestScore($newestScore)
    {
        $this->newest_score = $newestScore;

        return $this;
    }

    /**
     * Get newestScore
     *
     * @return integer
     */
    public function getNewestScore()
    {
        return $this->newest_score;
    }

    /**
     * Set ratingAverage
     *
     * @param integer $ratingAverage
     *
     * @return Restaurants
     */
    public function setRatingAverage($ratingAverage)
    {
        $this->rating_average = $ratingAverage;

        return $this;
    }

    /**
     * Get ratingAverage
     *
     * @return integer
     */
    public function getRatingAverage()
    {
        return $this->rating_average;
    }

    /**
     * Set popularity
     *
     * @param integer $popularity
     *
     * @return Restaurants
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity
     *
     * @return integer
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Set averageProductPrice
     *
     * @param string $averageProductPrice
     *
     * @return Restaurants
     */
    public function setAverageProductPrice($averageProductPrice)
    {
        $this->average_product_price = $averageProductPrice;

        return $this;
    }

    /**
     * Get averageProductPrice
     *
     * @return string
     */
    public function getAverageProductPrice()
    {
        return $this->average_product_price;
    }

    /**
     * Set deliveryCosts
     *
     * @param string $deliveryCosts
     *
     * @return Restaurants
     */
    public function setDeliveryCosts($deliveryCosts)
    {
        $this->delivery_costs = $deliveryCosts;

        return $this;
    }

    /**
     * Get deliveryCosts
     *
     * @return string
     */
    public function getDeliveryCosts()
    {
        return $this->delivery_costs;
    }

    /**
     * Set minimumOrderAmount
     *
     * @param string $minimumOrderAmount
     *
     * @return Restaurants
     */
    public function setMinimumOrderAmount($minimumOrderAmount)
    {
        $this->minimum_order_amount = $minimumOrderAmount;

        return $this;
    }

    /**
     * Get minimumOrderAmount
     *
     * @return string
     */
    public function getMinimumOrderAmount()
    {
        return $this->minimum_order_amount;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Restaurants
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Restaurants
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->created_at = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }




}

