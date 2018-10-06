<?php

namespace JvrSolis\ArrayMacros\Test;

use ReflectionClass;
use PHPUnit\Framework\TestCase as BaseTestCase;
use JvrSolis\ArrayMacros\ArrayMacroServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Test the setup of the service provider.
     *
     * @throws \ReflectionException
     */
    public function setUp()
    {
        $this->createDummyProvider()->register();
    }

    /**
     * Generate a dummy array macro service provider.
     *
     * @return \JvrSolis\ArrayMacros\ArrayMacroServiceProvider
     * @throws \ReflectionException
     */
    protected function createDummyProvider() : ArrayMacroServiceProvider
    {
        $reflectionClass = new ReflectionClass(ArrayMacroServiceProvider::class);

        return $reflectionClass->newInstanceWithoutConstructor();
    }
}