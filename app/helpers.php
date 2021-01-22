<?php

declare(strict_types=1);

/**
 * Set the photo path for the product.
 *
 * @param $photo
 * @return string
 */
function setPhoto($photo): string
{
    if ($photo) {
        return "/storage/{$photo}";
    }
    return "/img/products/photo.png";
}
