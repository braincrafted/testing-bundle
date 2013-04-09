<?php
/**
 * This file is part of BraincraftedTestingBundle.
 *
 * (c) 2012-2013 Florian Eckerstorfer
 */

namespace Braincrafted\TestingBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * BaseFunctionalTest
 *
 * @category   Test
 * @package    BraincraftedTestingBundle
 * @subpackage Test
 * @author     Florian Eckerstorfer
 * @copyright  2012 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
abstract class BaseFunctionalTest extends \PHPUnit_Framework_TestCase
{
    /** @var Application */
    private $application;

    /**
     * Sets up the kernel.
     *
     * @return void
     */
    protected function setUpKernel()
    {
        $kernel = new \AppKernel("test", true);
        $kernel->boot();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);
        $this->runConsole("doctrine:schema:drop", array("--force" => true));
        $this->runConsole("doctrine:schema:create");
        $this->runConsole("doctrine:fixtures:load", array("--no-interaction" => true));
    }

    /**
     * Runs the given console command.
     *
     * @param string $command The command to execute
     * @param array  $options The options array
     *
     * @return integer 0 if everything went fine, a positive integer otherwise
     */
    protected function runConsole($command, array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $this->application->run(new ArrayInput($options));
    }

    /**
     * Returns the container.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface The container
     */
    public function getContainer()
    {
        return $this->application->getKernel()->getContainer();
    }
}
