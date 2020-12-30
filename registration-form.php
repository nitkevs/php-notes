<?php

   /*
    * Форма регистрации пользователя.
    *
    * Переменные:
    *
    * $error_message: Сообщение об ошибке регистрации (если она есть).
    * $name: имя пользователя, если оно было введено до возникновения ошибки
    *   (например, если неправильно введена капча).
    * $email e-mail пользователя, если оно было введено до возникновения ошибки
    * $captcha->html_content: html-код блока капчи.
    *
    */

  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);

  include_once "{$_SERVER['DOCUMENT_ROOT']}/includes/registration.php";

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="/images/icons/favicon.ico">
  </head>
  <body>
    <main>
    <h1>Регистрация</h1>
    <p>Поля, отмеченные звёздочками обязательны для заполнения.</p>
    <form action="" method="post" id="register-form">
    <?php
      if ($error_message) {
        echo "<div id=\"reg-errors\">{$error_message}</div>";
      }
    ?>
      <label for="name" class="required">Имя:</label>
      <input type="text" id="login" name="name" maxlength="24" required pattern="[A-Za-z0-9_]{1,24}" value="<?= $name ?>">
      <div class="description">Имя может состоять из <span class="highlight">латинских букв, цифр и знака _ и быть длинной не более 24 символов</span>.</div>

      <label for="password" class="required">Пароль:</label>
      <input type="password" id="password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}">
      <div class="description">Пароль должен содержать по крайней мере одно число, одну заглавную и строчную буквы и быть длинной не менее 10 символов</div>

      <label for="confirm-password" class="required">Повторите пароль:</label>
      <input type="password" id="confirm-password"  name="confirm-password" required>
      <div class="description">Пароли должны совпадать.</div>

      <label for="email">Адрес e-mail:</label>
      <input type="email" id="email" name="email" value="<?= $email ?>">
      <div class="description">Это поле необязательно, но с помощью e-mail можно, в случае чего, восстановить пароль.</div>

        <?= $captcha->html_content; ?>

      <div class="term-conditions">
        <input type="checkbox" name="conditions-consent" id="conditions-consent" required> <label for="conditions-consent" class="required">Я согласен с <a href="javascript: showTerms();">правилами использования сервиса</a>.</label>
      </div>
      <button>Отправить</button>
    </form>
    <iframe src="term-conditions.php" id="term-conditions"></iframe>
    </main>
  <script src="js/registration-form.js"></script>
  </body>
</html>