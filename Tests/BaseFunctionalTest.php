<?php

/**
 * BaseFunctionalTest
 *
 * @category   Test
 * @package    BraincraftedTestingBundle
 * @subpackage Tests
 * @author     Florian Eckerstorfer
 * @copyright  2012 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://braincrafted.com Braincrafted
 * @link       http://florianeckerstorfer.com Florian Eckerstorfer
 */


namespace Braincrafted\TestingBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * BaseFunctionalTest
 *
 * @category   Test
 * @package    BraincraftedTestingBundle
 * @subpackage Tests
 * @author     Florian Eckerstorfer
 * @copyright  2012 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://braincrafted.com Braincrafted
 * @link       http://florianeckerstorfer.com Florian Eckerstorfer
 */
abstract class BaseFunctionalTest extends \PHPUnit_Framework_TestCase
{
    protected $kernel;
    protected $application;

    /**
     * Sets up the kernel.
     *
     */
    protected function setUpKernel()
    {
        $kernel = new \AppKernel("test", true);
        $kernel->boot();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
        $this->runConsole("doctrine:mongodb:schema:drop");
        $this->runConsole("davidbadura:fixtures:load");
    }

    /**
     * Runs the given console command.
     *
     * @param string $command The command to execute
     * @param array  $options The options array
     *
     * @return integer 0 if everything went fine, a positive integer otherwise
     */
    protected function runConsole($command, Array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $this->application->run(new ArrayInput($options));
    }

    /**
     * Returns the container.
     *
     * @return ContainerInterface The container
     */
    public function getContainer()
    {
        return $this->application->getKernel()->getContainer();
    }
}
