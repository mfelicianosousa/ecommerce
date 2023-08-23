<?php

// formatar valor
function formatPrice(float $price)
{
    return number_format($price, 2, ',', '.');
}
