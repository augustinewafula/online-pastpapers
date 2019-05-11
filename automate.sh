#bin/bash



while true; do
    echo "Running"
    php artisan schedule:run
    sleep 1m
done