<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="col-lg-12 " style="margin-bottom: 150px;">
  <!-- warnning message div -->
  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    Are You Sure You Want To Delete This Department??!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <div class="container-fluid border rounded col-lg-6 mt-5 p-2 shadow-lg">
    <div class="container border border-primary rounded p-2">
      <center>
        <h2><i class="fa fa-flask"></i></i></h2>
        <h5 class="text-primary">Tests Department</h5>
      </center>
    </div>

    <form class='' action="" method="POST">
      <input class="form-control my-2 <?= isset($errors['department']) ? 'border-danger' : 'border-primary';?>" type="text" name='department' value="<?=set_value('department',$row->department) ?>" placeholder='Enter Laboratory' autofocus>
      <div class="text-danger">
        <?php if (isset($errors['department'])): ?> <?= $errors['department']?> <?php endif; ?>
      </div>
      <a href="<?=ROOT?>/Departments" class='btn btn-primary btn-sm mt-2'><i class="fa fa-chevron-left"></i>Back</a>
      <button class='btn btn-danger btn-sm mt-2 float-end'><i class="fa fa-trash-alt"></i>Delete</button>
    </form>
  </div>
</div>

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>