<?php

declare(strict_types=1);

namespace PhpMyAdmin\Tests;

use PhpMyAdmin\Routing;
use FastRoute\Dispatcher;
use PhpMyAdmin\Controllers\HomeController;

/**
 * Tests for PhpMyAdmin\Routing
 */
class RoutingTest extends PmaTestCase
{
    /**
     * Test for Routing::getDispatcher
     *
     * @return void
     */
    public function testGetDispatcher(): void
    {
        $dispatcher = Routing::getDispatcher();
        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
        $this->assertSame([
            Dispatcher::FOUND,
            [
                HomeController::class,
                'index',
            ],
            [],
        ], $dispatcher->dispatch('GET', '/'));
    }

    /**
     * Test for Routing::getCurrentRoute
     *
     * @return void
     */
    public function testGetCurrentRouteNoParams(): void
    {
        $this->assertSame('/', Routing::getCurrentRoute());
    }

    /**
     * Test for Routing::getCurrentRoute
     *
     * @return void
     */
    public function testGetCurrentRouteGet(): void
    {
        $_GET['route'] = '/test';
        $this->assertSame('/test', Routing::getCurrentRoute());
    }

    /**
     * Test for Routing::getCurrentRoute
     *
     * @return void
     */
    public function testGetCurrentRoutePost(): void
    {
        $_POST['route'] = '/testpost';
        $this->assertSame('/testpost', Routing::getCurrentRoute());
    }

    /**
     * Test for Routing::getCurrentRoute
     *
     * @return void
     */
    public function testGetCurrentRouteGetIsOverPost(): void
    {
        $_GET['route'] = '/testget';
        $_POST['route'] = '/testpost';
        $this->assertSame('/testget', Routing::getCurrentRoute());
    }

    /**
     * Test for Routing::getCurrentRoute
     *
     * @return void
     */
    public function testGetCurrentRouteRedirectDbStructure(): void
    {
        $_GET['db'] = 'testDB';
        $this->assertSame('/database/structure', Routing::getCurrentRoute());
    }

    /**
     * Test for Routing::getCurrentRoute
     *
     * @return void
     */
    public function testGetCurrentRouteRedirectSql(): void
    {
        $_GET['db'] = 'testDB';
        $_GET['table'] = 'tableTest';
        $this->assertSame('/sql', Routing::getCurrentRoute());
    }
}
