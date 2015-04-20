<?php
/*
 * This file is part of BraincraftedTestingBundle.
 *
 * (c) 2013-2015 Florian Eckerstorfer <florian@eckerstorfer.co>
 */

namespace Braincrafted\Bundle\TestingBundle\Translator;

use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * NoTranslator.
 *
 * @author Florian Eckerstorfer <florian@eckerstorfer.co>
 */
class NoTranslator implements TranslatorInterface, TranslatorBagInterface
{
    /**
     * @var MessageCatalogue
     */
    protected $catalogue;

    public function __construct()
    {
        $this->catalogue = new MessageCatalogue('--');
    }

    /**
     * {@inheritDoc}
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return $id;
    }

    /**
     * {@inheritDoc}
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        return $id;
    }

    /**
     * {@inheritDoc}
     */
    public function setLocale($locale)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getLocale()
    {
        return '--';
    }

    public function setFallbackLocales($locale)
    {
    }

    public function addResource($resource)
    {
    }

    /**
     * {@inheritDoc
     */
    public function getCatalogue($locale = null)
    {
        return $this->catalogue;
    }
}
