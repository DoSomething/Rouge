namespace :laravel do
  desc 'Run NPM run build'
  task :npm_run_build do
    on roles(:all) do
      within "#{release_path}" do
        execute :npm, "run build"
      end
    end
  end

  desc 'Run Artisan tasks'
  task :artisan_tasks do
    on roles(:all) do
      within "#{release_path}" do
        execute :php, "artisan migrate --force && php artisan cache:clear"
      end
    end
  end

  desc 'Restart queue'
  task :restart_queue_worker, :on_error => :continue do
    on roles(:all) do
      run "ps -ef | grep 'queue:work' | awk '{print $2}' | xargs sudo kill -9"
    end
  end
end

namespace :deploy do
 after :updated, "laravel:npm_run_build"
 after :updated, "laravel:artisan_tasks"
 after :updated, "laravel:restart_queue_worker"
end
