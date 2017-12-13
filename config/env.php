<?php
/**
 * Setup application environment
 */
try {
    $dotenv = new \Dotenv\Dotenv(dirname(__DIR__));
    $dotenv->overload();
} catch (Exception $e) {
    // If no env file is given just do not load anything.
}