Para clonar o repositório utilizar:

```
git clone --recurse-submodules https://github.com/ciriacairic/lab-db.git
```

## Backend

### Set up the containers

Na pasta do projeto:

```
cp .env.example .env
```
Na pasta do laradock:

```
cp .env.example .env
sh docker-compose-up.sh
```
Acesse o container workspace
```
docker-compose exec --user=laradock workspace bash
composer install
php artisan migrate
php artisan key:generate
```
Para seedar os bancos:
```
php artisan crawler-steam
php artisan seed-ps-mongo
php artisan seed-neo
```
Para executar o teste do banco:
```
php artisan test-db
```
Para a API servir as requisições execute:
```
php artisan serve --host=0.0.0.0 --port=8000
```

## Frontend
Acesse o container workspace como root
```
docker-compose exec workspace bash
```
Entre na pasta:
```
cd frontend/ldb-reviews
```
Rode os seguintes comandos:
```
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt-get install -y nodejs
npm install
npm install -g @angular/cli
ng serve --host 0.0.0.0
```
Para acessar no navegador:
