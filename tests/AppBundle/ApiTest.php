<?php
/**
 * This file is part of the TakeawayDemoApplication package.
 *  (c) Ahmad Sajid <ahmadsajid1989@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 */

namespace Tests\AppBundle;


use AppBundle\DataFixtures\LoadResturantData;
use Tests\AppBundle\DataFixtures\DataFixtureTest;

class ApiTest extends DataFixtureTest
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        // Base fixture for all tests
        $this->addFixture(new LoadResturantData());
        $this->executeFixtures();
    }

    /**
     *
     */
    public function testGetRestaurantAction() {

        $baseUrl = getenv('TEST_BASE_URL');
        $client = new \GuzzleHttp\Client([
            'base_uri' => $baseUrl,
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $response = $client->get('api/restaurant/');
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('payload', $responseData);

        foreach ($responseData as $data) {

            $this->assertArrayHasKey('id', $data[0]);
            $this->assertArrayHasKey('name', $data[0]);
            $this->assertArrayHasKey('branch', $data[0]);
            $this->assertArrayHasKey('phone', $data[0]);
            $this->assertArrayHasKey('email', $data[0]);
            $this->assertArrayHasKey('logo', $data[0]);
            $this->assertArrayHasKey('address', $data[0]);
            $this->assertArrayHasKey('housenumber', $data[0]);
            $this->assertArrayHasKey('postcode', $data[0]);
            $this->assertArrayHasKey('city', $data[0]);
            $this->assertArrayHasKey('latitude', $data[0]);
            $this->assertArrayHasKey('longitude', $data[0]);
            $this->assertArrayHasKey('url', $data[0]);
            $this->assertArrayHasKey('open', $data[0]);
            $this->assertArrayHasKey('best_match', $data[0]);
            $this->assertArrayHasKey('newest_score', $data[0]);
            $this->assertArrayHasKey('rating_average', $data[0]);
            $this->assertArrayHasKey('popularity', $data[0]);
            $this->assertArrayHasKey('average_product_price', $data[0]);
            $this->assertArrayHasKey('delivery_costs', $data[0]);
            $this->assertArrayHasKey('minimum_order_amount', $data[0]);

        }

    }



}