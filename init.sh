# create uploads directory if required
if [ ! -d "web/bundles/krovitch/uploads" ]; then
  mkdir "web/bundles/krovitch/uploads"
fi

# create maps directory if required
if [ ! -d "src/Krovitch/KrovitchBundle/Resources/maps" ]; then
  mkdir "src/Krovitch/KrovitchBundle/Resources/maps"
fi

# set permissions for :
#  - cache
#  - logs
#  - uploads directory
#  - map data directory
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
# TODO change file permissions
sudo chmod 777 src/Krovitch/KrovitchBundle/Resources/maps/

# init composer
php composer.phar update

# bower
bower install paper qunit jquery jquery.ui