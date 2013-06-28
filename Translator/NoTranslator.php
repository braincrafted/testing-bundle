<?php
/*
 * This file is part of BcTestingBundle.
 *
 * (c) Florian Eckerstorfer
 */

namespace Bc\Bundle\TestingBundle\Translator;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * NoTranslator.
 *
 * @author Florian Eckerstorfer <florian@eckerstorfer.co>
 */
class NoTranslator implements TranslatorInterface
{
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
}
