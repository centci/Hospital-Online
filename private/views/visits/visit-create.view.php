
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='container-fluids rounded shadow p-4 mx-auto col-10 mt-3'>
  <!-- Visit head client persional information -->
  <div class="row">
    <div class="col-md-12 table-responsive px-0">
      <table class="table bg-white">
      <tr>
        <th class="tb-nowrap x12-font">Full Name:</th>
        <td class="tb-nowrap"><?=esc(ucfirst($row->firstname ." ".$row->middlename ." ". $row->lastname))?></td>
        <!-- ================= -->
        <th class="tb-nowrap x12-font">Mobile:</th>
        <td class="text-end"><?=esc(ucfirst($row->phone))?></td>
      </tr>
      <!-- second table row -->
      <tr>
        <th class="x12-font">Gender:</th>
        <td class=""><?=esc(ucfirst($row->gender))?></td>
        <!-- ================= -->
        <th class="tb-nowrap x12-font">Patient No:</th>
        <td class="text-end"><?=esc(ucfirst($row->patientId))?></td>
      </tr>
      <tr>
        <th class="x12-font">Age:</th>
        <td class="tb-nowrap"><?=esc(ucfirst($row->Age))?></td>
        <!-- =============== -->
        <th class="tb-nowrap x12-font">Joined Date:</th>
        <td class="text-end"><?=num_date($row->date)?></td>
      </tr>
      </table>
    </div>
  </div>
  <!-- visit body gather information about client -->
  <form method="POST">
    <!-- hidden fields -->
  <input type="hidden" name="patientId" value="<?= $row->patientId ?>">

  <div class="row table-responsive">
    <table class="table table-bordered border-pdrimary bg-white">
      <!-- first row -->
      <tr class="">
        <th class="tb-nowrap p-1 x10-font"><small>Visit Category</small></th>
        <td class="text-start p-1">
          <select name="visitCat" class="js-visitCat form-select p-0 input-size" >
            <option class="x10-font" value="">Select..</option>
            <option class="x10-font" value="self request">Self Request</option>
            <option class="x10-font" value="consultation">Consultation</option>
          </select>
          <small class="js-error-visitCat text-danger">
          <?php if (isset($errors['visitCat'])): ?> <?= $errors['visitCat']?> <?php endif; ?>
          </small>
        </td>
        <!-- ===================== -->
        <th class="tb-nowrap p-1 x10-font">Bill To</th>
        <td class="text-start p-1">
          <select name="billTo" class="form-select p-0 input-size" >
            <option class="x10-font" value="">Select..</option>
            <?php foreach ($insuranceRow as $row): ?>
              <option class="x10-font" value="<?= $row->insur_id ?>"><?= strtoupper($row->insuranceName) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="js-error-billTo text-danger">
          <?php if (isset($errors['billTo'])): ?> <?= $errors['billTo']?> <?php endif; ?>
          </small>
        </td>
        <!-- ======================  -->
        <th class="tb-nowrap p-1 x10-font">See Specialist</th>
        <td class="text-start p-1">
          <select name="dr_Specliz_id" class="js-specialist form-select p-0 input-size">
            <option class="x10-font" value="">Select..</option>
            <?php foreach ($specialistRow as $row): ?>
              <option class="x10-font" value="<?= $row->id ?>"><?= ucfirst($row->specialized) ?></option>
            <?php endforeach; ?>
          <small class="js-error-dr_Specliz_id text-danger">
          <?php if (isset($errors['dr_Specliz_id'])): ?> <?= $errors['dr_Specliz_id']?> <?php endif; ?>
          </small>
        </td>
        <!-- ======================  -->
        <th class="tb-nowrap p-1 x10-font">Department</th>
        <td class="text-start p-1">
          <select name="departmentId" class="js-department form-select p-0 input-size">
            <option class="x10-font" value="">Select..</option>
            <?php foreach ($departmentRow as $row): ?>
              <option class="x10-font" value="<?= $row->dept_id ?>"><?= ucfirst($row->department) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="js-error-departmentId text-danger">
          <?php if (isset($errors['departmentId'])): ?> <?= $errors['departmentId']?> <?php endif; ?>
          </small>
        </td>
      </tr> <!-- first row end -->
      <!-- second row -->
      <tr class="">
        <th class="tb-nowrap p-1 x10-font">Bill Mode</th>
        <td class="text-start p-1">
          <select name="billMode" class="form-select p-0 input-size" >
            <option class="x10-font" value="">Select..</option>
            <option class="x10-font" value="Cash">Cash</option>
            <option class="x10-font" value="2">Insurance</option>
          </select>
          <small class="js-error-billMode text-danger">
          <?php if (isset($errors['billMode'])): ?> <?= $errors['billMode']?> <?php endif; ?>
          </small>
        </td>
        <!-- ================= -->
        <th class="tb-nowrap p-1 x10-font">Insurance No.</th>
        <td class="text-start p-1">
          <input class="js-insuranceNo form-control input-size x10-font" type="text" name="insuranceNo" value="" placeholder="Insurance No.">
          <small class="js-error-insuranceNo text-danger">
          <?php if (isset($errors['insuranceNo'])): ?> <?= $errors['insuranceNo']?> <?php endif; ?>
          </small>
        </td>
        <!-- ======================  -->
        <th class="tb-nowrap p-1 x10-font">Doctor</th>
        <td class="text-start p-1">
          <select name="drUserId" class="js-doctor form-select p-0 input-size">
            <option class="x10-font" value="">Select..</option>
            <?php foreach ($doctRow as $row): ?>
              <option class="x10-font" value="<?= $row->id ?>"><?= "Dr. ".ucfirst($row->firstname) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="js-error-drUserId text-danger">
          <?php if (isset($errors['drUserId'])): ?> <?= $errors['drUserId']?> <?php endif; ?>
          </small>
        </td>
        <!-- ======================  -->
        <th class="tb-nowrap p-1 x10-font">Visit Priority</th>
        <td class="text-start p-1">
          <select name="visitPriority" class="form-select p-0 input-size" >
            <option class="x10-font" value="">Select..</option>
            <option class="x10-font" value="normal">Normal</option>
            <option class="x10-font" value="emergency">Emergency</option>
          </select>
          <small class="js-error-visitPriority text-danger">
          <?php if (isset($errors['visitPriority'])): ?> <?= $errors['visitPriority']?> <?php endif; ?>
          </small>
        </td>
      </tr>
    </table>
  </div>
   <div>
      <button oncklick="save_visit(event)" typke="button" class="btn btn-sm btn-primary float-end">save</button>
      <a href="<?=ROOT?>/visits/search">
        <button class="btn btn-sm btn-warning" type="button">Cancel</button>
      </a>
    </div>
  </form>
</div>
<script>
  var visitCategory = document.querySelector('.js-visitCat');
  var insuranceNo = document.querySelector('.js-insuranceNo');
  var doctor = document.querySelector('.js-doctor');
  var specialist = document.querySelector('.js-specialist');
  var department = document.querySelector('.js-department');

  visitCategory.addEventListener('change',function(e){

    var text = e.target.value;

    if(visitCategory.value == "self request"){
      insuranceNo.setAttribute('disabled','');
      doctor.setAttribute('disabled','');
      specialist.setAttribute('disabled','');
    }else {
      insuranceNo.removeAttribute('disabled','');
      doctor.removeAttribute('disabled','');
      specialist.removeAttribute('disabled','');
    }

    if(visitCategory.value == "consultation"){
      department.setAttribute('disabled','');
    }else {
      department.removeAttribute('disabled','');
    }

  });

 </script>
<?php require $this->viewsPath('head_foot/footer'); ?>
