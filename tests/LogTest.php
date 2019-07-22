<?php


use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
{
    function testLog()
    {
        $logger = new logger('test');
        $logger->writelog('logvalue-test');
        $this->assertFileExists($logger->logfile);
        $logfile = $logger->logfile;
        unset($logger);
        $data = file_get_contents($logfile);
        $this->assertStringContainsString('logvalue-test', $data);
    }
    function testFallback()
    {
        if(file_exists('/dev/null'))
            $logger = new logger('test', '/dev/null');
        else // /dev/null is a valid path on windows
            $logger = new logger('test', '//invalid');
        $this->assertFileExists($logger->logfile);
        $this->assertStringContainsString(realpath('logs'), $logger->logpath);
    }
}