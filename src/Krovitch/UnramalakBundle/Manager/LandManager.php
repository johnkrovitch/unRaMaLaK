<?php


namespace Krovitch\UnramalakBundle\Manager;

use GeorgetteParty\BaseBundle\Manager\BaseManager;
use Krovitch\UnramalakBundle\Entity\Land;

class LandManager extends BaseManager
{
    public function findSortedByType()
    {
        $lands = $this->getRepository()->findAll();
        $landsByType = [];

        /** @var Land $land */
        foreach ($lands as $land) {
            $landsByType[$land->getType()] = $land;
        }
        return $landsByType;
    }

    /**
     * Return the default land type
     *
     * @return Land
     */
    public function findDefaultLandType()
    {
        return $this->getRepository()->findOneBy([
            'type' => 'default'
        ]);
    }
} 