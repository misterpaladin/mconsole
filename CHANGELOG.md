## 0.1

Added:
  - Added Travis CI config
  - Added PHPUnit tests
  - Added MconsoleUploadPreset model (for future functional)
  - Added status badges in readme
  - Added MconsoleRole installer with predefined user roles

Updated:
  - Updated localization

## 0.0.10

Added:
  - Added user localization settings
  - Added menu localization
  - Added menu installation

## 0.0.9

Added:
  - Added Users section
  - Added first Blade directive
  - Added localization
  - Added system template
  - Added `redirect` method for cms controllers (must have `protected $redirectTo` property)
  - Added version display in dashboard
  - Added admin creation prompt when installing mconsole

Fixed:
  - Fixed installer error while seeding database

## 0.0.8

Added:
  - Added package self installer `php artisan mconsole:install`
  - Added `BladeRenderer` class
  - Added models: MconsoleRole, MconsoleMenu, MconsoleUser

Updated:
  - Models not publishing to app anymore
  - Views moved in `views/mconsole` directory