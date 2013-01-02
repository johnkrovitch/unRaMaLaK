<?php

namespace Krovitch\KrovitchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Krovitch\KrovitchBundle\Utils\StringUtils;

abstract class BaseController extends Controller
{
    public function preExecute()
    {
    }

    protected function getTranslator()
    {
        return $this->get('translator');
    }

    protected function translate($string)
    {
        return $this->getTranslator()->trans($string);
    }

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
     */
    protected function setMessage($message)
    {
        $this->getSession()->setFlash('notice', $this->translate($message));
    }

    public function redirect($url, $status = 302)
    {
        if (substr($url, 0, 1) == '_') {
            $url = $this->generateUrl($url);
        }
        return parent::redirect($url, $status);
    }
}