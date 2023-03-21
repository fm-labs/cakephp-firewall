<?php
declare(strict_types=1);

namespace Firewall;

use Admin\Core\BaseAdminPlugin;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\Routing\RouteBuilder;


/**
 * Class Admin
 *
 * @package Media
 */
class FirewallAdmin extends BaseAdminPlugin implements EventListenerInterface
{
    /**
     * @inheritDoc
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->connect(
            '/',
            ['plugin' => 'Firewall', 'controller' => 'Firewall', 'action' => 'index']
        );
        $routes->connect('/panel', ['plugin' => 'Firewall', 'controller' => 'Shieldon', 'action' => 'index']);
        $routes->connect('/panel/**', ['plugin' => 'Firewall', 'controller' => 'Shieldon', 'action' => 'index']);
        $routes->fallbacks('DashedRoute');
        $routes->applyMiddleware('firewall');
    }

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Admin.Menu.build.admin_system' => ['callable' => 'buildAdminSystemMenu', 'priority' => 80],
        ];
    }

    /**
     * @param \Cake\Event\Event $event
     * @param \Cupcake\Menu\MenuItemCollection $menu
     * @return void
     */
    public function buildAdminSystemMenu(EventInterface $event, \Cupcake\Menu\MenuItemCollection $menu): void
    {
        $menu->addItem([
            'title' => 'Firewall',
            'url' => ['plugin' => 'Firewall', 'controller' => 'Firewall', 'action' => 'index'],
            'data-icon' => 'shield',
            'children' => [],
        ]);
    }

}
