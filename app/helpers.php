<?php

function link_tag($url, $body)
{
    return sprintf('<a href="%s">%s</a>', $url, $body);
}

function http_date(DateTime $d)
{
    return $d->format('D, d M Y H:i:s ') . 'GMT'; 
}
