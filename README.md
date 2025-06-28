Para clonar o repositório utilizar:

```
git clone --recurse-submodules https://github.com/ciriacairic/lab-db.git
```

 > Obs:Garanta que o submodulo laradock tenha o seguinte repositório como remote: https://github.com/ciriacairic/laradock

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
php artisan migrate:fresh
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
Para acessar no navegador basta abrir um dos endereços que o Angular irá listar.
Para uma rota específica, consulto o arquivo app.routes.ts.

  > Obs: Notamos que dependendo da máquina, se já houver configurações de node, typescript ou angular,
  isso pode causar conflitos com o ambiente do container criado pelo laradock ao tentar rodar o frontend
  pelo container, uma das soluções pode ser usar o usuário root no container, e outra pode ser executar
  o front diretamente pela sua pasta fora do container, assim será necessário rodar os seguintes comandos:
  > ```
  > npm install
  > npm install -g @angular/cli
  > ng serve --host 0.0.0.0
  > ```
  > Neste cenário, será necessário desabilitar CORS no Angular, pois isso pode causar problemas com algumas
    APIs do backend.
