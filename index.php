<?php

  /*
   * /includes/DB_connection.php предоставляет подключение
   * к базе данных в переменной $db_connection.
   *
  */

  require_once './includes/DB_connection.php';

  // Читаем БД, извлекам все заметки и записываем в массив $notes
  $query = "SELECT * FROM `pn_notes` ORDER BY `id` DESC";
  $result = mysqli_query($db_connection, $query);
  for ($notes = []; $row = mysqli_fetch_assoc($result); $notes[] = $row);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Заметки</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <header>
      <h1><a href="./">Заметки</h1>
      <nav id="header-navigation">
        <a href="note-edit.php">Добавить заметку</a>
        <a href="help.php">Справка</a>
      </nav>
    </header>
    <main>
      <div id="notes">
        <div id="notes-list">
<?php
            if (!$notes) {
              // Если заметок в БД нет, вывести надпись.
              echo "Здесь ещё ничего нет.<br><a href=\"note-edit.php\">Добавить заметку</a>";
            } else {
?>
          <ul>
<?php
  foreach ($notes as $a_note) {
    // Добавить тег <br> к переводам строк, чтобы они были отображены на странице.
    $a_note['content'] = nl2br($a_note['content']);
    // Выводим все тизеры на экран
    echo <<<"NOTES"
        <li onclick="showNoteContent(this)" onmouseover="showEditLinks(this);" onmouseout="hideEditLinks(this);">
          <div class="note-edit-buttons">
            <form action="./note-edit.php" method="post">
              <button title="Редактировать" name="edit-note" value="1" formaction="./note-edit.php">
                <img src="icons/edit.png" alt="Редактировать">
              </button>
              <button title="Удалить" name="delete-note" value="1" formaction="./write-note.php">
                <img src="icons/delete.png" alt="Удалить">
              </button>
              <input type="hidden" name="note-id" value="{$a_note['id']}">
              <input type="hidden" name="note-title" value="{$a_note['title']}">
              <input type="hidden" name="note-content" value="{$a_note['content']}">
            </form>
          </div>
          <p class="note-title" title="{$a_note['title']}">{$a_note['title']}</p>
          <p class="note-teaser">{$a_note['content']}</p>
        </li>
NOTES;
            }
          }

?>
          </ul>
        </div>
        <div id="note-content">
        <?php

          if ($notes) {
            echo "Кликните любую заметку, чтобы увидеть её содержимое.";
          } else {
            echo "Добавьте заметки, чтобы просматривать их в этой области.";
          }

        ?>
        </div>
      </div>
    </main>
  </body>
  <script>
    let oldActive;

    // функция выводит выбранную заметку на экран
    function showNoteContent(activeNote) {
      //  в переменную output записываем блок note-content, куда будет выведена заметка
      let output = document.getElementById('note-content');
      let noteTitle = activeNote.querySelector('.note-title').innerHTML;
      let noteContent = activeNote.querySelector('.note-teaser').innerHTML;
      // Если в переменной oldActive есть какой-то блок,
      if (oldActive) {
        // удалить его из класса active
        oldActive.classList.remove('active');
        }
      // а выбранному блоку присвоить класс active
      activeNote.classList.add('active');
      // записать выбранный активный блок в переменную oldActive
      oldActive = activeNote;
      output.innerHTML = "<h2>" + noteTitle + "</h2><p>" + noteContent + "</p>";
    }

    function showEditLinks(note) {
      let noteEditButtons = note.children[0];
      noteEditButtons.style.display = "block";
    }

    function hideEditLinks(note) {
      let noteEditButtons = note.children[0];
      noteEditButtons.style.display = "none";
    }

  </script>
</html>
