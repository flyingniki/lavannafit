# Fitness Site: Лендинг + Админка Тренера

Проект на Laravel + Inertia + Vue для фитнес-тренера:
- публичный лендинг с заявкой;
- админ-панель для управления контентом;
- сохранение заявок в базу;
- уведомления о новых заявках в Email и/или Telegram.

## 1) Для разработчика

### Стек
- PHP 8.3+
- Laravel 13
- Inertia.js + Vue 3
- Vite + Tailwind CSS v4
- MySQL или SQLite

### Что уже реализовано
- Главная страница: блоки Hero, About, Tariffs, Reviews, Results, Contacts.
- Админка: вход, дашборд, тарифы, отзывы, результаты, заявки, настройки сайта.
- Загрузка изображений (результаты/фото тренера) через storage disk `public`.
- Обработка заявок через `POST /contact`.
- Уведомления о заявках:
	- Email тренеру;
	- Telegram тренеру.

### Быстрый запуск (локально)
1. Установить зависимости:

```bash
composer install
npm install
```

2. Сгенерировать ключ приложения:

```bash
php artisan key:generate
```

> Файл `.env` уже присутствует в репозитории с базовыми значениями. Заполните нужные переменные согласно разделу 2.

3. Настроить базу данных в `.env`.

Вариант A: MySQL
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitness
DB_USERNAME=root
DB_PASSWORD=your_password
```

Вариант B: SQLite
```env
DB_CONNECTION=sqlite
```

4. Применить миграции и сиды:

```bash
php artisan migrate --seed
```

5. Подготовить storage (обязательно для картинок):

```bash
php artisan storage:link
```

6. Запустить проект:

```bash
php artisan serve
npm run dev
```

или одной командой:

```bash
composer dev
```

### Продакшн-сборка фронтенда

```bash
npm run build
```

## 2) Переменные окружения (куда что вставлять)

### Базовые
В файл `.env`:

```env
APP_NAME=FitOnline
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

### Админка: дефолтный пользователь
Создается сидером (`DatabaseSeeder`):
- Email: `admin@fitonline.ru`
- Password: `Admin1234!`

После первого входа рекомендуется сменить пароль в БД/через дополнительный функционал.

### Настройка Email-уведомлений о заявках
В `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_login
MAIL_PASSWORD=your_smtp_password
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="FitOnline"

TRAINER_NOTIFICATION_EMAIL=trainer@example.com
LEAD_NOTIFY_EMAIL=true
```

Если хотите временно выключить email-уведомления:

```env
LEAD_NOTIFY_EMAIL=false
```

### Настройка Telegram-уведомлений о заявках
1. Создайте бота через BotFather и получите `TELEGRAM_BOT_TOKEN`.
2. Напишите боту хотя бы 1 сообщение.
3. Получите `chat_id` (например, через `getUpdates`).

В `.env`:

```env
LEAD_NOTIFY_TELEGRAM=true
TELEGRAM_BOT_TOKEN=123456:ABCDEF...
TELEGRAM_CHAT_ID=123456789
```

Если Telegram не нужен:

```env
LEAD_NOTIFY_TELEGRAM=false
```

### Применить изменения env

```bash
php artisan config:clear
php artisan cache:clear
```

## 3) Как работает заявка

1. Пользователь заполняет форму на сайте.
2. `POST /contact` валидирует данные и сохраняет запись в таблицу `contacts`.
3. После сохранения запускается сервис уведомлений:
	 - Email (если включен);
	 - Telegram (если включен).
4. Пользователь видит успех в форме: `Спасибо! Мы свяжемся с вами в ближайшее время.`
5. Если есть ошибки валидации, показываются ошибки под полями.
6. Если упал канал уведомления (SMTP/Telegram), заявка все равно сохраняется, а ошибка пишется в лог.

## 4) Для тренера (инструкция пользователя)

### Как войти
1. Откройте: `http://127.0.0.1:8000/admin/login`
2. Введите логин/пароль администратора.

