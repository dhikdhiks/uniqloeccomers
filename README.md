## Cara Clone & Jalankan Project Ini

1. Clone repository:
   ```bash
   git clone https://github.com/dhikdhiks/uniqloeccomers.git
   cd uniqloeccomers
2. Checkout ke branch Master(andhika)
   ```bash
   git checkout master
4. Install dependency:
   ```bash
   composer install
   npm install && npm run build
6. Copy file .env:
   ```bash
   cp .env.example .env
8. Generate app key:
   ```bash
   php artisan key:generate
10. Konfigurasi database di file .env, lalu migrate, buat database baru beserta user non root
    ```bash
    mysql -u root
    CREATE DATABASE pkk;
    CREATE USER 'pkk'@'localhost' IDENTIFIED BY '123';
    GRANT ALL PRIVILEGES ON pkk.* TO 'pkk'@'localhost';
    FLUSH PRIVILEGES;
    EXIT;

12. php artisan serve / composer run dev
