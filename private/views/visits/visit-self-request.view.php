<style media="screen">

</style>
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='col-md-10 container-fluids rounded shadow p-4 mx-auto  mt-3 table-responsive'>
  <div class="container border rounded p-2 mb-3">
    <center>
      <h1><i class="fa fa-users text-primary"></i><i class="fa fa-users text-primary"></i></h1>
      <h3>List Of Patient Self Request Visits Today</h3>
    </center>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="tb-nowrap">ID</th>
        <th class="tb-nowrap">Patient Id</th>
        <th class="tb-nowrap">Full Name</th>
        <th class="tb-nowrap">Catategory</th>
        <th class="tb-nowrap">Bill To</th>
        <th class="tb-nowrap">Department</th>
        <th class="tb-nowrap">Priority</th>
        <th class="tb-nowrap">Visit Date</th>
        <th class="tb-nowrap">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows): ?>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td class="tb-nowrap"><?=esc($row->id) ?></td>
            <td class="tb-nowrap"><?=esc($row->patientId) ?></td>
            <td class="tb-nowrap"><?=esc($row->patientRow->name) ?></td>
            <td class="tb-nowrap"><?=esc($row->visitCat) ?></td>
            <td class="tb-nowrap"><?=esc($row->insuranceRow->insuranceName) ?></td>
            <td class="tb-nowrap"><?=esc($row->departmentRow->department) ?></td>
            <td class="tb-nowrap"><?=esc($row->visitPriority) ?></td>
            <td class="tb-nowrap"><?=get_date(esc($row->VisitDate)) ?></td>
            <td class="tb-nowrap">
              <a href="<?=ROOT?>/visits/addvisitrequest/<?= $row->visit_Id?>">Details</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <td colspan="10" class="tb-nowrap"><?=NO_RECORD ?></td>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php require $this->viewsPath('head_foot/footer'); ?>
