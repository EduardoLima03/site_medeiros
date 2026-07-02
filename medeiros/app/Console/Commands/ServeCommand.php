<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

use function Illuminate\Support\php_binary;

class ServeCommand extends BaseServeCommand
{
    protected function serverCommand()
    {
        $server = file_exists(base_path('server.php'))
            ? base_path('server.php')
            : __DIR__.'/../../../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php';

        return [
            php_binary(),
            '-d', 'upload_max_filesize=100M',
            '-d', 'post_max_size=105M',
            '-d', 'memory_limit=512M',
            '-S',
            $this->host().':'.$this->port(),
            $server,
        ];
    }
}
