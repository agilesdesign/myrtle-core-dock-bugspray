<?php

namespace Myrtle\Core\Docks;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Myrtle\Permissions\Models\Ability;
use Illuminate\Support\Facades\Session;
use Myrtle\BugSpray\Policies\BugSprayDockPolicy;

class BugsprayDock extends Dock
{
    /**
     * Description for Dock
     *
     * @var string
     */
    public $description = 'Debug information';

    /**
     * Explicit Gate definitions
     *
     * @var array
     */
    public $gateDefinitions = [
        self::class . '.admin' => BugSprayDockPolicy::class . '@admin',
        self::class . '.access-admin' => BugSprayDockPolicy::class . '@accessAdmin',
        self::class . '.edit-settings' => BugSprayDockPolicy::class . '@editSettings',
        self::class . '.view-settings' => BugSprayDockPolicy::class . '@viewSettings',
        self::class . '.edit-permissions' => BugSprayDockPolicy::class . '@editPermissions',
        self::class . '.view-permissions' => BugSprayDockPolicy::class . '@viewPermissions',
    ];

    /**
     * Policy mappings
     *
     * @var array
     */
    public $policies = [
        BugSprayDockPolicy::class => BugSprayDockPolicy::class,
    ];

    /**
     * List of config file paths to be loaded
     *
     * @return array
     */
    public function configPaths()
    {
        return [
            'abilities' => dirname(__DIR__, 2) . '/config/abilities.php',
            'docks.' . self::class => dirname(__DIR__, 2) . '/config/docks/bugspray.php',
        ];
    }

    /**
     * Boot View Composers
     */
    public function viewComposers()
    {
        if (Config::get('app.debug')) {
            View::composer('*', function ($view) {
                DB::enableQueryLog();

                $debug = [
                    'config' => Config::all(),
                    'database' => [
                        'transactions' => collect(DB::getQueryLog()),
                    ],
                    'language' => Lang::get(''),
                    'permissions' => [
                        'user' => Auth::user()->permissions->pluck('name')->toArray(),
                        'inherited' => Auth::user()->inheritedPermissions->pluck('name')->toArray(),
                    ],
                    'route' => [
                        'name' => Route::currentRouteName(),
                        'route' => Route::getCurrentRoute(),
                    ],
                ];

                if (Schema::hasTable('sessions')) {
                    $debug['session'] = Session::all();
                }
                if (Schema::hasTable('abilities')) {
                    $debug['abilities'] = Ability::all()->pluck('name');
                }

                $view->withDebug($debug);
            });
        }
    }
}
