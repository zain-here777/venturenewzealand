# Use the specific version of Ubuntu
FROM ubuntu:22.04

# Set environment variables to avoid user interaction during package installation
ENV DEBIAN_FRONTEND=noninteractive

# Update the package list
RUN apt-get update

# Install basic utilities
RUN apt-get install -y cron htop nano

# Install curl and PHP CLI
RUN apt-get install -y curl php-cli

# Install PHP extensions: gd, curl, dom, and xml
RUN apt-get install -y php-gd php-curl php-dom php-xml

# Install unzip
RUN apt-get install -y unzip

# Clean up APT when done
RUN apt-get clean

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the crontab file to the cron.d directory
# Assuming you have a crontab file named mycron
# COPY mycron /etc/cron.d/mycron

# Give execution rights on the cron job
# RUN chmod 0644 /etc/cron.d/mycron

# Apply cron job
# RUN crontab /etc/cron.d/mycron

# Expose port 80
EXPOSE 80

# Start cron in the foreground
CMD ["cron", "-f"]
