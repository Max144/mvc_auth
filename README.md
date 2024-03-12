<h2> setting up the project </h2>

- Clone the repository
- cp .env.example .env
- docker-compose build
- docker-compose up -d
- docker compose exec php composer install
- docker compose exec php php artisan key:generate
- open .env file and set the database credentials
- open http://localhost:8080/ in your browser