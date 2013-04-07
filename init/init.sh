# init directories
mkdir web/bundles/krovitch/uploads

# set permissions for :
#  - cache
#  - logs
#  - uploads directory
#  - map data directory
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs src/Krovitch/KrovitchBundle/Resources/maps