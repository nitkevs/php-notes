<?php

  /*
   * /includes/DB_connection.php предоставляет подключение
   * к базе данных в переменной $db_connection.
   *
   *
  */

  require_once './includes/DB_connection.php';
  require_once './includes/DB_tables.php';
  require_once './includes/classes/Note.php';

  session_start();

  $note = new Note();

  /*  Вренменная функция  */

  function show_error($mess, $err_mess, $query) {
    $_SESSION['error_message'] = $err_mess;
    $_SESSION['my_err_mess'] = $mess;
    $_SESSION['query'] = $query;
  }

  /*  Конец временной функции  */

  /*  Обработка входных данных  */

  // Если страница загружена методом POST,
  // записать данные из полей ввода в переменные.
  if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $note->id = $_POST['note-id'];
    $note->title = $_POST['note-title'];
    $note->content = $_POST['note-content'];
    $note->is_edited = $_POST['edit-note'];
    $note->for_delition = (bool)$_POST['delete-note'];

    $current_timestamp = time();

   //  Если заголовк пуст - взять первые 70 символов контента
    if ($note->title == '') {
      $note->title = $note->generate_title();
    }

    //  Удаляем переводы строк в заголовке заметки и преобразуем специальные символы
    $note->format();

    if ($note->is_edited) {

      $note->last_modified = $current_timestamp;

      $query = "UPDATE `pn_notes` SET `title` = '{$note->title}', `content` = '{$note->content}', `last_modified` = '{$note->last_modified}' WHERE `id` = {$note->id}";
      mysqli_query($db_connection, $query) or show_error('Ошибка записи', mysqli_error($db_connection), $query);

    } else if ($note->for_delition) {

  //  Удаляем заметку, если пользователь запросил это действие
      $query = "ааыапвапвпатро";
      mysqli_query($db_connection, $query) or show_error('Ошибка удаления', mysqli_error($db_connection), $query);

    } else {

      $note->timestamp = $current_timestamp;
      $query = "INSERT INTO `pn_notes` SET `title` = '{$note->title}', `content` = '{$note->content}', `timestamp` = '{$note->timestamp}'";
      $result = mysqli_query($db_connection, $query) or show_error('Ошибка записи', mysqli_error($db_connection), $query);

    }

}

header("Location: ./");
    /*  Конец обработки входных данных  */
