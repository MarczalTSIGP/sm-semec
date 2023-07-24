<?php

namespace Deployer;

require 'recipe/laravel.php';

/*
 * Project base setup
 * --------------------------------- */
set('application', 'sm-semec');
set('repository', 'git@github.com:marczaltsigp/sm-semec.git');
set('git_tty', true);
set('keep_releases', 3);
set('default_timeout', 600);

/*
 * Shared files/dirs between deploys
 * --------------------------------- */
add('shared_files', ['.env']);
add('shared_dirs', ['logs', 'public/uploads', 'vendor']);

/*
 * Hosts
 * --------------------------------- */
host('staging')
    ->setHostname('semec.tsi.pro.br')
    ->setPort(22)
    ->set('remote_user', 'deployer')
    ->setIdentityFile('/var/www/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/{{application}}')
    ->set('branch', 'master');

/*
 * Tasks
 * --------------------------------- */

task('deploy:cp-docker-files', function () {
    upload('deploy/staging/', "{{deploy_path}}");
    upload('deploy/php/', "{{deploy_path}}/shared/php/");
    upload('deploy/mysql/', "{{deploy_path}}/shared/mysql/");
});

task('deploy:build-containers', function () {
    run('cd {{deploy_path}} && docker-compose stop app-semec');
    run('cd {{deploy_path}} && docker-compose build --build-arg USER_ID=$(id -u) --build-arg GROUP_ID=$(id -g) app-semec');
});

task('deploy:up-containers', function () {
    run('cd {{deploy_path}} && docker-compose up -d');
});

task('deploy:containers-ps', function () {
    run('cd {{deploy_path}} && docker-compose ps');
});

task('deploy:setup:docker', [
    'deploy:cp-docker-files',
    'deploy:build-containers',
    'deploy:up-containers',
    'deploy:containers-ps'
]);

/* --------------------------------- */

task('deploy:composer:install', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader');
});

task('deploy:artisan:key:generate', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan key:generate');
});

task('deploy:config:cache', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan config:cache');
});

task('deploy:migrate', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan migrate --force');
});

task('deploy:seed', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan db:seed --force');
});

task('deploy:assets', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec npm install');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec npm run production');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan storage:link');
});

task('deploy:cache', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan route:cache');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan view:cache');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan event:cache');
});

task('deploy:cache:clear', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan config:clear');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan route:clear');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan view:clear');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan event:clear');
});

task('deploy:reload:php', function () {
    run('cd {{deploy_path}} && docker-compose exec -T app-semec kill -USR2 1');
});

task('deploy:reload:nginx', function () {
    run('sudo nginx -s reload');
});

/*
 * Task to deploy
 * --------------------------------- */
task('deploy', [
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:clear_paths',
    'deploy:composer:install',
    'deploy:cache:clear',
    'deploy:config:cache',
    'deploy:migrate',
    'deploy:seed',
    'deploy:assets',
    'deploy:cache',
    'deploy:reload:php',
    'deploy:reload:nginx',
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success'
]);


/*
 * [Optional] if deploy fails automatically unlock.
 * --------------------------------- */
after('deploy:failed', 'deploy:unlock');
