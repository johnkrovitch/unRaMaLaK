# server configuration
set :application, "Unramalak"
set :domain,      ""
set :deploy_to,   "/home/user"
#set :deploy_via, :copy
set :app_path,    "app"

# ssh
set :user, ""
set :password, ""
set :use_sudo, false

# symfony
set :controllers_to_clear, true
set :dump_assetic_assets, true
set :model_manager, "doctrine"
set :use_composer, true
role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server

# capifony configuration
role    :app,
domain, :primary => true

# shared
set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,   [app_path + "/logs", "vendor"]

# cvs
set :scm,         :git
set :repository,  "https://github.com/johnkrovitch/streetart.git"
set :keep_releases,  5
set :update_vendors, true
set :branch, fetch(:branch, "master")

# fix capifony
default_run_options[:pty] = true

# permissions
set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "johnkrovitch"
set :permission_method,   :acl
set :use_set_permissions, true
set :dump_assetic_assets, true


# mise à jour du schema
before "symfony:cache:warmup", "symfony:doctrine:schema:update"
# migrations doctrines
before "symfony:cache:warmup", "symfony:doctrine:migrations:migrate"