<?php

namespace Krovitch\UnramalakBundle\Interfaces;


interface TransformerInterface
{
    public function transform($data);
    public function reverseTransform($data);
}