<?php
/**
 * This file is part of the TakeawayDemoApplication package.
 *  (c) Ahmad Sajid <ahmadsajid1989@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 */

namespace Tests\AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Tester\CommandTester;
use Exception;

/**
 * Class CsvImportCommandTest
 * @package Tests\AppBundle\Command
 */
class CsvImportCommandTest extends KernelTestCase
{
    protected static $application;

    protected static function getApplication()
    {
        $kernel = static::createKernel();

        self::$application = new Application($kernel);
        self::$application->setAutoExit(false);
        return self::$application;
    }

    /**
     * default test case
     */
    public function testExecute() {

        $application = self::getApplication();

        $command = $application->find('takeaway:csv:import');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['yes']);

        $commandTester->execute([
            'command'  => $command->getName(),

        ]);

        $this->assertContains('import was successful!! enjoy..', $commandTester->getDisplay());

    }

    public function testExecuteWithDir() {

        $application = self::getApplication();

        $command = $application->find('takeaway:csv:import');
        $commandTester = new CommandTester($command);
        $this->expectException(InvalidArgumentException::class);

        $commandTester->execute([
            'command'  => $command->getName(),
            '--dir' => 'data'
        ]);
    }

    public function testExecuteWithInvalidDir() {

        $application = self::getApplication();

        $command = $application->find('takeaway:csv:import');
        $commandTester = new CommandTester($command);
        $this->expectException(InvalidArgumentException::class);

        $commandTester->execute([
            'command'  => $command->getName(),
            '--dir' => 'dat'
        ]);
    }





}