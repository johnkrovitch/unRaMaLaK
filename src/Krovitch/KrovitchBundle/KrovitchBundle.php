<?php

namespace Krovitch\KrovitchBundle;

use \Symfony\Component\HttpKernel\Bundle\Bundle;

class KrovitchBundle extends Bundle
{
    public function getParent()
    {
        return 'BaseBundle';
    }
}