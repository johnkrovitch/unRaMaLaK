<?php

namespace RzTrucks\RzTrucksBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ControllerPreExecuteListener
{
    public function onCoreController(FilterControllerEvent $event)
    {
        // get event
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            // get controller
            $_controller = $event->getController();
            if (isset($_controller[0])) {
                $controller = $_controller[0];
                // check if method exists
                if (method_exists($controller, 'preExecute')) {
                    $controller->preExecute();
                }
            }
        }

    }
}