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
        execute "rm -r #{release_path}/web/scss"
    end
  end

  desc 'Clear cache in prod'
  task :clearcacheprod do
    on roles(:app) do
      invoke 'symfony:console', :'cache:clear', '--env=prod'
    end
  end

  after 'deploy:finished', 'mpt:database'
  after 'deploy:finished', 'mpt:removefiles'
  after 'deploy:finished', 'mpt:clearcacheprod'
end