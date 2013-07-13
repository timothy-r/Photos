<?php

function link_tag($url, $body)
{
    return sprintf('<a href="%s">%s</a>', $url, $body);
}
