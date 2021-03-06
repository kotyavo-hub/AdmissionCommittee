<?php declare(strict_types=1);

namespace AC\Service\Http;

use AC\Config\RoutesConfigInterface;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

/**
 * Сервис для работы с роутером
 *
 * Class Router
 * @package AC\Service\Http
 */
class Router
{
    const HANDLER_DELIMITER = '@';
    /**
     * @var RoutesConfigInterface
     */
    private RoutesConfigInterface $routesConfig;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var Container
     */
    private Container $container;

    /**
     * @param RoutesConfigInterface $routesConfig
     * @param RequestInterface $request
     * @param Container $container
     */
    public function __construct(
        RoutesConfigInterface $routesConfig,
        RequestInterface $request,
        Container $container
    )
    {
        $this->routesConfig = $routesConfig;
        $this->request = $request;
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function dispatchRoute()
    {
        $dispatcher = $this->getDispatcher();
        $request = $this->getRequest();
        $requestMethod = $request->getMethod();
        $requestUri = $request->getUri();

        /** @noinspection ReturnFalseInspection */
        if (false !== $pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        $requestUri = rawurldecode($requestUri);

        $this->dispatch($requestMethod, $requestUri, $dispatcher);
    }

    public function sendErrorResponse(Exception $ex)
    {
        http_response_code((int)$ex->getCode());
        echo '['.$ex->getCode().']'.$ex->getMessage();
        echo '<pre>';
        echo $ex->getTraceAsString();
        echo '</pre>';
    }

    /**
     * @param string $requestMethod
     * @param string $requestUri
     * @param Dispatcher $dispatcher
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function dispatch(string $requestMethod, string $requestUri, Dispatcher $dispatcher)
    {
        $routeInfo = $dispatcher->dispatch($requestMethod, $requestUri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $this->getRequest()->sendNotFoundHeader();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->getRequest()->sendMethodNotAllowedHeader();
                break;
            case Dispatcher::FOUND:
                list($state, $handler, $vars) = $routeInfo;
                list($class, $method) = explode(static::HANDLER_DELIMITER, $handler, 2);
                $controller = $this->getContainer()->get($class);
                $controller->{$method}(...array_values($vars));
                unset($state);
                break;
        }
    }

    /**
     * @return Dispatcher
     */
    private function getDispatcher(): Dispatcher
    {
        $routesConfig = $this->getRoutesConfig();
        $dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $route) use ($routesConfig) {
            foreach ($routesConfig->createRouteGroupItems() as $routeGroupItem) {
                $route->addRoute(
                    $routeGroupItem->getHttpMethod(),
                    $routeGroupItem->getBase() . $routeGroupItem->getRoute(),
                    $routeGroupItem->getController() .
                    static::HANDLER_DELIMITER .
                    $routeGroupItem->getControllerAction()
                );
            }
        });

        return $dispatcher;
    }

    /**
     * @return RoutesConfigInterface
     */
    private function getRoutesConfig(): RoutesConfigInterface
    {
        return $this->routesConfig;
    }

    /**
     * @return RequestInterface
     */
    private function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return Container
     */
    private function getContainer(): Container
    {
        return $this->container;
    }
}