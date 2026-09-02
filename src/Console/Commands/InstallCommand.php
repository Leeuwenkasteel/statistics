<?php

namespace Leeuwenkasteel\Statistics\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class InstallCommand extends Command{

    protected $signature = 'install:statistics';
    protected $description = 'install statistics package';

    public function handle(){
		
		Artisan::call('template:app', [
            'path' => 'statistics.install',
            'title' => 'Statistics',
            'permissions' => 'statistics',
			'img' => 'vendor/statistics/img/icons/statistics-512.png',
			'color' => '#156082',
			'register' => true,
        ]);
		
		Artisan::call('vendor:publish', [
            '--tag' => 'public_statistics'
        ]);
    }
}