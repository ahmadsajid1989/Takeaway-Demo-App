<?php


namespace AppBundle\Services\CSV;



use Symfony\Component\Filesystem\Exception\FileNotFoundException;
/**
 * Class CSVValidator
 * @package AppBundle\Services\CSV
 */
class CSVValidator
{

    /**
     * @param $file
     *
     * @return bool
     * @throws \Exception
     */
    public function validateFile($file)
    {

        if (!file_exists($file)) {
            throw new \Exception("Either files doesn't exist or not found");
        }

        $mimeType = mime_content_type($file);

        $allowedFileType = array(
            'application/csv',
            'application/x-csv',
            'text/plain',
            'text/csv',
            'text/comma-separated-values',
            'text/x-comma-separated-values',
            'text/tab-separated-values'
        );

        $flipped_haystack = array_flip($allowedFileType);

        if (isset($flipped_haystack[$mimeType])) {
            return true;
        }
        return false;

    }


    /**
     * @param $file
     *
     * @return bool
     */
    public function validateHeader($file) {

        if(!$file){
            return false;
        }

        $csv = array_map("str_getcsv", file($file,FILE_SKIP_EMPTY_LINES));

        $headers = array_values($csv[0]);

        $expectedHeaders = ["id","name","branch","phone","email","logo","address","housenumber","postcode","city","latitude","longitude","url","open","bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount"];

        if($expectedHeaders === $headers) {
            return true;
        }

        return false;
    }


}