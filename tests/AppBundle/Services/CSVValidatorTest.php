<?php


namespace Tests\AppBundle\Services;


use AppBundle\Services\CSV\CSVValidator;

use Exception;
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

    /**
     *
     */
    protected function setUp(){

        $this->validator = new CSVValidator();
    }


    /**
     *
     */
    public function testValidFile() {

        $correctFile = __DIR__.'/../Fixtures/example.csv';
        $wrongFile = __DIR__.'/../Fixtures/empty.csv';
        $wrongExt = __DIR__.'/../Fixtures/wrongExt.pdf';

        //checking with right file
        $this->assertTrue($this->validator->validateFile($correctFile));

        //checking with corrupted file
        $this->assertFalse($this->validator->validateFile($wrongFile));
        //checking wrong file ext
        $this->assertFalse($this->validator->validateFile($wrongExt));



    }
    /**
     * @expectedException Exception
     */

    public function testValidateFileException() {

        $this->validator->validateFile('');

    }


    /**
     * Validate header method
     */
    public function testValidateData() {

        $correctFile = __DIR__.'/../Fixtures/sample.csv';
        //checking with right headers
        $this->assertTrue($this->validator->validateHeader($correctFile));
        //checking with empty file
        $this->assertFalse($this->validator->validateHeader(''));
    }

    public function testValidateHeader() {

        $correctFile = __DIR__.'/../Fixtures/wrongHeader.csv';
        //checking with wrong headers
        $this->assertFalse($this->validator->validateHeader($correctFile));

    }



}