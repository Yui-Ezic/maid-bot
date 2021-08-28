<?php

declare(strict_types=1);

namespace Test\Functional\Botman;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Drivers\Tests\FakeDriver;
use BotMan\BotMan\Drivers\Tests\ProxyDriver;
use BotMan\Studio\Testing\BotManTester;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Slim\App;

class TestCase extends BaseTestCase
{
    private ?App $app = null;
    private ?BotManTester $botManTester = null;

    protected function bot(): BotManTester
    {
        if ($this->botManTester) {
            return $this->botManTester;
        }

        $fakeDriver = new FakeDriver();
        ProxyDriver::setInstance($fakeDriver);

        $this->botManTester = new BotManTester($this->botMan(), $fakeDriver);

        return $this->botManTester;
    }

    private function botMan(): BotMan
    {
        return $this->app()->getContainer()->get(BotMan::class);
    }

    private function app(): App
    {
        if ($this->app === null) {
            $this->app = (require __DIR__ . '/../../../config/app.php')($this->container());
        }
        return $this->app;
    }

    private function container(): ContainerInterface
    {
        /** @var ContainerInterface */
        return require __DIR__ . '/../../../config/container.php';
    }
}