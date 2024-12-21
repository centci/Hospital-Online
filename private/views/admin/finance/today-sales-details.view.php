
<?php require $this->viewsPath('head_foot/header'); ?>
<div class="container-fluids shadow p-4 mt-2 mx-auto">

<!-- ================================================================ -->
<div class="row">
  <div class="col-lg-12">
    <div class="card" style="min-height:490px;">

      <div class="card-body" style="min-height:118px;">
        <div class="row">
          <div class="col-lg-4 mt-1">
            <nav class="navbar navbar-light bg-light mt-2">
              <h4>Today's Sales:
                <?php if (!empty($totalSales->TotalSales)): ?>
                  <span  class="ms-2 btn btn-sm bg-secondary text-white "> <?=$totalSales->TotalSales." Ugx"?> </span>
                <?php else: ?>
                  <span  class="ms-2 btn btn-sm bg-danger text-white "> You Have Not sold today! </span>
                <?php endif; ?>
              </h4>
            </nav>
          </div>
          <div class="col-lg-8">
            <form class="row float-end">
              <!-- <input type="hidden" name="pg" value="admin">
              <input type="hidden" name="tab" value="sales"> -->
              <div class="col">
                <label for="start">Start</label>
                <input class="form-control btn-sm" type="date" name="start" value="<?=!empty($_GET['start']) ? $_GET['start'] : '' ?>">
              </div>
              <div class="col">
                <label for="end">End</label>
                <input class="form-control btn-sm" type="date" name="end" value="<?=!empty($_GET['end']) ? $_GET['end'] : '' ?>">
              </div>

              <div class="col">
                <label for="end">Rows</label>
                <input style="max-width: 80px;" class="form-control btn-sm" type="number" min="1" name="limit" value="5">
              </div>
              <div class="col mt-4">
                <button class="btn-sm btn btn-secondary w-10">Go<i class="fa fa-chevron-right"></i></button>
              </div>
            </form>
          </div>
        </div>
        <!-- Select item Table -->
        <div class="tableFixHead bg-white" style="min-height: 320px;">
          <table class="tablefix">
          <thead class="thead-fix">
            <tr>
              <th class="th-fix tb-nowrap" style="width: 6%;"></th>
              <th class="th-fix tb-nowrap" style="width: 6%;">Code</th>
              <th class="th-fix tb-nowrap">Item Name</th>
              <th class="th-fix tb-nowrap">Full Name</th>
              <th class="th-fix tb-nowrap">Department</th>
              <th class="th-fix tb-nowrap">Fee</th>
              <th class="th-fix tb-nowrap text-end">Record Date</th>
            </tr>
          </thead>
          <tbody class="js-item-details">
            <!-- item-details -->
            <!--table row-->
            <?php if ($todaySales): ?>
              <?php foreach ($todaySales as $Tsales): ?>
                <tr class="tr-fix">
                  <td class="td-fix tb-nowrap"></td>
                  <td class="td-fix tb-nowrap"><?=$Tsales->testCode ?></td>
                  <td class="td-fix tb-nowrap"><?= strtoupper($Tsales->testname) ?></td>
                  <td class="td-fix tb-nowrap"><?=$Tsales->firstname." ".$Tsales->lastname ?></td>
                  <td class="td-fix tb-nowrap"><?=$Tsales->department ?></td>
                  <td class="td-fix tb-nowrap"><?=$Tsales->cost ?> </td>
                  <td class="td-fix tb-nowrap text-end"><?=$Tsales->cashierSavedDate ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <td colspan="10"><center>No Record found at this time</center></td>
            <?php endif; ?>
            <!--end table row-->
          </tbody>
          </table>
        </div>
        <nav class="navbar navbar-light bg-light mt-2">
            <!-- button for removeing  -->
          <a href="<?=ROOT?>/PendingPayments">
            <button type="button" class="btn btn-sm btn-outline-danger ms-2"><i class="fa fa-chevron-left"></i>Back</button>
          </a>

          <!-- button for Saving Tests -->
          <button onclick="submit()" type="submit" class="btn btn-sm btn-outline-primary me-2"><i class="fa fa-plus"></i>Save</button>
        </nav>
      </div>
    </div>
    <!-- end Select Tests Table -->
  </div>
</div>

</div>
<?php require $this->viewsPath('head_foot/footer'); ?>
