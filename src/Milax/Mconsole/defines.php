<?php

/**
 * All application constants
 */

$defines = [
    'MX_VERSION' => '0.5',
    
    // Paths
    'MX_UPLOADS_PATH' => storage_path('app/public/uploads'),
    'MX_MASSETS_PATH' => File::exists(base_path('workbench/milax/mconsole/public')) ? '../workbench/milax/mconsole/public' : '../vendor/milax/mconsole/public',
    'MX_MASSETS_PUBLIC_PATH' => public_path('massets'),
    'MX_STORAGE_PATH' => '../storage/app/public',
    'MX_STORAGE_PUBLIC_PATH' => public_path('storage'),
    
    // modules
    'MX_MODULE_SEARCH_PATH' => 'Mconsole',
    'MX_MODULE_BOOTSTRAP_FILE' => 'bootstrap.php',
];

// Define values
foreach ($defines as $key => $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}
