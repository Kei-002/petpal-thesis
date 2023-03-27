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
