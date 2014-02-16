<?php


namespace Krovitch\UnramalakBundle\Form;


use Krovitch\UnramalakBundle\Form\Interfaces\MediaInterface;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MediaCollectionType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options = [])
    {
        foreach ($options['data'] as $data) {

            if (!($data instanceof MediaInterface)) {
                throw new InvalidTypeException('Media should implement MediaInterface');
            }
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data' => []
        ]);
    }

    public function getName()
    {
        return 'media_collection';
    }
} 