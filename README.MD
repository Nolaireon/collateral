Version 1.1
============
Реализованы базовые функции авторизации, без поддержки веб интерфейса.
--------------
### Проверить работоспособность функций можно при помощи утилиты curl, ветка develop размещена по адресу <https://cb-collateral.pro/test/>.
#### Запрос на регистрацию пользователя `action=register`
```bash
curl -H "Content-Type: application/x-www-form-urlencoded" -X POST https://cb-collateral.pro/test/php/main.php?action=register -d "email=your@mail.com&password=your_password"
```

#### Запрос на авторизацию пользователя `action=login`
```bash
curl -H "Content-Type: application/x-www-form-urlencoded" -X POST https://cb-collateral.pro/test/php/main.php?action=login -c "/path/to/save/cookie" -d "email=your@mail.com&password=your_password"
```

#### Запрос на проверку авторизации пользователя `action=checkLogged`
```bash
curl -H "Content-Type: application/x-www-form-urlencoded" -X POST https://cb-collateral.pro/test/php/main.php?action=checkLogged -b "/path/to/load/cookie"
```

#### Запрос на удаление сессии пользователя (выход) `action=logout`
```bash
curl -H "Content-Type: application/x-www-form-urlencoded" -X POST https://cb-collateral.pro/test/php/main.php?action=logout -b "/path/to/load/cookie"
```

#### Запрос на обновление данных пользователя `action=clientDataUpdate`
```bash
curl -H "Content-Type: application/x-www-form-urlencoded" -X POST https://cb-collateral.pro/test/php/main.php?action=clientDataUpdate -b "/path/to/load/cookie" -d "name=Name&surname=Surname&patronymic=Patronymic&birth_day=YYYY-MM-DD"
```
***При проверки некоторых функций важно сохранять/загружать cookie, в противном случае сервер php не сможет определить Вас как авторизованного пользователя***