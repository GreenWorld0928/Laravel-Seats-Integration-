## Install
--------
Run
```bash 
composer install
cp .env.example .env
php artisan key:generate
```
Set the value of `SEATS_KEY` to your seats.io API key in `.env` file


## Routes
1. Create new chart and event `/api/create`
    ```
    Method: POST
    Body:
        name    // Chart name
    ```

2. Create new chart and event `/api/booking`
    ```
    Method: POST
    Body:
        event   // Event key
        seats   // Array of seats e.g.: ["Charis-A-4","Charis-G-6"]
    ```

3. Create new chart and event `/api/charts`
    ```
    Method: GET
    ```

