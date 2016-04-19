<?php

/**
 * All application constants
 */

$defines = [
    // Upload types
    'MX_UPLOAD_TYPE_IMAGE' => 'image',
    'MX_UPLOAD_TYPE_DOCUMENT' => 'document',
    'MX_UPLOAD_TYPE_AUDIO' => 'audio',
    'MX_UPLOAD_TYPE_VIDEO' => 'video',
    
    // modules
    'MODULESEARCH' => 'Mconsole',
    'BOOTSTRAPFILE' => 'bootstrap.php',
];

// Define values
foreach ($defines as $key => $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}
