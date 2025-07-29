# 📆 Laravel Аналітична система

Цей проєкт — аналітична система для інтеграції двох зовнішніх джерел (Firma та Linker) з відображенням зведених даних у таблицях.

---

## ⚙️ Вимоги

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js + NPM
- Laravel 10+
- Cron доступ на сервері

---

## 🚀 Установка

1. Клонувати репозиторій:
```bash
git clone git remote add origin https://github.com/vitkonovaluck/analytical_system.git
cd analytical_system
```

2. Встановити залежності:
```bash
composer install
npm install && npm run build
```

3. Створити `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

4. Налаштувати `.env` — вказати:
```dotenv
DB_DATABASE=назва_бази
DB_USERNAME=користувач
DB_PASSWORD=пароль
```

5. Запустити міграції та сидери:
```bash
php artisan migrate --seed
```

---

## 🌱 Сидери / тестові дані

У проєкті є `database/seeders`:

```bash
php artisan db:seed
```

Можна виконати окремо:
```bash
php artisan db:seed --class=FirmaCatalogSeeder
php artisan db:seed --class=FirmaProductSeeder
php artisan db:seed --class=LinkerProductSeeder
php artisan db:seed --class=LinkerOrderSeeder
php artisan db:seed --class=LinkerOrderProductSeeder
```

Оскільки числа, що генерують фабрики випадкові, для перевірки роботи таблиці присвоюємо деякими звязаним товарам у LinkerProduct ціни та кількість із FirmaProduct: 
```bash
php artisan db:seed --class=TransferPricesSeeder
```

---

## ⏱️ Cron-команди Linux

У проєкті є команда для щогодинного імпорту даних:

```bash
php artisan data:sync
```

### 🔁 Додати в crontab:
```bash
crontab -e
```

Додайте рядок:
```bash
0 * * * * cd /повний/шлях/до/папки/проекту && php artisan schedule:run >> /dev/null 2>&1
```


---

## 📊 Перегляд таблиці

Запускаємо локальний сервер:

```bash
php artisan serve
```

Таблиця з даними доступна у браузері за адресою:

```
http://localhost:8000/
```

Там відображається порівняльна таблиця товарів із систем Firma та Linker.

---

## 📬 Зворотній зв'язок

Для зворотнього зв'язку зверніться на email: `vkonovaluck@gmail.com`.

