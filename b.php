<?php
function readableDate($date) {
    $timestamp = strtotime($date);
    return date('M d Y', $timestamp);
}

// Example usage
echo readableDate('2023-06-05'); // Output: 05 Oct 2023
?>