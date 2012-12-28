<?php

namespace RzTrucks\RzTrucksBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener;

class ParametersTemplateListener extends TemplateListener
{
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $parameters = $event->getControllerResult();
        $templating = $this->container->get('templating');

        if (null === $parameters) {
            if (!$vars = $request->attributes->get('_template_vars')) {
                if (!$vars = $request->attributes->get('_template_default_vars')) {
                    return null;
                }
            }
            $parameters = array();

            foreach ($vars as $var) {
                $parameters[$var] = $request->attributes->get($var);
            }
        }
        if (!is_array($parameters)) {
            return $parameters;
        }
        if (!$template = $request->attributes->get('_template')) {
            return $parameters;
        }
        // dynamically add widgets into template
        $mainTemplate = $this->getMainTemplateName($request->getSession()->get('locale'));
        $parameters = array_merge($parameters, array('mainTemplate' => $mainTemplate));

        if (!$request->attributes->get('_template_streamable')) {
            $event->setResponse($templating->renderResponse($template, $parameters));
        }
        else {
            $callback = function () use ($templating, $template, $parameters) {
                return $templating->stream($template, $parameters);
            };
            $event->setResponse(new StreamedResponse($callback));
        }
        return null;
    }

    protected function getMainTemplateName($locale)
    {
        $bundle = 'RzTrucksBundle';
        $template = '%s::layout-%s.html.twig';

        if ($locale == 'en_GB') {
            $bundle = 'RzTrucksUKBundle';
        }
        return sprintf($template, $bundle, $locale);
    }

}