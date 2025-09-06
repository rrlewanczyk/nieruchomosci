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
wp core install --url=${GCE_URL} --title="My WordPress" --admin_user="admin" --admin_password="admin" --admin_email="admin@example.com" --allow-root

# setup required plugins
wp plugin install elementor --activate --allow-root
wp plugin install woocommerce --activate --allow-root
wp plugin install wc-vendors --activate --allow-root
wp plugin install /usr/local/bin/plugins-zips/elementor-pro.zip --activate --allow-root
wp plugin install /usr/local/bin/plugins-zips/jet-smart-filters.zip --activate --allow-root
wp plugin install /usr/local/bin/plugins-zips/jet-engine-3.7.3.zip --activate --allow-root

# setup theme
wp theme install hello-elementor --allow-root

FUNCTIONS_PHP="wp-content/themes/hello-elementor-child/functions.php"
if [ ! -d FUNCTIONS_PHP ]; then
  wp scaffold child-theme hello-elementor-child --parent_theme=hello-elementor --allow-root;
else
  echo "Child theme directory already exists. Skipping." ;
fi
wp theme activate hello-elementor-child --allow-root

# copy code and import
if [ -f "$FUNCTIONS_PHP" ]; then
    REQUIRED_CODES=(
        "require_once get_stylesheet_directory() . '/src/importer.php';"
        "require_once get_stylesheet_directory() . '/src/cptui_register.php';"
        "require_once get_stylesheet_directory() . '/src/create_pages.php';"
    )

    for REQUIRED_CODE in "${REQUIRED_CODES[@]}"; do
        if grep -q "$REQUIRED_CODE" "$FUNCTIONS_PHP"; then
            echo "$REQUIRED_CODE: The code is already in the file. No action taken."
        else
            echo "$REQUIRED_CODE" >> "$FUNCTIONS_PHP"
        fi
    done
else
    echo "Error: $FUNCTIONS_PHP not found."
fi


exec docker-entrypoint.sh "$@"