# init directories
mkdir web/bundles/krovitch/uploads

# set permissions
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs web/bundles/krovitch/uploads