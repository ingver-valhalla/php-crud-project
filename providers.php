<?php include('header.php') ?>

  <?php include('user_block.php') ?>

  <div class="nav-container">
    <ul class="navbar">
      <li><a href="parts.php">Детали</a></li>
      <li><a href="projects.php">Проекты</a></li>
      <li><a>Поставщики</a></li>
      <li><a href="cities.php">Города</a></li>
      <li><a href="index.php" class="start-page">Главная страница</a></li>
    </ul>
  </div>

  <div class="content">

    <?php $query = 'SELECT id, name, city_id from providers'; ?>
    <?php include('query_n_print.php') ?>

  </div>

<?php include('footer.php') ?>
