
## Innoscripts Backend Take Home Challenge

Installation Steps  
    - git clone https://github.com/Alionides/innoscript  
    - cp .env-example .env  
    - make fresh  
    - make migrate-fresh  
    - make start  

Api  
    - Get Articles http://127.0.0.1:8091/api/articles  
    - Search Articles http://127.0.0.1:8091/api/articles/search?source=CNN  

Database  
    - http://127.0.0.1:8091/adminerrrAliShikhiyev2024.php  
    - Server: database  
    - Username: innoscript_user  
    - Password: innoscript_db123  
    - Database: innoscript_db  
Schedule  
    - docker/entrypoint.sh runs this command every hour:  php artisan app:fetch-news  

Works with newsapi.org and NyTimes api others some is not working some didnt give api keys other no longer active
