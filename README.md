<h1>Тестовое задание на позицию PHP-разработчика</h1>

<h2>Локальное развертывание (запускается на Linux или через wsl):</h2>
<h3>Если вы запускаетесь в первый раз:</h3>
<ol start="0">
<li>
Для запуска нужен Docker</li>

<li>
Склонировать репозиторий в корневую директорию пользователя</li>

<li>

Переименовать `.env.example` в `.env` <b>(обязательно восстановить после этого файл example.env)</b> </li>

<li>

Сгенерировать папку vendor `composer install --ignore-platform-reqs` </li>

<li> 

`sail up -d` - запуск сервера</li>

>Для того, чтобы выполнять запуск с помощью sail, необходимо в файл <b>.bashrc</b> (Находится в корневой дериктории пользователя) добавить `alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'`. Либо запускать через ./vendor/bin/sail<br>

<li>

 `sail artisan key:generate` сгенерировать ключ приложения</li>

<li>

`sail artisan passport:key` сгенерировать ключи кодирования для Laravel Passport</li>

<li>

`sail artisan migrate --seed` запустить миграции</li>

<li>

`sail artisan passport:client --personal` создать клиента Passport</li>

<li>

Полученные ID и ключ добавить в env-файл в поля `PASSPORT_PERSONAL_ACCESS_CLIENT_ID` и `PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET` соответственно</li>

</ol>

<h2>Эндпоинты API</h2>
Переопределил стандартные маршруты Laravel Passport на:<br>
`POST	api/passport/token`<br>
`POST	api/passport/token/refresh`<br>
`GET	api/passport/tokens`<br>
`DELETE	api/passport/tokens/{token_id}`<br>
`GET	api/passport/clients`<br>
`POST	api/passport/clients`<br>
`PUT	api/passport/clients/{client_id}`<br>
`DELETE	api/passport/clients/{client_id}`<br>
`GET	api/passport/scopes`<br>
`GET	api/passport/personal-access-tokens`<br>
`POST	api/passport/personal-access-tokens`<br>
`DELETE	api/passport/personal-access-tokens/{token_id}`<br>
Добавил свои маршруты:<br>
1)`POST api/register` - регистрация нового юзера<br>
Параметры:<br>
`name` - имя (Обязательное)<br>
`email` - почта (Обязательное)<br>
`password` - пароль (Обязательное)<br>
`partnership_id` - ID родительской организации(брать в таблице partnerships)(Обязательное)<br>
Ответ:<br>
`status` - статус<br>
`token` - Bearer-токен, необхожимой для дальнейшей аутентификации<br>

2)`POST api/login` - авторизация юзера<br>
Параметры:<br>
`email` - почта (Обязательное)<br>
`password` - пароль (Обязательное)<br>
Ответ:<br>
`status` - статус<br>
`token` - Bearer-токен, необходимый для дальнейшей аутентификации<br>

3)`GET api/sessions` - вывод всех активных токенов авторизованного юзера (Нужна аутентификация)

4)`DELETE api/sessions/{id}` - удаление токена с указанным ID(кроме текущего) (Нужна аутентификация)

5)`POST api/logout` - удаление текущего токена (Нужна аутентификация)

6)`GET api/workers` - вывод отфильтрованных исполнителей (Нужна аутентификация)<br>
Параметры:<br>
`exclude[]` - ID типа заказа<br>
Параметры передавать в виде `?exclude[0]=1&exclude[1]=2&exclude[2]=3` и далее<br>

7)`POST api/orders` - создание нового заказа (Нужна аутентификация)<br>
Параметры:<br>
`type_id` - тип заказа (Обязательное)<br>
`description` - описание<br>
`address` - адрес<br>
`amount` - кол-во<br>

8)`POST api/orders/{id}` - прикрепление исполнителя к заказу (Нужна аутентификация)<br>
Параметры:<br>
`worker_id` - ID исполнителя (Обязательное)<br>





