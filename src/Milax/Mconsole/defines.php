<?php

/**
 * All application constants
 */

$defines = [
    'MCONSOLE_VERSION' => '0.4.24',
    
    // Paths
    'MX_UPLOADS_PATH' => storage_path('app/public/uploads'),
    'MX_MASSETS_PATH' => File::exists(base_path('workbench/milax/mconsole/public')) ? base_path('workbench/milax/mconsole/public') : base_path('vendor/milax/mconsole/public'),
    'MX_MASSETS_PUBLIC_PATH' => public_path('massets'),
    'MX_STORAGE_PATH' => storage_path('app/public'),
    'MX_STORAGE_PUBLIC_PATH' => public_path('storage'),
    
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
