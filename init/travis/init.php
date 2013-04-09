<?php


$path = __DIR__.'/../../app/config';

// to run php test, we should have a parameter.yml
if (!is_file($path.'/parameters.yml')) {
    copy($path.'/parameters-dist.yml', $path.'/parameters.yml');
    echo 'parameters.yml created !';
}