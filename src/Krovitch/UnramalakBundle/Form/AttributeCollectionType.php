<?php


namespace Krovitch\UnramalakBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttributeCollectionType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options = [])
    {
        $view->vars['attributes'] = $options['availables_attributes'];
        $view->vars['minLimit'] = $options['min_limit'];
        $view->vars['maxLimit'] = $options['max_limit'];
        $view->vars['remainingPoints'] = $options['remainingPoints'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'availables_attributes' => [],
            'min_limit' => 0,
            'max_limit' => 20,
            'remainingPoints' => 20
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'attributes_collection';
    }
}