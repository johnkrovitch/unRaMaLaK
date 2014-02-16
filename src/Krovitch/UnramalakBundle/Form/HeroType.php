<?php

namespace Krovitch\UnramalakBundle\Form;

use Krovitch\UnramalakBundle\Utils\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'label' => 'unramalak.hero.name'
        ]);
//        $builder->add('avatar', 'media_diaporama', [
//            'label' => 'unramalak.hero.avatar',
//            'data' => $this->getMedias()
//        ]);
        $builder->add('attributes', 'attributes_collection', [
            'label' => 'unramalak.hero.remaining-points',
            'available_attributes' => $options['available_attributes']
        ]);
        return $builder;
    }

    protected function getMedias()
    {
        // TODO move to a better world
        $avatarPath = '/bundles/krovitchunramalakfront/img/avatars/';
        $medias = [];
        $data = [
            'human' => [
                'avatar' => 'human1.jpg',
                'description' => 'Ceci est un humain de fort bel constitution'
            ],
            'undead' => [
                'avatar' => 'undead1.jpg',
                'description' => 'Un beau zombie avec le bras qui tombe'
            ]
        ];
        foreach ($data as $race => $raceData) {
            $media = new Media();
            $media->setName($race);
            $media->setFile($avatarPath . $raceData['avatar']);
            $media->setDescription($raceData['description']);
            $medias[] = $media;
        }
        return $medias;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'available_attributes' => []
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