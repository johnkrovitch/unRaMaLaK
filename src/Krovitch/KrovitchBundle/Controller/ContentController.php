<?php

namespace Krovitch\KrovitchBundle\Controller;

use Krovitch\KrovitchBundle\Entity\Content;
use Krovitch\KrovitchBundle\Form\ContentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @Route("/content")
 */
class ContentController extends BaseController
{
  /**
   * @Route("/list", name="_content")
   * @Template()
   * @return array
   */
  public function indexAction()
  {
    $contents = $this->get('krovitch.content_manager')->findAll();

    return array('contents' => $contents);
  }

  /**
   * @Route("/create", name="_content_create")
   * @Template("KrovitchBundle:Content:edit.html.twig")
   * @return array
   */
  public function createAction()
  {
    $form = $this->get('form.factory')->create(new ContentType());

    return array('form' => $form->createView());
  }

  /**
   * @Route("/edit/{id}", name="_content_edit", requirements={"id" = "\d+"}, defaults={"id" = 0})
   * @Template()
   * @param $id
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   * @return array
   */
  public function editAction($id = 0)
  {
    // get id parameter
    $content = $this->get('krovitch.content_manager')->find($id);

    if(!$content){
      $content = new Content();
    }
    // handling form submission
    $request = $this->getRequest();
    $form = $this->get('form.factory')->create(new ContentType(), $content);

    if($request->getMethod() == 'POST'){
      $form->bindRequest($request);

      if($form->isValid()){
        // form is valid, save created content
        $this->get('krovitch.content_manager')->save($form->getData());

        // notify changes to user then redirect
        $this->setMessage('Changes has been saved');
        return $this->redirect('_content');
      }
    }
    return array('form' => $form->createView(), 'content_id' => $content->getId());
  }

  /**
   * @Route("/delete/{id}", name="_content_delete", requirements={"id" = "\d+"}, defaults={"id" = 0})
   * @Template()
   * @param $id
   * @return array
   */
  public function deleteAction($id)
  {
    $this->getManager()->delete($id);
    $this->setMessage('Content has been deleted');

    return $this->redirect('_content');
  }
}