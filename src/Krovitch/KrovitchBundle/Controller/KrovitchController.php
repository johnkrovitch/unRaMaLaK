<?php

namespace Krovitch\KrovitchBundle\Controller;

use Krovitch\BaseBundle\Controller\BaseController;
use Krovitch\KrovitchBundle\Utils\Svg;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krovitch\KrovitchBundle\Entity\Contact;

/**
 * @Route("/")
 */
class KrovitchController extends BaseController
{
    /**
     * @Route("/", name="_homepage")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $svg = new Svg();
        $svgContent = $svg->importFiles([
            //'/home/afrezet/workspace/unRaMaLaK/init/resources/textures/test_arbre_svg.svg',
            //'/home/afrezet/workspace/unRaMaLaK/init/resources/textures/algue_flat.svg',
            '/home/afrezet/workspace/unRaMaLaK/init/resources/textures/calmar_flat_svg1_1.svg',
            //'/home/afrezet/workspace/unRaMaLaK/init/resources/textures/calmar_flat_svg1_1_tiny.svg',
            //'/home/afrezet/workspace/unRaMaLaK/init/resources/textures/coquillage_flat.svg',
            //'/home/afrezet/workspace/unRaMaLaK/init/resources/textures/test_arbre_svg.svg',
            //'/home/afrezet/workspace/unRaMaLaK/init/resources/textures/calmar_flat.svg',
        ]);
        return array('svg' => implode(' ', $svgContent), 'ids' => json_encode(array_keys($svgContent)));
    }

    /**
     * @Route("/contact", name="_contact")
     * @Template()
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function contactAction()
    {
        die('lol');
        $contact = new Contact();

        $builder = $this->createFormBuilder($contact);
        $builder->add('name')
            ->add('password', 'password')
            ->add('email', 'email');
        $form = $builder->getForm();

        // handling form submission
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

            } else {

            }
        }

        return array('form' => $form->createView());

        /*  $form = $this->get('form.factory')->create(new ContactType());

          $request = $this->get('request');
          if ('POST' == $request->getMethod()) {
              $form->bindRequest($request);
              if ($form->isValid()) {
                  $mailer = $this->get('mailer');
                  // .. setup a message and send it
                  // http://symfony.com/doc/current/cookbook/email.html

                  $this->get('session')->setFlash('notice', 'Message sent!');

                  return new RedirectResponse($this->generateUrl('_demo'));
              }
          }

          return array('form' => $form->createView());*/
    }
}
