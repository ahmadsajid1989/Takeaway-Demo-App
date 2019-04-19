<?php

namespace AppBundle\Command;

use AppBundle\Entity\Restaurants;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;



class CsvImportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('takeaway:csv:import')
            ->addOption('dir', null, InputOption::VALUE_OPTIONAL, 'directory name, where the csv file is present')
            ->addOption('fileName', null, InputOption::VALUE_OPTIONAL, 'csv file file name which will be imported')
            ->setDescription('This command will help you import csv file into database')
            ->setHelp(<<<'EOT'
The <info>%command.name%</info> command imports the CSV file into database).

  <info>php %command.full_name%</info>


To use a different directory than default, use
<info>--dir</info> option. if you use this option, file name will be mandatory.

  <info>php %command.full_name%  --dir=data/</info>

To use different file name than default data.csv, add the <info>--fileName</info> option:

  <info>php %command.full_name% public --dir=data --fileName=custom.csv</info>

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->newLine();

        $io->title('initializing csv import..');

        if($input->getOption('dir')){

            if(empty($input->getOption('fileName')))
            {
                $io->error("fileName must be given when directory name is present. add --fileName=data.csv");
                throw new InvalidArgumentException();
            }
        }

        $io->text('checking the directory existence');

        $baseDir = $this->getContainer()->getParameter('kernel.project_dir');

        // remove mistakenly placed backward slash for making the command compatible with different filesystem i.e windows
        $targetArg = rtrim($input->getOption('dir'), '/');


        // setting fallback directory to data if dir is not mentioned
        if (!$targetArg) {
            $targetArg = $this->getContainer()->getParameter('kernel.project_dir') . '/data';
        }


         //checking if the mentioned dir is a directory and whether it exists
        if (!is_dir($targetArg)) {
            $targetArg = (isset($baseDir) ? $baseDir : $this->getContainer()->getParameter('kernel.project_dir')).'/'.$targetArg;

            if (!is_dir($targetArg)) {
                if (is_dir(\dirname($targetArg).'/data')) {
                    $targetArg = \dirname($targetArg).'/data';
                } else {
                    throw new InvalidArgumentException(sprintf('The directory "%s" does not exist.', $targetArg));
                }
            }
        }

        $io->note('directory exists....');

        $io->text('validating the csv file....');


        // getting file name from argument
        $fileArg = $input->getOption('fileName');

        // file name is not mentioned use default
        if(!$fileArg) {
            $fileArg = $targetArg . '/data.csv';
        }else{

            $fileArg = $targetArg. '/'. $fileArg;
        }

        $validator = $this->getContainer()->get('csv.validator');
        $validateFile = $validator->validateFile($fileArg);

        if(!$validateFile) {
            $io->error("File is not a vaild csv file");
        }

        $validateHeader = $validator->validateHeader($fileArg);

        if(!$validateHeader) {
            $io->error("This file can not be imported.");
        }

        $io->note("csv file validated....");

        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();

        $perm = $io->confirm("This will truncate restaurant table. proceed?");

        if($perm) {

            $cmd = $em->getClassMetadata(Restaurants::class);
            $connection = $em->getConnection();
            $connection->beginTransaction();

            try {
                $connection->query('SET FOREIGN_KEY_CHECKS=0');
                $connection->query('DELETE FROM '.$cmd->getTableName());
                $connection->query('SET FOREIGN_KEY_CHECKS=1');
                $connection->commit();

            } catch (\Exception $e) {
                $connection->rollback();
                $io->error('Truncating failed!! rolling back... ');
            }

            $io->note('Table truncated');

            $io->text("starting import");

            $serializer = $this->getContainer()->get('serializer');
            $records = $serializer->decode(file_get_contents($fileArg),'csv');
            $io->progressStart();

            foreach ($records as $record) {

                $io->progressAdvance();

                $lat = (float)($record['latitude']);
                $lon = (float)($record['longitude']);
                $phone = (int)preg_replace('/[\s\-]+/', '', $record['phone']);
                $open = (int)$record['open'];
                $bestMatch = (int)$record['bestMatch'];
                $ratingAverage = (int)$record['ratingAverage'];
                $newestScore = (int)$record['newestScore'];
                $popularity = (int)$record['popularity'];
                $averageProductPrice = (float)$record['averageProductPrice'];
                $deliveryCosts = (float)$record['deliveryCosts'];
                $minimumOrderAmount = (float)$record['minimumOrderAmount'];
                $open = gettype($open) != 'integer' ? '' : $open;
                $bestMatch = gettype($bestMatch) != 'integer' ? '' : $bestMatch;
                $newestScore = gettype($newestScore) != 'integer' ? '' : $newestScore;
                $popularity = gettype($popularity) != 'integer' ? '' : $popularity;
                $ratingAverage = gettype($ratingAverage) != 'integer' ? '' : $ratingAverage;
                $averageProductPrice = gettype($averageProductPrice) != 'double' ? '' : $averageProductPrice;
                $deliveryCosts = gettype($deliveryCosts) != 'double' ? '' : $deliveryCosts;
                $minimumOrderAmount = gettype($minimumOrderAmount) != 'double' ? '' : $minimumOrderAmount;
                $lat = gettype($lat) != 'double' ? Null : $lat;
                $lon = gettype($lon) != 'double' ? Null : $lon;

                if($ratingAverage > 10){
                    $ratingAverage = null;
                    $io->warning(sprintf("wrong rating average value skipping this field of restaurant id %s", $record['id']));
                }

                try {
                    $restaurant = new Restaurants();
                    $restaurant->setId($record['id']);
                    $restaurant->setName($record['name']);
                    $restaurant->setBranch($record['branch']);
                    $restaurant->setEmail($record['email']);
                    $restaurant->setLogo($record['logo']);
                    $restaurant->setAddress($record['address']);
                    $restaurant->setHousenumber($record['housenumber']);
                    $restaurant->setPostcode($record['postcode']);
                    $restaurant->setCity($record['city']);
                    $restaurant->setPhone($phone);
                    $restaurant->setLatitude($lat);
                    $restaurant->setLongitude($lon);
                    $restaurant->setUrl($record['url']);
                    $restaurant->setOpen($open);
                    $restaurant->setBestMatch($bestMatch);
                    $restaurant->setNewestScore($newestScore);
                    $restaurant->setRatingAverage($ratingAverage);
                    $restaurant->setPopularity($popularity);
                    $restaurant->setAverageProductPrice($averageProductPrice);
                    $restaurant->setDeliveryCosts($deliveryCosts);
                    $restaurant->setMinimumOrderAmount($minimumOrderAmount);
                    $metadata = $em->getClassMetadata(get_class($restaurant));
                    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                    $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
                    $em->persist($restaurant);
                    $em->flush();
                    $em->clear();
                } catch (\Exception $e) {

                    $io->error(sprintf("error occurred during import %s,", $e->getMessage()));
                }
            }

            $io->progressFinish();

            $io->success("import was successful!! enjoy..");
        }



    }
}
