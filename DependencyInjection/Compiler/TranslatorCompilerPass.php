<?php

namespace Bc\Bundle\TestingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\KernelInterface;

class TranslatorCompilerPass implements CompilerPassInterface
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
    public function process(ContainerBuilder $container)
    {
        if ('test' === $this->kernel->getEnvironment()) {
            $definition = $container->getDefinition('translator.default');
            $definition->setClass('Bc\Bundle\TestingBundle\Translator\NoTranslator');
        }
    }
}
