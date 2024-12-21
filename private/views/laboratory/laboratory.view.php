
<?php require $this->viewsPath('head_foot/header'); ?>
<div class="container-fluids shadow p-4 mt-2 mx-auto">

<!-- ================================================================ -->
<div class="row">
  <div class="col-lg-12">
    <div class="card" style="min-height:490px;">

      <div class="card-body" style="min-height:118px;">
        <div class="row">
          <nav class="navbar navbar-light bg-light mt-2">
            <!-- button for new request  -->
            <form >
              <input type="hidden" name="Request_New" value="New">
              <button  class="btn btn-sm btn-outline-primary ms-2">New<i class="fa fa-chevron-right"></i></button>
            </form>

            <h2>Laboratory Requests </h2>

            <!-- button for old request  -->
            <form >
              <input type="hidden" name="Request_Old" value="Old">
              <button class="btn btn-sm btn-outline-danger me-2"><i class="fa fa-chevron-left"></i>Past</button>
            </form>
          </nav>
        </div>
        <!-- Select item Table -->
        <div class="tableFixHead bg-white" style="min-height: 320px;">
          <table class="tablefix">
          <thead class="thead-fix">
            <tr>
              <th class="th-fix tb-nowrap" style="width: 6%;">Code</th>
              <th class="th-fix tb-nowrap">Item Name</th>
              <th class="th-fix tb-nowrap">Full Name</th>
              <th class="th-fix tb-nowrap">Department</th>
              <th class="th-fix tb-nowrap">Fee</th>
              <th class="th-fix tb-nowrap">Status</th>
              <th class="th-fix tb-nowrap text-end">Record Date</th>
              <th class="th-fix tb-nowrap text-end">Action</th>
            </tr>
          </thead>
          <tbody class="js-lab-items">
            <!-- item-details -->
            <?php if (!empty($rows)): ?>
              <?php foreach ($rows as $row): ?>
                <tr class="tr-fix">
                  <td class="td-fix tb-nowrap"><?=esc($row->testCode)?></td>
                  <td class="td-fix tb-nowrap"><?=esc(strtoupper($row->testname))?></td>
                  <td class="td-fix tb-nowrap"><?=esc($row->firstname.' '.$row->lastname) ?></td>
                  <td class="td-fix tb-nowrap"><?=esc($row->department) ?></td>
                  <td class="td-fix tb-nowrap"><?=esc($row->cost) ?></td>
                  <td class="td-fix tb-nowrap"><?=esc($row->pymt_status) ?></td>
                  <td class="td-fix tb-nowrap text-end"><?=esc($row->cashierSavedDate) ?></td>
                  <td class="td-fix tb-nowrap text-end">
                    <a href="<?=ROOT?>/Laboratorys/displayItemDetails/<?= $row->cashierSavedReceiptNo ?>" class="btn btn-sm btn-primary">
                      <i class="fa fa-add text-danger"></i>Details
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <td colspan="10" class="td-fix tb-nowrap text-center"><span class="text-secondary">No Records Found!,</span> Please click <span class="text-primary fw-bold">New</span> Or <span class="text-danger fw-bold">Past</span> Button Above</td>
            <?php endif; ?>
            <!--end table row-->
          </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end Select Tests Table -->
  </div>
</div>

</div>
<!-- <script type="text/javascript">
// Variables

function send_data(data)
{
  let ajax = new XMLHttpRequest();
  ajax.addEventListener('readystatechange', function(){

    if (ajax.readyState == 4)
    {
      if (ajax.status == 200)
      {
        handle_result(ajax.responseText);
        // console.log(ajax.responseText);
      }else
      {
        // errors
        console.log("An Error Occured, Error Code: "+ajax.status+". Error Massage: "+ajax.statusText);
        console.log(ajax);
      }
    }
  });
  ajax.open('post','',true);
  ajax.send(JSON.stringify(data));
}
// handle results coming from controller
function handle_result(result)
{
  // console.log(result);
  let obj = JSON.parse(result);
}

send_data({
  data_type: "NewRequest",
  olddata_type: "OldRequest",
});
</script> -->
<?php require $this->viewsPath('head_foot/footer'); ?>
