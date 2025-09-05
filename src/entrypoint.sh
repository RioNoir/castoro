#!/bin/sh

echo "
 ██████╗ █████╗ ███████╗████████╗ ██████╗ ██████╗  ██████╗
██╔════╝██╔══██╗██╔════╝╚══██╔══╝██╔═══██╗██╔══██╗██╔═══██╗
██║     ███████║███████╗   ██║   ██║   ██║██████╔╝██║   ██║
██║     ██╔══██║╚════██║   ██║   ██║   ██║██╔══██╗██║   ██║
╚██████╗██║  ██║███████║   ██║   ╚██████╔╝██║  ██║╚██████╔╝
 ╚═════╝╚═╝  ╚═╝╚══════╝   ╚═╝    ╚═════╝ ╚═╝  ╚═╝ ╚═════╝
"

set -e
set -e
info() {
    { set +x; } 2> /dev/null
    echo '[INFO] ' "$@"
}
warning() {
    { set +x; } 2> /dev/null
    echo '[WARNING] ' "$@"
}
fatal() {
    { set +x; } 2> /dev/null
    echo '[ERROR] ' "$@" >&2
    exit 1
}

echo ""
echo "***********************************************************"
echo " Starting Castoro Docker Container                   "
echo "***********************************************************"

#Directories customizations
rm -rf $CSTR_DATA_PATH/app/sessions
rm -rf $CSTR_DATA_PATH/app/cache
rm -rf $CSTR_DATA_PATH/app/response
rm -rf $CSTR_DATA_PATH/app/logs
rm -rf $CSTR_DATA_PATH/nginx/logs
rm -rf $CSTR_DATA_PATH/jellyfin/log
rm -rf $CSTR_DATA_PATH/jellyfin/cache

info "-- Creating the necessary folders if they do not already exist"
mkdir -p $CSTR_DATA_PATH/app/sessions
mkdir -p $CSTR_DATA_PATH/app/cache
mkdir -p $CSTR_DATA_PATH/app/response
mkdir -p $CSTR_DATA_PATH/app/logs
mkdir -p $CSTR_DATA_PATH/jellyfin/cache
mkdir -p $CSTR_DATA_PATH/jellyfin/log
mkdir -p $CSTR_DATA_PATH/jellyfin/config
mkdir -p $CSTR_DATA_PATH/nginx/logs
mkdir -p $CSTR_DATA_PATH/library

#Laravel customizations
info "-- Configuring the basic dependencies of the app"
if [ ! -f $CSTR_DATA_PATH/app/database.sqlite ]; then
  cp /var/www/database/database.sqlite $CSTR_DATA_PATH/app/database.sqlite
fi
composer install --no-interaction --prefer-dist --optimize-autoloader 2> /dev/null
php artisan migrate 2>&1 > /dev/null
php artisan queue:clear 2>&1 > /dev/null

#Jellyfin customizations
info "-- Performing customizations to Jellyfin"
if [ -d /usr/share/jellyfin/web ]; then
  #Logos customizations
  cp -r /var/src/img/* /usr/share/jellyfin/web/assets/img
  cp -r /var/src/img/web-icons/* /usr/share/jellyfin/web/

  #Favicons customizations
  find "/usr/share/jellyfin/web/" -type f -name "*.ico" | while read -r file; do
      cp "/var/src/img/web-icons/favicon.ico" "$file"
  done

  #Theme customizations
  CUSTOM_THEME="\n\n $(cat /var/src/themes/theme.css)"
  if [ ! -f $CSTR_DATA_PATH/jellyfin/web/themes/custom.css ]; then
      echo "$CUSTOM_THEME" > /usr/share/jellyfin/web/themes/custom.css
      echo "$CUSTOM_THEME" >> /usr/share/jellyfin/web/themes/dark/theme.css
      echo "$CUSTOM_THEME" >> /usr/share/jellyfin/web/themes/light/theme.css
      echo "$CUSTOM_THEME" >> /usr/share/jellyfin/web/themes/appletv/theme.css
      echo "$CUSTOM_THEME" >> /usr/share/jellyfin/web/themes/blueradiance/theme.css
      echo "$CUSTOM_THEME" >> /usr/share/jellyfin/web/themes/purplehaze/theme.css
      echo "$CUSTOM_THEME" >> /usr/share/jellyfin/web/themes/wmc/theme.css
  fi

  #Settings customizations
  cp /var/src/jellyfin/config/network.xml $CSTR_DATA_PATH/jellyfin/config/network.xml
  if [ ! -f $CSTR_DATA_PATH/jellyfin/config/branding.xml ]; then
    cp /var/src/jellyfin/config/branding.xml $CSTR_DATA_PATH/jellyfin/config/branding.xml
  fi
  if [ ! -f $CSTR_DATA_PATH/jellyfin/config/system.xml ]; then
    cp /var/src/jellyfin/config/system.xml $CSTR_DATA_PATH/jellyfin/config/system.xml
  fi
fi

#MediaFlowProxy configuration
API_PASSWORD=$(head /dev/urandom | tr -dc A-Za-z0-9 | head -c 32)
export API_PASSWORD="$API_PASSWORD"

#Folder permissions
info "-- Changing permissions to folders and files"
chown -R $USER_NAME:$GROUP_NAME $CSTR_DATA_PATH

echo ""
echo "***********************************************************"
echo " Starting Castoro Services...                              "
echo " Castoro will be available on: http://localhost:8096       "
echo "***********************************************************"

## Start Supervisord
supervisord -n -c /etc/supervisor/supervisord.conf

