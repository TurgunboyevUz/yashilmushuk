<?php

use App\Classes\SeoManager;

function seo(?array $seos = null)
{
    static $instance;

    if (!$instance) {
        $instance = new SeoManager();
    }

    if ($seos) {
        $instance->set($seos);
    }

    return $instance;
}