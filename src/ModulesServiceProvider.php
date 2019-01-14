<?php
namespace Liemphan\modules;
use Illuminate\Support\ServiceProvider;
class ModulesServiceProvider extends ServiceProvider{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    protected $command = [
        'Liemphan\modules\Commands\AdminCommand',
    ];


    public function boot()
    {
        $this->publishes([__DIR__.'/.env' => base_path('.env.php')], 'env_config');
        $this->publishes([__DIR__.'/config/auth.php' => config_path('auth.php')], 'auth_config');
        $this->publishes([__DIR__.'/config/module.php' => config_path('module.php')], 'module_config');
        $this->publishes([__DIR__.'/Modules' => base_path('app/Modules')], 'module');
        $this->publishes([__DIR__.'/Repositories' => base_path('app/Repositories')], 'module_repo');
        $this->publishes([__DIR__.'/Notifications' => base_path('app/Notifications')], 'notification');
        $this->publishes([__DIR__.'/resources/assets' => public_path('/assets')], 'module_assets');
        $this->publishes([__DIR__.'/resources/myLib' => base_path('/resources/myLib')], 'module_library');
        $this->publishes([__DIR__.'/migrations' => base_path('database/migrations')], 'module_migration' );
        $this->publishes([__DIR__.'/seeds' => base_path('database/seeds')], 'module_seed' );
        $this->publishes([__DIR__.'/Models' => base_path('app/Models')], 'module_model');
        $this->publishes([__DIR__.'/Providers/ComposerServiceProvider.php' => base_path('app/Providers/ComposerServiceProvider.php')]);
        $this->publishes([__DIR__.'/ViewComposers' => base_path('app/ViewComposers')]);
        $this->publishes([__DIR__.'/Kernel.php' => base_path('app/Http/Kernel.php')] );
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->command);
    }
}