<?php

namespace Leeuwenkasteel\Statistics;

use Illuminate\Support\ServiceProvider;
use Leeuwenkasteel\Statistics\Console\Commands\InstallCommand;
use Leeuwenkasteel\Statistics\View\Components\StatisticsComponent;
use Illuminate\Support\Facades\Blade;
use Leeuwenkasteel\Statistics\Livewire\Dashboard;
use Livewire;

class StatisticsPackageServiceProvider extends ServiceProvider{

  public function register(): void{
    $this->commands([
        InstallCommand::class,
    ]);
  }

  public function boot(): void{
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'statistics');
    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    
	$langPath = $this->app->langPath('vendor/statistics');
    $pathToLoad = !empty($langPath) && is_dir($langPath) ? $langPath : __DIR__.'/../resources/lang';
	
	$this->publishes([
        __DIR__.'/../public' => public_path('vendor/statistics'),
    ], 'public_statistics');

    //$this->loadJsonTranslationsFrom($pathToLoad);
	
	$this->publishes([
        __DIR__.'/../resources/lang' => $this->app->langPath('vendor/statistics'),
    ], 'trans_statistics');
	
	if ($this->app->runningInConsole()) {
      $this->commands([
          InstallCommand::class
      ]);
    }
	
	Blade::component('statistics::layout', StatisticsComponent::class);
	
	Livewire::component('statistics::dashboard', Dashboard::class);
	
  }
}