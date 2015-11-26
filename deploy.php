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

set('shared_dirs', ['storage', 'vendor']);

set('shared_files', ['.env']);

task('deploy:rsync_vendors', function () {
    $rsync_cmd =
        'rsync -avz --delete -e "ssh -p ' . env('server.port') . '" ' .
        getcwd() . '/vendor ' .
        get('user') . '@' . env('server.host') . ':' .
        env('deploy_path') . '/shared';
    runLocally($rsync_cmd);
});

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:rsync_vendors',
    'deploy:shared',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy your project');

after('deploy', 'success');
