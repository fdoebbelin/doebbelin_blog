<?php

require 'recipe/common.php';

server('prod', 'www183.your-server.de', 222)
    ->user('tymdad')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/usr/www/users/tymdad/doebbelin.net');

set('repository', 'git@github.com:fdoebbelin/doebbelin_blog.git');
set('keep_releases', 3);

set('shared_dirs', [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

set('shared_files', ['.env']);

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    //'deploy:vendors',
    'deploy:shared',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy your project');

after('deploy', 'success');
