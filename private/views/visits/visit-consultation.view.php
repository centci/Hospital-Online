
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='col-md-10 container-fluids rounded shadow p-4 mx-auto  mt-3 table-responsive'>
  <div class="container border rounded p-2 mb-3">
    <center>
      <h1><i class="fa fa-users text-primary"></i><i class="fa fa-users text-primary"></i></h1>
      <h3>Patients To Consult Doctors Today</h3>
    </center>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="tb-nowarp">ID</th>
        <th class="tb-nowarp">Patient Id</th>
        <th class="tb-nowarp">Full Name</th>
        <th class="tb-nowarp">Catategory</th>
        <th class="tb-nowarp">Bill To</th>
        <th class="tb-nowarp">Doctor</th>
        <th class="tb-nowarp">Priority</th>
        <th class="tb-nowarp">Record Date</th>
        <th class="tb-nowarp">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($rows): ?>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td class="tb-nowarp"><?=esc($row->id) ?></td>
            <td class="tb-nowarp"><?=esc($row->patientId) ?></td>
            <td class="tb-nowrap"><?=esc($row->patientRow->name) ?></td>
            <td class="tb-nowarp"><?=esc($row->visitCat) ?></td>
            <td class="tb-nowrap"><?=esc($row->insuranceRow->insuranceName) ?></td>
            <td class="tb-nowarp"><?=esc($row->drUserId) ?></td>
            <td class="tb-nowarp"><?=esc($row->visitPriority) ?></td>
            <td class="tb-nowarp"><?=get_date(esc($row->date)) ?></td>
            <td class="tb-nowarp">
              <a href="#">Details</a>
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
