<?php

/**
 * @return string
 */
function credits_title()
{
    return __('Credits');
}

/**
 * @return string
 */
function guest_credits()
{
    return view(__DIR__ . '/../../templates/pages/credits.html');
}
