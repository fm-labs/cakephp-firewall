<?php
/**
 * Firewall middleware using Shieldon.
 *
 * This class derives from the shielon's integration for CakePHP (made for CakePHP 3),
 * which is broken in CakePHP 4.
 *
 * Shieldon Docs:
 *   https://shieldon.io/en/docs/
 *
 * Shieldon CakePHP Integration guide:
 *   https://shieldon.io/en/guide/cakephp.html
 *
 * @see \Shieldon\Firewall\Integration\CakePhp
 */
declare(strict_types=1);

namespace Firewall\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shieldon\Firewall\Captcha\Csrf;
use Shieldon\Firewall\Firewall;
use Shieldon\Firewall\HttpResolver;

/**
 * Firewall middleware
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * The absolute path of the storage where stores Shieldon generated data.
     *
     * @var string
     */
    protected string $storage;

    /**
     * The entry point of Shieldon Firewall's control panel.
     *
     * For example: https://yoursite.com/firewall/panel/
     * Just use the path component of a URI.
     *
     * @var string
     */
    protected string $panelUri;

    /**
     * Constructor.
     *
     * @param string $storage  See property `storage` explanation.
     * @param string $panelUri See property `panelUri` explanation.
     *
     * @return void
     */
    public function __construct(string $storage = '', string $panelUri = '')
    {
        // The constant TMP is the path of CakePHP's tmp folder.
        // The Shieldon generated data is stored at that place.
        $this->storage = TMP . 'shieldon_firewall';
        $this->panelUri = '/admin/firewall/panel/';

        if ('' !== $storage) {
            $this->storage = $storage;
        }

        if ('' !== $panelUri) {
            $this->panelUri = $panelUri;
        }
    }

    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \Cake\Http\ServerRequest $request */
        /** @var \Shieldon\Firewall\Kernel $kernel */

        $firewall = new Firewall($request);
        $firewall->configure($this->storage);
        //$firewall->setConfig('admin.user', 'foo');
        //$firewall->setConfig('admin.pass', 'foo');
        $firewall->controlPanel($this->panelUri);

        $kernel = $firewall->getKernel();

        // driver:sqlite
//        $dbLocation = TMP . 'shieldon_firewall/shieldon.sqlite3';
//        $pdoInstance = new \PDO('sqlite:' . $dbLocation);
//        $kernel->setDriver(
//            new \Shieldon\Firewall\Driver\SqliteDriver($pdoInstance)
//        );

        // driver:mysql



        // Pass CSRF token to the Captcha form.
        // Note: The CsrfProtectionMiddleware was added in 3.5.0
        $kernel->setCaptcha(
            new Csrf([
                'name' => '_csrfToken',
                'value' => $request->getParam('_csrfToken'),
            ])
        );
//        $kernel->setCaptcha(
//            new \Shieldon\Firewall\Captcha\Recaptcha([
//                'key' => '6LfkOaUUAAAAAH-AlTz3hRQ25SK8kZKb2hDRSwz9',
//                'secret' => '6LfkOaUUAAAAAJddZ6k-1j4hZC1rOqYZ9gLm0WQh',
//            ])
//        );
        //$kernel->setLogger();
        //$kernel->setChannel();
        //$kernel->managedBy();
        //$kernel->limitSession(10, 300);

        $response = $firewall->run();

        if ($response->getStatusCode() !== 200) {
            // httpresolver automatically exits
            $httpResolver = new HttpResolver();
            $httpResolver($response, true);
        } elseif ($response->hasHeader('Location')) {
            return $response;
        }

        return $handler->handle($request);
    }
}
