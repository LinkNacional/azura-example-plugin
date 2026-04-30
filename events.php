<?php

//declare(strict_types=1);

use App\CallableEventDispatcherInterface;
use App\Event;
use App\Event\BuildRoutes;
use App\Event\BuildView;
use DI\Container;
use Plugin\ExamplePlugin\Controller\HelloWorld;
//use Plugin\ExamplePlugin\EventHandler\AllTheListeners;

return static function (\App\CallableEventDispatcherInterface $dispatcher) {
    $dispatcher->addListener(
        Event\BuildConsoleCommands::class,
        function (Event\BuildConsoleCommands $event) use ($dispatcher) {
            $event->addAliases([
                'example:list-stations' => Plugin\ExamplePlugin\Command\ListStations::class,
            ]);
        }
    );

    // Tell the view handler to look for templates in this directory too
    $dispatcher->addListener(Event\BuildView::class, function(Event\BuildView $event) {
        $event->getView()->addFolder('ExamplePlugin', __DIR__.'/templates');
    });

    // Add a new route handled exclusively by the plugin.
    $dispatcher->addListener(Event\BuildRoutes::class, function(Event\BuildRoutes $event) {
        $app = $event->getApp();

        $app->get('/example', HelloWorld::class)
            ->setName('example:index')
            ->add(\App\Middleware\EnableView::class);

    });

    // You can also add classes that implement the EventSubscriberInterface
    //$dispatcher->addSubscriber(new AllTheListeners);
};
