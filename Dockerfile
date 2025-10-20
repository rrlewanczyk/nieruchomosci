# Start from the official WordPress image
FROM wordpress:latest

# Update package lists and install the correct MySQL client
RUN apt-get update && apt-get install -y default-mysql-client

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# The command from the base WordPress image
CMD ["apache2-foreground"]