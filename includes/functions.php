<?php
function sanitizeQuantity($qty) {
    return max(0, (int)$qty);
}
