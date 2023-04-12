## Run Locally

Clone the project

```bash
  git clone https://github.com/Kei-002/petpal-thesis.git
```

Go to the project directory

```bash
  cd /frontend
```

Install dependencies

```bash
  composer install
  composer update
```

Locate the .env.example file and remove the .example on the name
```bash
  .env.example -> .env
```

Add your database information in .env
```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=
  
  //Add mailtrap information too
  MAIL_MAILER=smtp
  MAIL_HOST=mailpit
  MAIL_PORT=1025
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS="hello@example.com"
  MAIL_FROM_NAME="${APP_NAME}"
  
```

Generate key
```bash
  php artisan key:generate
```

Migrate and seed database 
```bash
  php artisan migrate:fresh --seed
```

Start the server
```bash
  php artisan optimize
  php artisan serve
```

## Admin account

email: admin@admin.com  
password : password 

### User Accounts
common password for all accounts that are seeded  
```bash
  password
```
