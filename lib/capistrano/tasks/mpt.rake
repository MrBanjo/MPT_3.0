namespace :mpt do
  desc 'Force database update'
  task :database do
    on roles(:app) do
      invoke 'symfony:console', :'doctrine:schema:update', '--force'
    end
  end

  desc 'Remove unecessary files'
  task :removefiles do
    on roles(:app) do
        execute "rm -rf #{release_path}/web/dev"
    end
  end

  desc 'Clear cache in prod'
  task :clearcacheprod do
    on roles(:app) do
      invoke 'symfony:console', :'cache:clear', '--env=prod'
    end
  end
  
end