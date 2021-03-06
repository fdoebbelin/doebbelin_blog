<?php

require 'recipe/common.php';

set('user', 'tymdad');

server('prod', 'www183.your-server.de', 222)
    ->user(get('user'))
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/usr/www/users/tymdad/doebbelin.net');

set('repository', 'git@github.com:fdoebbelin/doebbelin_blog.git');
set('keep_releases', 3);

set('shared_dirs', ['storage']);

set('shared_files', ['.env']);

task('application:down', function () {
    run('cd {{deploy_path}}/current && php artisan down');
});

task('application:up', function () {
    run('cd {{deploy_path}}/current && php artisan up');
});

task('deploy:composer', function () {
    run('cd {{deploy_path}}/current && php composer.phar install');
});

task('deploy', [
    'application:down',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:symlink',
    'deploy:composer',
    'cleanup',
    'application:up'
])->desc('Deploy your project');

after('deploy', 'success');
