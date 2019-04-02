<?php

function fullname(string $firstname, string $lastname): string
{
    $fullname = strtoupper($lastname) . ' ' . ucfirst($firstname);

    return $fullname;
}