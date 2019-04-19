<?php
/**
 * This file is part of the TakeawayDemoApplication package.
 *  (c) Ahmad Sajid <ahmadsajid1989@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Restaurants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadResturantData extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $restaurant = new Restaurants();
        $restaurant->setId(1);
        $restaurant->setName('KFC');
        $restaurant->setBranch('Amsterdam');
        $restaurant->setEmail('kfc@local.com');
        $restaurant->setLogo('/logo/kfc.png');
        $restaurant->setAddress('randomAddress');
        $restaurant->setHousenumber("25");
        $restaurant->setPostcode('2s');
        $restaurant->setCity('Amsterdam');
        $restaurant->setPhone(1234567891);
        $restaurant->setLatitude(54.65676590000);
        $restaurant->setLongitude(95.65478643567);
        $restaurant->setUrl('https://kfc.com');
        $restaurant->setOpen(2);
        $restaurant->setBestMatch(392);
        $restaurant->setNewestScore(2404);
        $restaurant->setRatingAverage(8);
        $restaurant->setPopularity(84);
        $restaurant->setAverageProductPrice(25.00);
        $restaurant->setDeliveryCosts(1.76);
        $restaurant->setMinimumOrderAmount(1.76);

        $metadata  =  $manager->getClassMetadata(get_class($restaurant));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

        $manager->persist($restaurant);
        $manager->flush();


    }
}