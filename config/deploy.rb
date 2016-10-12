# config valid only for current version of Capistrano
lock '3.6.1'

set :application, 'catering'
set :repo_url, 'git@github.com:Dry7/crm_catering.git'

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp
set :branch, :develop

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/var/www/catering'

# Default value for :scm is :git
set :scm, :git

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: 'log/capistrano.log', color: :auto, truncate: :auto

# Default value for :pty is false
set :pty, true

# Default value for :linked_files is []
append :linked_files, '.env'

# Default value for linked_dirs is []
# append :linked_dirs, 'log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'public/system'

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 5

set :composer_install_flags, '--no-interaction --quiet --optimize-autoloader'

set :npm_flags, ''

set :file_permissions_paths, ["bootstrap/cache", "storage"]
set :file_permissions_chmod_mode, "0777"

namespace :laravel do
    desc "Run migrations"
    task :migrate do
        on roles(:app), in: :sequence, wait: 5 do
            within release_path do
                execute :php, "artisan migrate --force"
            end
        end
    end
end

namespace :deploy do
    before :updated, 'gulp'
    before "deploy:updated", "deploy:set_permissions:chmod"

    after :published, "laravel:migrate"
end