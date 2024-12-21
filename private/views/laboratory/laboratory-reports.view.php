
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='col-md-10 container-fluids rounded shadow p-4 mx-auto  mt-3 table-responsive'>
  <div class="card">
    <div class="card-header">List Of Completed Laboratory Reports</div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="tb-nowrap">ID</th>
            <th class="tb-nowrap">First Name</th>
            <th class="tb-nowrap">Middle Name</th>
            <th class="tb-nowrap">Last Name</th>
            <th class="tb-nowrap">Gender</th>
            <th class="tb-nowrap">Phone</th>
            <th class="tb-nowrap">Country</th>
            <th class="tb-nowrap">Done By</th>
            <th class="tb-nowrap">Join Date</th>
            <th class="tb-nowrap">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($labReportRows): ?>
            <?php foreach ($labReportRows as $row): ?>
              <tr>
                <td class="tb-nowrap"><?=esc($row->patientId) ?></td>
                <td class="tb-nowrap"><?=esc($row->firstname) ?></td>
                <td class="tb-nowrap"><?=esc($row->middlename) ?></td>
                <td class="tb-nowrap"><?=esc($row->lastname) ?></td>
                <td class="tb-nowrap"><?=esc($row->gender) ?></td>
                <td class="tb-nowrap"><?=esc($row->phone) ?></td>
                <td class="tb-nowrap"><?=esc($row->country) ?></td>
                <td class="tb-nowrap"><?=esc($row->userFirst.' '.$row->userLast) ?></td>
                <td class="tb-nowrap"><?=get_date(esc($row->reportDate)) ?></td>
                <td class="tb-nowrap">
                  <a href="<?=ROOT?>/patients/edit/<?=$row->id?>"><i class="fa fa-edit"></i></a>
                  <a href="<?=ROOT?>/Laboratorys/laboratoryreportsdetails/<?=$row->patientId?>/<?=$row->labReqSampleId?>"><i class="fa fa-eye text-success"></i></a>
                  <a href="<?=ROOT?>/patients/details/<?=$row->id?>"><i class="fa fa-trash-alt text-danger"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <td colspan="10" class="tb-nowrap"><?=NO_RECORD ?></td>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      Footer
    </div>
  </div>
</div>
<?php require $this->viewsPath('head_foot/footer'); ?>
