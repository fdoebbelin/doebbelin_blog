<?php

require 'recipe/common.php';

server('prod', 'www183.your-server.de', 222)
    ->user('tymdad')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/usr/www/users/tymdad/doebbelin.net');

set('repository', 'git@github.com:fdoebbelin/doebbelin_blog.git');
set('keep_releases', 3);
