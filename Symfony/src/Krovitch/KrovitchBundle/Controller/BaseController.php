<?php

namespace Krovitch\KrovitchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Krovitch\KrovitchBundle\Utils\StringUtils;

abstract class BaseController extends Controller
{
    public function preExecute()
    {
    }

    /**
     * Return current translator
     * @return Translator
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }

    protected function translate($string, $parameters = array())
    {
        return $this->getTranslator()->trans($string, $parameters);
    }

    /**
     * Return current session
     * @return Session
     */
    protected function getSession()
    {
        return $this->get('session');
    }

    /**
     * Return the manager linked with this controller
     * @param null $managerName
     * @return \Krovitch\KrovitchBundle\Manager\BaseManager
     */
    protected function getManager($managerName = null)
    {
        $managerName = strtolower($managerName);

        // try to find automatically the manager name
        if (!$managerName) {
            $managerName = StringUtils::getEntityClassName($this);
        }
        // add Krovitch prefix
        if (substr($managerName, 0, 7) != 'krovitch') {
            $managerName = 'krovitch.'.$managerName;
        }
        // add suffix
        if (substr($managerName, -7) != 'manager') {
            $managerName.= '_manager';
        }
        return $this->get($managerName);
    }

    /**
     * Set a flash notice in session for next request. The message is translated
     * @param $message
     * @param array $parameters
     * @internal param bool $useTranslation
     * @internal param array $translationParameters
     * @return void
     */
    protected function setMessage($message, $parameters = array())
    {
        $this->getSession()->getFlashBag()->add('notice', $this->translate($message, $parameters));
    }

    /**
     * Redirects response to an url or a route
     * @param string $url
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($url, $status = 302)
    {
        if (substr($url, 0, 1) == '@') {
            $route = substr($url, 1);
            $url = $this->generateUrl($route);
        }
        return parent::redirect($url, $status);
    }
}