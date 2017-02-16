<div class="form-wrapper">
    <?php if (isset($message)): ?>
      <p class="message <?php echo $message_class; ?>"><?php echo $message ?>
    <?php endif; ?>

    <form class="auth-form" action="register.php" method="post">
      <label for="login">Логин</label>
      <input type="text" id="login" name="login"><br>
      <label for="password">Пароль</label>
      <input type="password" id="password" name="password"><br>
      <label for="repeat">Повторите</label>
      <input type="password" id="repeat" name="repeat"><br>
      <input type="submit" value="Отправить">
    </form>
</div>
