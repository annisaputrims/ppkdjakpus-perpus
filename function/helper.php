<?php

function getStatus($status)
{
    switch ($status) {
        case '1':
            $label = '<span class="badge text-bg-primary">Sedang dipinjam</span>';
            break;
        case '2':
            $label = '<span class="badge text-bg-success">Sudah dikembalikan</span>';
            break;
        default:
            $label = "";
            break;
    }
    return $label;
}
 