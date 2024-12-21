<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="col-lg-12">
  <h4 class="breadcrumb-item">View All Tests Created</h4>
  <div class="card px-2">

    <nav class="navbar navbar-light bg-light">
      <form class="form-line">
        <div class="input-group">
          <input class="form-control" type="text" name="find" value="" placeholder="Search">
          <span class="input-group-prepend">
            <button class="input-group-text"><i class="fa fa-search"></i>&nbsp</button>
          </span>
        </div>
      </form>
      <a href="<?=ROOT ?>/Tests/add"><!-- Add Lab Tests. -->
        <button class="btn btn-sm btn-primary m-2 float-end"><i class="fa fa-plus"></i>Add Test</button>
      </a><!-- End Add Lab Tests -->
    </nav>

    <?php if (message()): ?><!-- Success message. -->
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        <?=message('', true) ?>!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?><!-- Success message end. -->

    <div class="card-body table-responsive">
      <!-- Table with hoverable rows -->
      <table class="table table-hover table-stripped">
        <thead>
          <tr>
            <th>S/N</th>
            <th class="tb-nowrap">Tests</th>
            <th class="tb-nowrap">Section</th>
            <th class="tb-nowrap">Sample</th>
            <th class="tb-nowrap">Ranges</th>
            <th class="tb-nowrap">Unit</th>
            <th class="tb-nowrap">Status</th>
            <th class="tb-nowrap text-end">Created By</th>
            <th class="tb-nowrap">Created Date</th>
            <th class="tb-nowrap">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if ($Rows): ?>
            <?php $num = 0;  foreach ($Rows as $row): $num++; ?>
              <tr>
                <td class="tb-nowrap"><?=$num ?></td>
                <td class="tb-nowrap"><?=strtoupper($row->testname) ?></td>
                <td class="tb-nowrap"><?=esc($row->labSectionRow->labname ?? "N/A" )?> </td>
                <td class="tb-nowrap"><?=esc($row->sampleRow->samplename ?? "N/A" )?></td>
                <td class="tb-nowrap"><?=esc($row->refRanges ?? "N/A" )?></td>
                <td class="tb-nowrap"><?=esc($row->unitRow->unitname ?? "N/A" )?></td>
                <td class="tb-nowrap">
                  <span class="<?php if ($row->testStatus === 'disabled') { echo "badge bg-danger";}else {echo "badge bg-success";} ?>">
                    <?=ucfirst($row->testStatus) ?>
                  </span>
                </td>
                <td class="tb-nowrap text-end text-center"><?=esc($row->userRow->name ?? "Deleted" )?></td>
                <td class="tb-nowrap text-center" ><?=get_date($row->testDate ) ?></td>
                <td class="tb-nowrap text-end">
                  <a href="<?=ROOT?>/Tests/edit/<?=$row->id?>" class=" text-primary"><i class="fa fa-edit"></i></a>|
                  <a href="<?=ROOT?>/Tests/delete/<?=$row->id?>" class=" text-danger"><i class="fa fa-trash-alt"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <td class="tb-nowrap" colspan="16">
              <h4 class="text-center">No Records Found At This Time</h4>
            </td>
          <?php endif; ?>
        </tbody>
      </table><!-- End Table with hoverable rows -->
    </div><!-- End Card-Body -->
  </div><!-- End Card -->
</div><!-- End col-lg-12 -->

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
