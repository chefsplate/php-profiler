<?php namespace ChefsPlate\Tests\Profiler;

use PHPUnit_Framework_TestCase;

/**
 * Class ProfilerTest
 * @test ChefsPlate\Profiler\Profiler
 * @package ChefsPlate\Tests\Profiler
 * @author Will Salemé <william.saleme@chefsplate.com>
 */
class ProfilerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the setting of available options
     * TODO: Implement complete unit test of Profiler class
     * @covers \ChefsPlate\Profiler\Profiler::setPrecision
     * @covers \ChefsPlate\Profiler\Profiler::enableLogging
     * @covers \ChefsPlate\Profiler\Profiler::disableLogging
     * @covers \ChefsPlate\Profiler\Profiler::setCumulative
     */
    public function testOptions(){
        $this->markTestSkipped();
    }

    /**
     * Test Marking logic
     * TODO: Implement complete unit test of Profiler class
     * @covers \ChefsPlate\Profiler\Profiler::mark
     */
    public function testMark(){
        $this->markTestSkipped();
    }

    /**
     * Test Profiling logic
     * TODO: Implement complete unit test of Profiler class
     * @covers \ChefsPlate\Profiler\Profiler::profile
     */
    public function testProfile(){
        $this->markTestSkipped();
    }

    /**
     * Test the Internal Time Offset of Profiler
     * TODO: Implement complete unit test of Profiler class
     * @covers \ChefsPlate\Profiler\Profiler::mark
     * @covers \ChefsPlate\Profiler\Profiler::profile
     */
    public function testInternalTimeOffset(){
        $this->markTestSkipped();
    }

    /**
     * Test Profiling from initial Mark
     * TODO: Implement complete unit test of Profiler class
     * @covers \ChefsPlate\Profiler\Profiler::mark
     * @covers \ChefsPlate\Profiler\Profiler::profile
     */
    public function testProfileFromMark(){
        $this->markTestSkipped();
    }

    /**
     * Test Profiling from last Profiling Point
     * TODO: Implement complete unit test of Profiler class
     * @covers \ChefsPlate\Profiler\Profiler::mark
     * @covers \ChefsPlate\Profiler\Profiler::profile
     */
    public function testProfileFromLastProfile(){
        $this->markTestSkipped();
    }
}
