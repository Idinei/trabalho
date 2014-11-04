<meta charset="UTF-8"/>
<?php echo validation_errors(); ?>
<?php echo form_open('captcha'); ?>
<p>
  <label for="name">Nome:
    <input id="name" name="name" type="text" />
  </label>
</p>
<?php echo $image; ?>
<p>
  <label for="name">Código:
    <input id="captcha" name="captcha" type="text" />
  </label>
</p>
<?php echo form_submit("submit", "Enviar"); ?>
<?php echo form_close(); ?>