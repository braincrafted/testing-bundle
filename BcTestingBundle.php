<?php

namespace Bc\Bundle\TestingBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

use Bc\Bundle\TestingBundle\DependencyInjection\Compiler\TranslatorCompilerPass;

class BcTestingBundle extends Bundle
{
    /** @var KernelInterface */
    private $kernel;

    /**
     * Constructor.
     *
     * @param KernelInterface $kernel The kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TranslatorCompilerPass($this->kernel));
    }
}
