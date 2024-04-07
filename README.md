## Como empezar
- Crear entorno de trabajo con contenedores (tener instalado la herramienta make) 

```bash
make rebuild
make run params=-d
source alias.sh
```

Luego de haber ejecutado, asegurarse que esta corriendo todos los contenedores

```bash
docker ps
... NAMES
... repoeval_nginx
... repoeval_php
... repoeval_mysql
```


- Instalar las dependencias 

```bash
composer install
```
- Instalar laravel y conectar con BD  agregar `.env` desde `.env.example`
```bash
php artisan key:generate
php artisan migrate:fresh --seed
sudo chmod -R +777 storage
php artisan storage:link
```
