<?php


namespace Tests\AppBundle\Services;


use AppBundle\Services\CSV\CSVValidator;

use PHPUnit\Framework\TestCase;



/**
 * Class CSVValidatorTest
 * @package Tests\AppBundle
 */
class CSVValidatorTest extends TestCase
{
    /**
     * @var
     */
    private $validator;

    protected function setUp(){

        $this->validator = new CSVValidator();
    }


    public function testValidFile() {

        $correctFile = __DIR__.'/../Fixtures/example.csv';
        $wrongFile = __DIR__.'/../Fixtures/empty.csv';
        $wrongExt = __DIR__.'/../Fixtures/wrongExt.pdf';

        $this->assertFileNotExists($this->validator->validateFile(''),"Either files doesn't exist or not found");
//        $this->assertTrue($this->validator->validateFile($correctFile));
//        $this->assertFileNotExists($this->validator->validateFile($wrongFile),"Invalid CSV File");
//        $this->assertFileNotExists($this->validator->validateFile($wrongExt),"Invalid CSV File");
    }

    public function testValidateData() {

//        $correctFile = __DIR__.'/../Fixtures/sample.csv';
//        $this->assertTrue($this->validator->validateData($correctFile));
    }



}