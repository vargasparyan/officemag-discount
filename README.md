# officemag-discount
Manage user discount

# Важно знать!
По скольку реализация аутентификации занимает много времени, в текущей реализации задачи подразумивается, что пользовтель имеет доступ к UI и UI имеет доступ к серверу
Там где важна валидация отмечена след. образом ``` // TODO Тут должна быть валидация пользователя ```

# Installation
```html
git clone https://github.com/vargasparyan/officemag-discount.git
```


1)
```html
cd officemag-discount/
```
2)
```html
docker compose up -d
```

3)
```html
docker exec -it officemag-discount-php-fpm-1 sh
```
4) var/www/html #
```html
composer install
```
5) var/www/html #
```html
bin/console doctrine:migrations:migrate
```
Добавляем пользователей:
6) var/www/html #
```html
bin/console doctrine:fixtures:load
```
Приложение готово к пользованию. Переходим на страницу http://0.0.0.0:9000/user/list

Нажимаем на нужного нам пользователя и переходим на страницу http://0.0.0.0:9000/discount/view/1 , где работаем по требованиям задачи







