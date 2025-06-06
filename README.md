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
