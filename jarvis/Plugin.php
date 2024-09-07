<?php namespace Acme\Jarvis;

use Backend;
use System\Classes\PluginBase;
use Acme\Jarvis\Updates\Seeders\SeedJarvisUser;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{

    /**
     * @var array Plugin dependencies
     */
    public $require = ['RainLab.User'];


    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Jarvis',
            'description' => 'No description provided yet...',
            'author' => 'Acme',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        \Artisan::call('db:seed', [
            '--class' => SeedJarvisUser::class,
        ]);
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Acme\Jarvis\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'acme.jarvis.some_permission' => [
                'tab' => 'Jarvis',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'jarvis' => [
                'label' => 'Jarvis',
                'url' => Backend::url('acme/jarvis/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['acme.jarvis.*'],
                'order' => 500,
            ],
        ];
    }
}
