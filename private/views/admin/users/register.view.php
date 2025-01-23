
<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>

<div class="container-fluid border rounded p-2 shadow-lg">
<!-- <div class="container-fluid border rounded col-lg-5 col-md-6 mt-5 p-2 shadow-lg"> -->

  <div class="container border border-primary rounded p-2">
    <center>
      <h1><i class="fa fa-users text-primary"></i></h1>
      <h3>Staffs Registertion Form</h3>
    </center>
  </div>

  <form class='mt-2 mb-2 row g-3' action="" method="POST">
    <div class="col-md-6">
      <div class="input-group">
        <input class='form-control <?= isset($errors['firstname']) ? 'border-danger' : 'border-primary';?>' type="text" name='firstname' value="<?=set_value('firstname')?>" placeholder='First Name' autofocus>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['firstname'])): ?> <?= $errors['firstname']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <input class='form-control <?= isset($errors['lastname']) ? 'border-danger' : 'border-primary';?>' type="text" name='lastname' value="<?=set_value('lastname')?>" placeholder='Last Name'>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['lastname'])): ?> <?= $errors['lastname']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <input class="form-control <?= isset($errors['username']) ? 'border-danger' : 'border-primary';?>" type="text" name='username' value="<?=set_value('username')?>" placeholder='User Name' autofocus>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['username'])): ?> <?= $errors['username']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <input class="form-control <?= isset($errors['email']) ? 'border-danger' : 'border-primary';?>" type="text" name='email' value="<?=set_value('email')?>" placeholder='Email'>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['email'])): ?> <?= $errors['email']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-4">
      <div class="input-group">
      <select class="form-select form-select <?= isset($errors['gender']) ? 'border-danger' : 'border-primary';?>" name="gender">
        <option <?= get_select('gender', '') ?> value="">Select Gender</option>
        <option <?= get_select('gender', 'male') ?> value="male">Male</option>
        <option <?= get_select('gender', 'female') ?> value="female">Female</option>
      </select>
      </div>
        <small class="text-danger">
        <?php if (isset($errors['gender'])): ?> <?= $errors['gender']?> <?php endif; ?>
        </small>
    </div>

    <div class="col-md-4">
      <div class="input-group">
        <select
          class="form-select form-select <?= isset($errors['usersRoleId']) ? 'border-danger' : 'border-primary'; ?>" name="usersRoleId">
          <!-- Default option -->
          <option <?= get_select('usersRoleId', '') ?> value="">Select Role</option>
          <!-- Options populated from the database -->
          <?php if ($roleRow): ?>
            <?php foreach ($roleRow as $role): ?>
                <option <?= get_select("usersRoleId", $role->roleId) ?> value="<?= $role->roleId ?>"> <?= $role->role ?> </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <small class="text-danger">
      <?php if (isset($errors['usersRoleId'])): ?> <?= $errors['usersRoleId']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-4">
      <div class="input-group">
        <select
          class="form-select form-select <?= isset($errors['usersSpecializeId']) ? 'border-danger' : 'border-primary'; ?>" name="usersSpecializeId">
          <!-- Default option -->
          <option <?= get_select('usersSpecializeId', '') ?> value="">Select Specialization</option>
          <!-- Options populated from the database -->
          <?php if ($specializeRow): ?>
            <?php foreach ($specializeRow as $specialize): ?>
                <option <?= get_select("usersSpecializeId", $specialize->specializeId) ?> value="<?= $specialize->specializeId ?>"> <?= $specialize->specialized ?> </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <small class="text-danger">
      <?php if (isset($errors['usersSpecializeId'])): ?> <?= $errors['usersSpecializeId']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <select class="form-select form-select <?= isset($errors['country']) ? 'border-danger' : 'border-primary';?>" name='country'>
          <option <?= get_select('country', '') ?> value="">Select Country</option>
          <option <?= get_select('country', 'uganda') ?> value="uganda">Uganda</option>
          <option <?= get_select('country', 'kenya') ?> value="kenya">Kenya</option>
        </select>
      </div>
      <small class="text-danger">
      <?php if (isset($errors['country'])): ?> <?= $errors['country']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <input class="form-control <?= isset($errors['phone']) ? 'border-danger' : 'border-primary';?>" type="text" name='phone' value="<?=set_value('phone')?>" placeholder='Enter Phone Number'>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['phone'])): ?> <?= $errors['phone']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <input class="form-control <?= isset($errors['password']) ? 'border-danger' : 'border-primary';?>" type="text" name='password' value="<?=set_value('password')?>" placeholder='Password'>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['password'])): ?> <?= $errors['password']?> <?php endif; ?>
      </small>
    </div>

    <div class="col-md-6">
      <div class="input-group">
        <input class="form-control <?= isset($errors['password_retype']) ? 'border-danger' : 'border-primary';?>" type="text" name='password_retype' value="<?=set_value('password_retype')?>" placeholder='Confirm Password'>
      </div>
      <small class="text-danger">
        <?php if (isset($errors['password_retype'])): ?> <?= $errors['password_retype']?> <?php endif; ?>
      </small>
    </div>

    <div class="">
      <button class='btn btn-primary btn-sm float-end'>Add User</button>
      <a href="index.php?pg=admin&tab=users" class='btn btn-warning btn-sm text-white'>Cancel</a>
    </div>
  </form>
</div>

<?php require $this->viewsPath('admin/head_foot/admin-footer') ?>