### Разделы админки
- Дашборд: общая статистика.
- Тарифы: добавить/редактировать/удалить тарифы.
- Отзывы: управлять отзывами.
- Результаты: загрузка фото-кейсов в карусель.
- Заявки: список всех входящих заявок, отметка прочитанного.
- Настройки: тексты главной страницы, контакты, SEO, блок "Обо мне", фото тренера.

### Что важно после изменений
- После редактирования нажимайте `Сохранить`.
- Фото тренера и фото результатов загружаются в `storage/app/public`.
- Если фото не отображается на сайте, проверьте, что создана ссылка:

```bash
php artisan storage:link
```

## 5) Основные URL
- Сайт: `/`
- Политика: `/privacy`
- Sitemap: `/sitemap.xml`
- Вход в админку: `/admin/login`
- Админка: `/admin`

## 6) Диагностика и частые проблемы

### Изменения во Vue не видны
```bash
npm run build
```
и обновить страницу с очисткой кеша браузера (`Ctrl+F5`).

### 404 на ссылки
Проверьте `php artisan route:list`.

### Не приходят email-уведомления
Проверьте SMTP-параметры в `.env` и значение `LEAD_NOTIFY_EMAIL=true`.

### Не приходят Telegram-уведомления
Проверьте:
- `LEAD_NOTIFY_TELEGRAM=true`
- корректность `TELEGRAM_BOT_TOKEN`
- корректность `TELEGRAM_CHAT_ID`
- что боту уже написали в Telegram.

### Логи
Смотрите ошибки в:
- `storage/logs/laravel.log`

## 7) Что пока не реализовано
- Онлайн-оплата (Stripe/ЮKassa/CloudPayments и т.д.) в проекте не подключена.
- Telegram username в публичном блоке контактов сейчас задан как заглушка и при необходимости должен быть вынесен в настройки.

## 8) Рекомендации перед боевым запуском
1. Сменить пароль админа.
2. Выключить debug:

```env
APP_DEBUG=false
APP_ENV=production
```

3. Настроить корректные `APP_URL`, `MAIL_*`, Telegram-переменные.
4. Выполнить сборку:

```bash
npm run build
php artisan config:cache
php artisan route:cache
```

## 9) Деплой без Node.js на сервере (ветки dev/prod)

Если на хостинге нельзя стабильно запускать `npm run build`, используйте схему "сборка вне сервера":

1. Сборка выполняется локально или в CI.
2. Готовые ассеты из `public/build` коммитятся в git.
3. Сервер делает только `git pull` + Laravel-команды (без Node).

### Что важно в репозитории

- `public/build` должен храниться в git (в этом проекте уже настроено).
- `node_modules` остается в `.gitignore`.
- На сервере должны быть: исходники Laravel, `public/build`, `vendor` (или установка через composer), рабочие `storage` и `.env`.

### Типовой поток по веткам

Работа в `dev`:

```bash
git checkout dev
npm ci
npm run build
git add public/build
git commit -m "build: update production assets"
git push origin dev
```

Публикация в `prod`:

```bash
git checkout prod
git merge --ff-only dev
git push origin prod
```

### Серверный деплой из ветки prod

```bash
git pull origin prod
sh scripts/deploy_after_pull.sh
```

Скрипт `scripts/deploy_after_pull.sh` выполняет:

- `composer install --no-dev --prefer-dist --optimize-autoloader`
- `php artisan migrate --force`
- `php artisan optimize:clear`
- `php artisan optimize`

### Автозапуск после git pull

Git-хуки не хранятся внутри `.git/hooks` в репозитории, поэтому добавлен шаблон:

- `scripts/post-merge.hook.sample`

На сервере установите его один раз:

```bash
cp scripts/post-merge.hook.sample .git/hooks/post-merge
chmod +x .git/hooks/post-merge
```

После этого `git pull` будет автоматически запускать деплой-команды.
