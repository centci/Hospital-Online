<?php require $this->viewsPath('head_foot/header'); ?>

  <div class="container-fluid border rounded col-lg-4 col-md-5 mt-5 p-2 shadow-lg">

    <div class="container border border-primary rounded p-2">
      <center>
        <h1><i class="fa fa-user text-primary"></i></h1>
        <h3>Login</h3>
      </center>
    </div>

    <form class='mt-4 mb-2' action="" method="POST">
      <input class="form-control my-2 <?= isset($errors['email']) ? 'border-danger' : 'border-primary';?>" type="text" name='email' value="<?=set_value('email') ?>" placeholder='Email' autofocus>
      <small class="text-danger">
        <?php if (isset($errors['email'])): ?> <?= $errors['email']?> <?php endif; ?>
      </small>
      <input class="form-control my-2 <?= isset($errors['password']) ? 'border-danger' : 'border-primary';?>" type="text" name='password' value="<?=set_value('password') ?>" placeholder='Password'>
      <small class="text-danger">
        <?php if (isset($errors['password'])): ?> <?= $errors['password']?> <?php endif; ?>
      </small>
      <button class='btn btn-primary btn-sm form-control mt-3'><i class="fa fa-lock"></i> Login</button>
      <div class="clearfix">
      </div>
    </form>

  </div>

<?php require $this->viewsPath('head_foot/footer'); ?>
