
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='col-md-10 container-fluids rounded shadow p-4 mx-auto  mt-3 table-responsive'>
  <div class="card">
    <div class="card-header"><h4>Laboratory Report Detail(s)</h4></div>
    <div class="invoice p-3 mb-3">
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-md-6 invoice-col">
          <table class="table table-borderless no-padding">
            <tr>
              <th>Name:</th>
              <td><?= ucwords($patientInfo->PatientsFullName); ?></td>
            </tr>
            <tr>
              <th>Gender/Age:</th>
              <td><?= $patientInfo->gender .'/'.$patientInfo->Age ?></td>
            </tr>
            <tr>
              <th>Patient No:</th>
              <td><?= $patientInfo->patientId ?></td>
            </tr>
            <tr>
              <th>Visit Category:</th>
              <td><?= ucwords($patientInfo->visitCat) ?></td>
            </tr>
            <tr>
              <th>Primary Doctor:</th>
              <td><?= $patientInfo->DrName ?? "N/A" ?></td>
            </tr>
          </table>
          <!-- End Tables without borders -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 invoice-col">
          <table class="table table-borderless no-padding">
            <tr>
              <th>Specimen No:</th>
              <td><?= $patientInfo->SpecimenNo ?></td>
            </tr>
            <tr>
              <th>Drawn By:</th>
              <td><?= ucwords($patientInfo->DrawnBy)?></td>
            </tr>
            <tr>
              <th>Drawn Date/Time:</th>
              <td><?= $patientInfo->DrawnDate ?></td>
            </tr>
            <tr>
              <th>Visit Date/Time:</th>
              <td><?= $patientInfo->VisitDate ?></td>
            </tr>
            <tr>
              <th>Bill Customer:</th>
              <td><?= $patientInfo->billMode ?></td>
            </tr>
          </table>
          <!-- End Tables without borders -->
        </div>
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Test Name</th>
              <th>Test Result</th>
              <th>Ref Ranges</th>
              <th>Units</th>
            </tr>
            </thead>
            <tbody>
              <?php if ($labReportRows): ?>
                <?php foreach ($ReportRow as $Rows): ?>
                  <tr>
                    <td><?= $Rows->testname  ?? null ?></td>
                    <td><?= $Rows->testResult ?? null ?></td>
                    <td><?= $Rows->refRanges ?? null ?></td>
                    <td><?= $Rows->unitRow->unitname ?? null ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <div class="card-footer">
      Footer
    </div>
  </div>
</div>
<?php require $this->viewsPath('head_foot/footer'); ?>
