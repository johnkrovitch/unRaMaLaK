<?php

namespace Krovitch\UnramalakBundle\Form;

use Krovitch\UnramalakBundle\Utils\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('avatar', 'media_collection', ['data' => $this->getMedias()]);
        $builder->add('attributes', 'attributes_collection', [
            'availables_attributes' => $options['availables_attributes']
        ]);

        return $builder;
    }

    protected function getMedias()
    {
        $avatarPath = '/bundles/krovitchunramalakfront/img/avatars/';
        $medias = [];
        $data = [
            'human' => 'human1.jpg',
            'undead' => 'undead1.jpg'
        ];
        foreach ($data as $name => $file) {
            $media = new Media();
            $media->setName($name);
            $media->setFile($avatarPath.$file);
            $medias[] = $media;
        }
        return $medias;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'availables_attributes' => []
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'hero_type';
    }
}