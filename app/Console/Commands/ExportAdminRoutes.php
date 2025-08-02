<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class ExportAdminRoutes extends Command
{
    protected $signature = 'export:adminroutes';
    protected $description = 'Export all routes with admin middleware to admin_routes.txt';

    public function handle()
    {
        $routes = Route::getRoutes();

        $lines = [];
        $lines[] = "Admin Middleware Routes";
        $lines[] = "=======================";

        foreach ($routes as $route) {
            $middlewares = $route->gatherMiddleware();

            // تحقق إذا الراوت يحتوي middleware 'admin'
            if (in_array('admin', $middlewares)) {
                $methods = implode('|', $route->methods());
                $uri = $route->uri();
                $action = $route->getActionName();

                $lines[] = "Method: $methods";
                $lines[] = "URI: /$uri";
                $lines[] = "Action: $action";
                $lines[] = "-------------------------";
            }
        }

        $content = implode("\n", $lines);

        File::put('admin_routes.txt', $content);

        $this->info('File admin_routes.txt has been created successfully!');
    }
}
