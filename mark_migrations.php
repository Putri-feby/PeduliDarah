<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$files = scandir('database/migrations');
foreach($files as $file) {
    if(strpos($file, 'create') !== false && strpos($file, '.php') !== false) {
        $name = str_replace('.php', '', $file);
        try {
            DB::table('migrations')->insert(['migration' => $name, 'batch' => 1]);
            echo "Marked $name as migrated.\n";
        } catch(Exception $e) {}
    }
}
