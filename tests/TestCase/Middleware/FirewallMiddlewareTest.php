<?php
declare(strict_types=1);

namespace Firewall\Test\TestCase\Middleware;

use Cake\TestSuite\TestCase;
use Firewall\Middleware\FirewallMiddleware;

/**
 * Firewall\Middleware\FirewallMiddleware Test Case
 */
class FirewallMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Firewall\Middleware\FirewallMiddleware
     */
    protected $Firewall;

    /**
     * Test process method
     *
     * @return void
     * @uses \Firewall\Middleware\FirewallMiddleware::process()
     */
    public function testProcess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
