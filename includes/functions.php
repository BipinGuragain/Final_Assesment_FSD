<?php

function sanitizeQuantity($qty) {
    return max(0, (int)$qty);
}

function sanitizePrice($price) {
    return max(0, (float)$price);
}
