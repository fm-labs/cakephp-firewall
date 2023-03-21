<?php
declare(strict_types=1);

namespace Firewall;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\RouteBuilder;
use Firewall\Middleware\FirewallMiddleware;

/**
 * Plugin for Firewall
 */
class FirewallPlugin extends BasePlugin
{

    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        /**
         * Shieldon
         */
        $storageDir = TMP . 'shieldon_firewall';
        if (!is_dir($storageDir)) {
            @mkdir($storageDir);
        }

        /**
         * Configuration / Settings
         */
        Configure::load('Firewall.firewall');
        if (\Cake\Core\Plugin::isLoaded("Settings")) {
            Configure::load('Firewall', 'settings');
        }

        /**
         * Admin
         */
        if (\Cake\Core\Plugin::isLoaded("Admin")) {
            \Admin\Admin::addPlugin(new FirewallAdmin());
        }
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        /**
         * Apply Shieldon Firewall to the current route scope.
         */
//        $routes->registerMiddleware(
//            'firewall',
//            new FirewallMiddleware()
//        );
//        $routes->applyMiddleware('firewall');


//        $routes->plugin(
//            'Firewall',
//            ['path' => '/firewall'],
//            function (RouteBuilder $builder) {
//                $builder->connect('/panel', ['controller' => 'Shieldon', 'action' => 'index']);
//                $builder->connect('/panel/**', ['controller' => 'Shieldon', 'action' => 'index']);
//                $builder->fallbacks();
//            }
//        );
        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        if (Configure::read('Firewall.enabled')) {
            $middlewareQueue->insertBefore(RoutingMiddleware::class, new FirewallMiddleware());
        }

        return $middlewareQueue;
    }

    /**
     * Add commands for the plugin.
     *
     * @param \Cake\Console\CommandCollection $commands The command collection to update.
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        // Add your commands here

        $commands = parent::console($commands);

        return $commands;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        // Add your services here
    }
}
