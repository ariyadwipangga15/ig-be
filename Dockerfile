FROM ubuntu:20.04

LABEL maintainer="PT GSI"

RUN apt-get update

# install localtime WIB
RUN apt-get install -yq tzdata && \
    ln -fs /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

# Memperbarui paket yang ada dan menginstal dependensi yang diperlukan
RUN apt-get update && \
    apt-get install -y curl \
    git \
    zip \
    unzip \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libpq-dev \
    libsqlite3-dev \
    sqlite3 \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Menginstal PHP 8
RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.2 \
    php8.2-cli \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-pgsql \
    php8.2-sqlite \
    php8.2-zip \
    php8.2-gd \
    libapache2-mod-php8.2 \
    && rm -rf /var/lib/apt/lists/*

# Menginstal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Menentukan direktori kerja
WORKDIR /app

# Menyalin kode sumber aplikasi Laravel
COPY . /app

# Menginstal dependensi aplikasi menggunakan Composer
#RUN composer install --no-interaction --optimize-autoloader

EXPOSE 8181

CMD php artisan serve --host=0.0.0.0 --port=8000