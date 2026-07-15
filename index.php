<?php
/**
 * KongStore Root Redirect
 */

// If mod_rewrite is disabled or running via php built-in server, forward to public
require_once __DIR__ . '/public/index.php';
