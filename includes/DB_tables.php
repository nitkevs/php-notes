 <?php

  /* Создаём таблицу pn_notes, если она ещё не существует */

 $query = "CREATE TABLE IF NOT EXISTS `pn_notes` (id int(6) PRIMARY KEY AUTO_INCREMENT, `title` varchar(255), `content` longtext, `timestamp` varchar(10) NOT NULL UNIQUE, `last_modified` varchar(10))";
  $result = mysqli_query($db_connection, $query);
