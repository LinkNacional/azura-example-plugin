<?php

declare(strict_types=1);

namespace Plugin\ExamplePlugin\Controller;

use App\Controller\SingleActionInterface;
use App\Exception\Http\InvalidRequestAttribute;
use App\View;
use DI\Container;
use App\Http\Response;
use App\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;

final class HelloWorld implements SingleActionInterface
{
    //use EnvironmentAwareTrait;
    private Container $container;
    private View $view;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container->get(View::class);

    }

    public function __invoke(ServerRequest $request, Response $response, array $params): ResponseInterface
    {
        return $request->getView()
            ->renderToResponse($response, 'ExamplePlugin::hello_world');
    }
}
