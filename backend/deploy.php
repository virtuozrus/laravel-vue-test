<?php
namespace Deployer;
require 'recipe/common.php';
require 'recipe/npm.php';

// Configuration

set('ssh_type', 'native');
set('ssh_multiplexing', true);

set('repository', 'git@gitlab.com:Troodon/fulltest.git');
set('shared_files', ['backend/.env']);
set('shared_dirs', ['backend/storage/app', 'backend/storage/framework/cache/data', 'backend/storage/framework/sessions',
                    'backend/storage/framework/testing', 'backend/storage/framework/views', 'backend/storage/logs']);

// Servers

host('bank.bonnieandslide.com')
    ->user('bank-bonnieandslide-com')
    ->identityFile( '~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/bank.bonnieandslide.com/bitva/');


// Tasks
desc('Deploy your project');

task('frond:build', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }

    run("cd {{release_path}}/front && {{bin/npm}} install && {{bin/npm}} run build");
    run("cd {{release_path}} && cp -r front/dist public/ && cp -r backend/resources/views/home.blade.php backend/resources/views/errors/404.blade.php");
});

task('deploy:vendors2', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/backend/vendor ]')) {
            run('cp -R {{previous_release}}/backend/vendor {{release_path}}backend/');
        }
    }

    run("cd {{release_path}}/backend && {{bin/composer}} install --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-suggest");
});


task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php7.1-fpm restart'); // Using SysV Init scripts
});


task('reload:nginx', function () {
    run('sudo /etc/init.d/nginx restart'); // Using SysV Init scripts
});

task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
	'frond:build',
    'deploy:shared',
    'deploy:writable',
	'deploy:vendors2',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'reload:php-fpm',
    'reload:nginx',
    'cleanup',
    'success'
]);


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
