<?php

/**
 * All application constants
 */

$defines = [
    // Uploads
    'MX_UPLOADS_PATH' => storage_path('app/public/uploads'),
    
    // Upload types
    'MX_UPLOAD_TYPE_IMAGE' => 'image',
    'MX_UPLOAD_TYPE_DOCUMENT' => 'document',
    'MX_UPLOAD_TYPE_AUDIO' => 'audio',
    'MX_UPLOAD_TYPE_VIDEO' => 'video',
    
    // modules
    'MODULESEARCH' => 'Mconsole',
    'BOOTSTRAPFILE' => 'bootstrap.php',
    
    // forms
    'MX_SELECT_STATE' => 'state',
    'MX_SELECT_YESNO' => 'yesno',
    'MX_SELECT_SHOW' => 'show',
];

// Define values
foreach ($defines as $key => $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}
