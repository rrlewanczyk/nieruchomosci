#!/bin/bash

MYSQL_USER=${WORDPRESS_DB_USER}
MYSQL_PASSWORD=${WORDPRESS_DB_PASSWORD}
MYSQL_HOST=${WORDPRESS_DB_HOST}

echo "Waiting for the database..."
while ! mysqladmin ping -h $MYSQL_HOST -u $MYSQL_USER -p$MYSQL_PASSWORD --silent --skip-ssl; do
    sleep 1
done

echo "Database is ready. Installing plugins..."

# setup wordpress
wp core install --url="http://localhost:5500" --title="My WordPress" --admin_user="admin" --admin_password="admin" --admin_email="admin@example.com" --allow-root

# setup required plugins
wp plugin install elementor --activate --allow-root
wp plugin install woocommerce --activate --allow-root
wp plugin install wc-vendors --activate --allow-root
wp plugin install /usr/local/bin/plugins-zips/elementor-pro.zip --activate --allow-root
wp plugin install /usr/local/bin/plugins-zips/jet-smart-filters.zip --activate --allow-root
wp plugin install /usr/local/bin/plugins-zips/jet-engine-3.7.3.zip --activate --allow-root

# setup theme
wp theme install hello-elementor --allow-root

if [ ! -d "wp-content/themes/hello-elementor-child" ]; then
  wp scaffold child-theme hello-elementor-child --parent_theme=hello-elementor --allow-root;
else
  echo "Child theme directory already exists. Skipping." ;
  fi
wp theme activate hello-elementor-child --allow-root

# copy code and import
FUNCTIONS_PHP="wp-content/themes/hello-elementor-child/functions.php"
cp -r /usr/local/bin/code/* ./wp-content/themes/hello-elementor-child/

# importer
REQUIRED_CODE="require_once get_stylesheet_directory() . '/importer.php';"
if grep -q "$REQUIRED_CODE" "$FUNCTIONS_PHP"; then
    echo "$REQUIRED_CODE: The code is already in the file. No action taken."
else
    echo "$REQUIRED_CODE" >> "$FUNCTIONS_PHP"
fi

# cpt
REQUIRED_CODE="require_once get_stylesheet_directory() . '/cptui_register.php';"
if grep -q "$REQUIRED_CODE" "$FUNCTIONS_PHP"; then
    echo "$REQUIRED_CODE: The code is already in the file. No action taken."
else
    echo "$REQUIRED_CODE" >> "$FUNCTIONS_PHP"
fi

# pages
REQUIRED_CODE="require_once get_stylesheet_directory() . '/create_pages.php';"
if grep -q "$REQUIRED_CODE" "$FUNCTIONS_PHP"; then
    echo "$REQUIRED_CODE: The code is already in the file. No action taken."
else
    echo "$REQUIRED_CODE" >> "$FUNCTIONS_PHP"
fi


exec docker-entrypoint.sh "$@"