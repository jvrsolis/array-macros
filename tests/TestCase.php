<?php

namespace VoicingEwe\ArrayMacros\Test;

use ReflectionClass;
use PHPUnit\Framework\TestCase as BaseTestCase;
use VoicingEwe\ArrayMacros\ArrayMacroServiceProvider;

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
     * @return \VoicingEwe\ArrayMacros\ArrayMacroServiceProvider
     * @throws \ReflectionException
     */
    protected function createDummyProvider() : ArrayMacroServiceProvider
    {
        $reflectionClass = new ReflectionClass(ArrayMacroServiceProvider::class);

        return $reflectionClass->newInstanceWithoutConstructor();
    }
}