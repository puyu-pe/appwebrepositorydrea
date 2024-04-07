@servers(['web' => 'qwvjbwte@repositorioedreapurimac.com -p 2222'])

@setup
    $repository = 'git@github.com:puyu-pe/appwebrepositorydrea.git';
    $base_dir = '/home1/qwvjbwte/public_html';
    $folder_releases = 'releases';
    $releases_dir = '';
    $app = 'app';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
    $branch = 'main';
@endsetup

@story('deploy')
    setting_variables
    clone_repository
    run_composer
    update_symlinks
{{--    run_migrations--}}
@endstory

@task('setting_variables')
    echo 'Config Variables'
    @if ($env == 'prod')
        true {{ $app = 'app' }}
        true {{ $branch = 'main' }}
    @else
        true {{ $app = 'app-dev' }}
        true {{ $branch = 'develop' }}
    @endif

    true {{ $app_dir = $base_dir . '/' . $app }}
    true {{ $releases_dir = $app_dir . '/' . $folder_releases }}
    true {{ $new_release_dir = $releases_dir .'/'. $release }}

    echo {{ 'app_dir = ' . $app_dir }}
    echo {{ 'releases_dir = '. $releases_dir }}
    echo {{ 'new_release_dir = '. $new_release_dir }}
@endtask

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 -b {{$branch}} {{ $repository }} {{ $new_release_dir }}
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
/opt/cpanel/composer/bin/composer install --ignore-platform-reqs --prefer-dist --no-scripts -q -o
@endtask

@task('update_symlinks')
    echo "Linking storage directory"

    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current

    echo 'Run storage:link'
    /opt/cpanel/ea-php83/root/usr/bin/php {{ $new_release_dir }}/artisan storage:link
@endtask

@task('run_migrations')
    php {{ $new_release_dir }}/artisan migrate --force
@endtask
