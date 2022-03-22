# Задача

0. Время на выполнение задания - 1 час.
1. Список комментариев фронта должны подгружаться из данных по ссылке `/api/posts` (`http://localhost/api/posts`).
2. Сделать запись комментария (желательно в базу, но можно в любом виде). Ссылка в api `/posts/new`. Записанные комментарии так же должны выводиться по ссылке комментариев `/api/posts`

## Frontend
```
cd front
npm i
npm run dev
```

## Backend
```
docker-compose up
```
Подключиться к контейнеру `php` и выполнить внутри него команду
```
/fulltest/backend/composer.phar install
```
