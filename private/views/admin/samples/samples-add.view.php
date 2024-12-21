<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="col-lg-12 " style="margin-bottom: 150px;">
  <div class="container-fluid border rounded col-lg-6 mt-5 p-2 shadow-lg">
    <div class="container border border-primary rounded p-2">
      <center>
        <h2><i class="fa fa-flask"></i></i></h2>
        <h3>Create Sample Type</h3>
      </center>
    </div>

    <form class='' action="" method="POST">
      <input class="form-control my-2 <?= isset($errors['samplename']) ? 'border-danger' : 'border-primary';?>" type="text" name='samplename' value="<?=set_value('samplename') ?>" placeholder='Enter Samples Type' autofocus>
      <div class="text-danger">
        <?php if (isset($errors['samplename'])): ?> <?= $errors['samplename']?> <?php endif; ?>
      </div>
      <a href="<?=ROOT?>/Samples" class='btn btn-warning btn-sm mt-2'><i class="fa fa-chevron-left"></i>Back</a>
      <button class='btn btn-primary btn-sm mt-2 float-end'><i class="fa fa-add"></i>Save</button>
    </form>
  </div>

</div>

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
