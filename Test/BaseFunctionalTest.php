<?php
/**
 * This file is part of BcTestingBundle.
 *
 * (c) 2012-2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\TestingBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * BaseFunctionalTest
 *
 * @category   Test
 * @package    BcTestingBundle
 * @subpackage Test
 * @author     Florian Eckerstorfer
 * @copyright  2012 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
abstract class BaseFunctionalTest extends \PHPUnit_Framework_TestCase
{
    /** @var \AppKernel */
    protected $kernel;

    /** @var Application */
    protected $application;

    /**
     * Sets up the kernel.
     *
     * @return void
     */
    protected function setUpKernel()
    {
        if (null !== $this->kernel) {
            $this->tearDownKernel();
        }

        $this->kernel = $this->createKernel(array('environment' => 'test', 'debug' => true));
        $this->kernel->boot();

        $this->application = new Application($this->kernel);
        $this->application->setAutoExit(false);

        $this->runConsole("doctrine:schema:drop", array("--force" => true));
        $this->runConsole("doctrine:schema:create");
        $this->runConsole("doctrine:fixtures:load", array("--no-interaction" => true));
    }

    protected function tearDownKernel()
    {
        if (null !== $this->kernel) {
            $this->kernel->shutdown();
        }
    }

    /**
     * Creates an AppKernel.
     *
     * @param  array  $options The array with options for the kernel.
     *
     * @return \AppKernel The app kernel
     */
    protected function createKernel(array $options = array())
    {
        return new \AppKernel(
            isset($options['environment']) ? $options['environment'] : 'test',
            isset($options['debug']) ? $options['debug'] : true
        );
    }

    /**
     * Creates a Client.
     *
     * @param array $options An array of options to pass to the createKernel class
     * @param array $server  An array of server parameters
     *
     * @return Client A Client instance
     */
    protected function createClient(array $options = array(), array $server = array())
    {
        if (null === $this->kernel) {
            $this->setUpKernel();
        }

        $client = $this->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
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
        return $this->kernel->getContainer();
    }
}
