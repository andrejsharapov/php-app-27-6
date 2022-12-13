# Application

App for Module 27.6

[![php -v](https://img.shields.io/badge/php->=7.3-7377ad)](https://www.php.net/manual/en/langref.php)

## Tasks

+ Система регистраций должна позволять регистрироваться при помощи пары логин-пароль — +3 балла
+ Сделать страницу авторизации, на которой пользователь будет вводить заранее созданные логин и пароль — +3 балла
- Сделать авторизацию через VK (для этого на форме регистрации и авторизации нужно выводить отдельную кнопку «Авторизоваться через VK..». 
  - Страница авторизации должна быть создана с CSRF-токеном — +10 баллов
- Сделать систему с ролями «обычный пользователь» и «пользователь VK» — +5 баллов
- ± Сделать страницу, на которую нельзя попасть, пока пользователь не авторизован — +6 баллов 
  + На этой странице необходимо отобразить один абзац текста и одну картинку:
    + Текст должен быть виден всем авторизованным пользователям, 
    - картинка — только пользователям с ролью  «пользователь VK»
- Сделать систему хранения логов, которая будет записывать все неудачные попытки авторизации через логин и пароль — +3 балла

## How to launch

### With php

```bash
php -S localhost:8080
```

## Links

> **Note**  
> Follow the instructions [here to connect](database/db.sql) to the database.

The helpers.

### PHP & Mysqli

- [openssl_digest()](https://www.php.net/manual/en/function.openssl-digest.php)
- [mysqli](https://www.php.net/manual/en/book.mysqli.php)
- [mysqli_query()](https://www.php.net/manual/en/mysqli.query.php)
- [mysqli_num_rows()](https://www.php.net/manual/en/mysqli-result.num-rows.php)
- [mysqli_fetch_assoc()](https://www.php.net/manual/en/mysqli-result.fetch-assoc.php)
- [mysqli_stmt](https://www.php.net/manual/en/class.mysqli-stmt.php)

### VK

- [vk dev](https://dev.vk.com/api/getting-started)
- [access rights](https://dev.vk.com/reference/access-rights)
- [authorization](https://dev.vk.com/api/access-token/authcode-flow-user)
