<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Features context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    use Behat\Symfony2Extension\Context\KernelDictionary;
}