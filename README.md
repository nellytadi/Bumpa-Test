
## Bumpa App 

### How to Setup
1. Clone Repository
2. Run ```composer install```
3. Run ```php artisan key:generate```
4. Make a copy of .env.example as .env ```cp .env.example .env```
5. Create an empty database and update your database credentials to .env file
   ```    
    DB_DATABASE=your_database_name
    DB_USERNAME=root
    DB_PASSWORD=your_password
   ```
4. Update paystack details 
   ```
    PAYSTACK_PUBLIC_KEY=xxxxxxxxxxxxx
    PAYSTACK_SECRET_KEY=xxxxxxxxxxxxx
    PAYSTACK_PAYMENT_URL=https://api.paystack.co
    ```
5. Run migration ``` php artisan migrate ```
5. Run database seed to create sample data ``` php artisan db:seed ```

### Testing
1. Make a copy of .env to .env.testing ```cp .env .env.testing```
2. Setup Test environment 
```
DB_TEST_HOST=127.0.0.1
DB_TEST_PORT=3306
DB_TEST_DATABASE=bumpa_testdb
DB_TEST_USERNAME=root
DB_TEST_PASSWORD=password
```
3. Create Database




