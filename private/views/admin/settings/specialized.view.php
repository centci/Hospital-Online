<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="col-lg-12">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Specialization</h3> <!-- Use `mb-0` to remove default margin -->
      <a href="<?=ROOT ?>/specializations/add">
        <button class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>
      </a>
    </div>
    <div class="card-body">
      <?php if (message()): ?><!-- Success message. -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          <?=message('', true) ?>!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?><!-- Success message end. -->

      <!-- Table with hoverable rows -->
      <table class="table table-hover table-stripped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Specialized</th>
            <th scope="col">Created By</th>
            <th scope="col" class="text-center">Record Date</th>
            <th scope="col" class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($data): ?>
            <?php $num = 0; foreach ($data as $row): $num++; ?>

            <tr>
              <th scope="row"><?= $num ?></th>
              <td><?=$row->specialized ?></td>
              <td><?=$row->userInfo->fullname?></td>
              <td class="text-center"><?=get_date($row->date) ?></td>
              <td class="text-end">
                <a href="<?=ROOT?>/specializations/edit/<?=$row->id?>" class="text-primary"><i class="fa fa-edit"></i></a>|
                <a href="<?=ROOT?>/specializations/delete/<?=$row->id?>" class="text-danger"><i class="fa fa-trash-alt"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <td colspan="6">
            <h4 class="text-center">No Records Found At This Time</h4>
          </td>
        <?php endif; ?>
        </tbody>
      </table>
      <!-- End Table with hoverable rows -->
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
      <h5 class="mb-0">footer</h5> <!-- Use `mb-0` to remove default margin -->
    </div>
  </div>
</div>

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
