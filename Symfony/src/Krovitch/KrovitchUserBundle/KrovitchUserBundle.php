<?php

namespace Krovitch\KrovitchUserBundle;

use \Symfony\Component\HttpKernel\Bundle\Bundle;

class KrovitchUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}