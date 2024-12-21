<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="col-lg-12 " style="margin-bottom: 150px;">

  <div class="container-fluid border rounded col-lg-6 mt-5 p-2 shadow-lg">
    <div class="container border border-primary rounded p-2">
      <center>
        <h2><i class="fa fa-flask"></i></i></h2>
        <h3>Edit Insurance</h3>
      </center>
    </div>

    <form class='' action="" method="POST">
      <input class="form-control my-2 <?= isset($errors['insuranceName']) ? 'border-danger' : 'border-primary';?>" type="text" name='insuranceName' value="<?=set_value('insuranceName',$row->insuranceName) ?>" placeholder='Enter Insurance' autofocus>
      <div class="text-danger">
        <?php if (isset($errors['insuranceName'])): ?> <?= $errors['insuranceName']?> <?php endif; ?>
      </div>
      <a href="<?=ROOT?>/insurances" class='btn btn-warning btn-sm mt-2'><i class="fa fa-chevron-left"></i>Back</a>
      <button class='btn btn-primary btn-sm mt-2 float-end'><i class="fa fa-add"></i>Save</button>
    </form>
  </div>

</div>

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
