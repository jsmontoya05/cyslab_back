##EJECUTAR PARA CREAR IMAGEN

sudo docker build -t cyslab-deployment --build-arg GITHUB_USERNAME=jvargascys \
--build-arg GITHUB_PASSWORD=Cys2021.. \
--build-arg LARAVEL_APP_NAME=cyslab \
--build-arg LARAVEL_APP_ENV=dev \
--build-arg LARAVEL_APP_DEBUG=true \
--build-arg LARAVEL_APP_URL=https://desolate-refuge-73283.herokuapp.com \
--build-arg LARAVEL_DB_CONNECTION=mysql \
--build-arg LARAVEL_DB_HOST=root \
--build-arg LARAVEL_DB_PORT=3306 \
--build-arg LARAVEL_DB_DATABASE=database \
--build-arg LARAVEL_DB_USERNAME=root \
--build-arg LARAVEL_DB_PASSWORD=123456 \
. --no-cache

docker tag cyslab-deployment conatainerregistriescyslabbackend.azurecr.io/cyslab-deployment

docker push conatainerregistriescyslabbackend.azurecr.io/cyslab-deployment

docker pull conatainerregistriescyslabbackend.azurecr.io/cyslab-deployment

configurar base de datos y credenciales secrets