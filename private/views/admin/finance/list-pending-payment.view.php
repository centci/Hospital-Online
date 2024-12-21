
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='col-md-10 container-fluids rounded shadow p-4 mx-auto  mt-3 table-responsive'>
  <div class="container border rounded p-2 mb-3">
    <center>
      <h1><i class="fa fa-users text-primary"></i><i class="fa fa-users text-primary"></i></h1>
      <h3>List of Clints Pending Payments</h3>
    </center>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="tb-nowrap">#</th>
        <th class="tb-nowrap">patientNo</th>
        <th class="tb-nowrap">Patient Name</th>
        <th class="tb-nowrap">To</th>
        <th class="tb-nowrap">sentBy</th>
        <th class="tb-nowrap">Paid Status</th>
        <th class="tb-nowrap">Record Date</th>
        <th class="tb-nowrap">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($pendingpayment): $num = 0;?>
      <?php foreach ($pendingpayment as $row): $num++;?>
        <tr>
          <td class="tb-nowrap"><?= $num ?></td>
          <td class="tb-nowrap"><?=esc($row->patientNo) ?></td>
          <td class="tb-nowrap"><?=esc($row->ptnInfoRow->fullName) ?></td>
          <td class="tb-nowrap"><?=esc($row->department) ?></td>
           <td class="tb-nowrap"><?=esc($row->userRow->fullName) ?></td>
          <td class="tb-nowrap"><?=esc($row->pymt_status) ?></td>
          <td class="tb-nowrap"><?=get_date(esc($row->pendingPayDate)) ?></td>
          <td class="tb-nowrap">
            <a href="<?=ROOT?>/pendingPayments/pendingPaymentDetails/<?= $row->patientNo.'/'.$row->pendingPayId ?>">Details</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <td colspan="100" class="tb-nowrap"><?=NO_RECORD ?></td>
    <?php endif; ?>
    </tbody>
  </table>

</div>
<?php require $this->viewsPath('head_foot/footer'); ?>
