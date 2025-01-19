<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <!-- ====================== -->
            <li class="nav-item">
              <a href="<?=ROOT?>/Tests/add">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-test">New Test</button>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?=ROOT?>/Tests/addExtraTests">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#add-extra-tests">Extra</button>
              </a>
            </li>

            </ul>
          <div class="tab-content pt-2">
            <!-- =============================ADD NEW TESTS=========================== -->
            <div class="tab-pane fade show active add-test" id="add-test">
              <div class="col-lg-8 my-3">

                <small class='bg-secondary text-white form-control' style="font-size: 30px;">
                  <i class="fa fa-flask" style="font-size: 45px;"></i>
                  <b class="text-center">Add New Test</b>
                </small>

                <!--Form for Adding New Test-->
                <form method="POST">
                  <div class="form-check form-switch float-end">
                    <label class="form-check-label" for="toggleswitch">Extra</label>
                    <input id="toggleswitch" type="checkbox" class="form-check-input check-box save-togglesWitch-state" name="toggleswitch" value="checked">
                  </div>
                  <div class='form-group mt-2'>
                    <label>Test Name</label>
                    <input class='form-control <?= isset($errors['testname']) ? 'border-danger' : 'border-primary';?>' type='text' name='testname' value="<?=esc(set_value('testname'))?>" placeholder='Test Name'>
                    <div class="text-danger">
                      <?php if (isset($errors['testname'])): ?> <?= $errors['testname']?> <?php endif; ?>
                    </div>
                  </div>
                  <!-- laboratory section -->
                  <div class='form-group mt-2'>
                    <label>Lab Section</label>
                    <select class='form-control <?= isset($errors['testsLabSectionId']) ? 'border-danger' : 'border-primary';?>' name='testsLabSectionId'>
                      <option selected value="">Select...</option>
                      <?php if ($lab): ?>
                        <?php foreach ($lab as $row): ?>
                          <option <?= get_select('testsLabSectionId', $row->labSectionId) ?>  value="<?= $row->labSectionId ?>"><?= $row->labname ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <div class="text-danger">
                      <?php if (isset($errors['testsLabSectionId'])): ?> <?= $errors['testsLabSectionId']?> <?php endif; ?>
                    </div>
                  </div>
                  <!-- laboratory section end -->

                  <div class="row">
                    <!-- laboratory Sample type -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Sample type</label>
                      <select name="testsSampleId" class="form-control <?= isset($errors['testsSampleId']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="">Select...</option>
                        <?php if ($sample): ?>
                          <?php foreach ($sample as $row): ?>
                            <option <?= get_select('testsSampleId', $row->sampleId) ?> value="<?= $row->sampleId ?>"><?= $row->samplename ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['testsSampleId'])): ?> <?= $errors['testsSampleId']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Sample type end-->

                    <!-- laboratory Sample Container -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Sample Container</label>
                      <select name="testsContainerId" class="form-control <?= isset($errors['testsContainerId']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="">Select...</option>
                        <?php if ($container): ?>
                          <?php foreach ($container as $row): ?>
                            <option <?= get_select('testsContainerId', $row->containerId) ?> value="<?= $row->containerId ?>"><?= $row->containername ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['testsContainerId'])): ?> <?= $errors['testsContainerId']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Sample Container end-->

                  </div>

                  <div class="row row-ref-unit">
                    <!-- laboratory Referance Ranges -->
                    <div class="form-group mt-2 col-md-8">
                      <input class='form-control <?= isset($errors['refRanges']) ? 'border-danger' : 'border-primary';?>' type='text' value="<?=esc(set_value('refRanges'))?>" name='refRanges' placeholder='Refrance Range'>
                      <div class="text-danger">
                        <?php if (isset($errors['refRanges'])): ?> <?= $errors['refRanges']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Referance Ranges end-->

                    <!-- laboratory Tests Units-->
                    <div class="form-group mt-2 col-md-4">
                      <select name="testsUnitId" class="form-control <?= isset($errors['testsUnitId']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="">Select Test Unit..</option>
                        <?php if ($unit): ?>
                          <?php foreach ($unit as $row): ?>
                            <option <?= get_select('testsUnitId', $row->unitId) ?> value="<?= $row->unitId ?>"><?= $row->unitname ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['testsUnitId'])): ?> <?= $errors['testsUnitId']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Tests Units end-->
                  </div>

                   <div class="row">
                    <!-- laboratory Normal test cost -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Normal Cost</label>
                      <input class='form-control <?= isset($errors['cost']) ? 'border-danger' : 'border-primary';?>' type='text' name='cost' value="<?=esc(set_value('cost'))?>" placeholder='Test Cost'>

                      <div class="text-danger">
                        <?php if (isset($errors['cost'])): ?> <?= $errors['cost']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Normal test cost end-->

                    <!-- laboratory insurance test cost -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Insurance Cost</label>
                      <input class='form-control <?= isset($errors['insurance_cost']) ? 'border-danger' : 'border-primary';?>' type='text' name='insurance_cost' value="<?=esc(set_value('insurance_cost'))?>" placeholder='Insurance Test Cost'>
                      <div class="text-danger">
                        <?php if (isset($errors['insurance_cost'])): ?> <?= $errors['insurance_cost']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory insurance test cost end-->
                  </div>

                  <!-- laboratory Test Status-->
                  <div class='form-group mt-2'>
                    <!-- <label>Test Status</label> -->
                    <select class="form-control <?= isset($errors['testStatus']) ? 'border-danger' : 'border-primary';?>" name="testStatus" placeholder="Test Status">
                      <option selected value="">Select Test Status..</option>
                      <option <?= get_select('testStatus', 'disabled') ?> value="disabled">Disabled</option>
                      <option <?= get_select('testStatus', 'enabled') ?> value="enabled">Enabled</option>
                    </select>
                  </div>
                  <!-- laboratory Test Status end-->
                  <div class='form-group mt-2 my-2'>
                    <a href="<?=ROOT?>/Tests">
                      <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
                    </a>
                    <button class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
                  </div>
                  </form>
              </div>
            </div>
            <!-- ====================ADD TESTS ENDZ======================= -->

          </div><!--tab-content & Bordered Tabs -->
        </div><!-- card-body End -->
      </div><!--End card -->
    </div><!--End col-lg-12 -->
  </div><!--End row -->
</div><!--End container fluides -->
<script>

function send_data(data)
{
  var ajax = new XMLHttpRequest();
  ajax.addEventListener('readystatechange',function(e)
  {
    if (ajax.readyState == 4)
    {

      if (ajax.status == 200)
      {
        handle_results(ajax.responseText);
      }
      else
      {
        console.log("An Error Occured, Error Code: "+ajax.status+". Error Massage: "+ajax.statusText);
        console.log(ajax);
      }
    }
  });
  ajax.open('post',' ',true);
  ajax.send(JSON.stringify(data));
}
function handle_results(result)
{
  // debagging with.
  // console.log(result);
  // var obj = JSON.parse(result);
}

// =================== HANDLING TOGGALE SWITCH FOR EXTRAT TESTS ======================
// === Existing Script for Saving ToggleSwitch State ===
var TogglesWitch = document.querySelector('.save-togglesWitch-state');
var ToggaleState = JSON.parse(localStorage['TOGState'] || '{}');

// On page load: Apply saved toggle state and handle input disabling
window.addEventListener('load', function () {
  for (var i in ToggaleState) {
    var checkboxInput = document.querySelector('input[name="' + i + '"]');
    if (checkboxInput) {
      checkboxInput.checked = true; // Restore the state of the toggle
    }
  }
  // Check if the toggle is enabled and apply the disabling logic
  handleRowRefUnitDisabling();

  // Bind the toggle's click event for state updates
  TogglesWitch.addEventListener('click', function (evt) {
    if (this.checked) {
      ToggaleState[this.name] = true; // Save the toggle as "on"
    } else if (ToggaleState[this.name]) {
      delete ToggaleState[this.name]; // Remove toggle state as "off"
    }
    // Persist the state
    localStorage.TOGState = JSON.stringify(ToggaleState);

    // Handle the disabling logic immediately after click
    handleRowRefUnitDisabling();
  });
});

// === New Functionality for Disabling Inputs in `.row-ref-unit` ===
function handleRowRefUnitDisabling() {
  var toggleSwitch = document.querySelector('#toggleswitch'); // Target the toggle switch
  var rowRefUnit = document.querySelector('.row-ref-unit'); // Target the parent div
  var inputs = rowRefUnit.querySelectorAll('input, select, textarea'); // Get all inputs

  // Check the toggle switch state from localStorage or DOM and disable/enable inputs
  if (toggleSwitch && toggleSwitch.checked) {
    inputs.forEach(function (input) {
      input.disabled = true; // Disable the input
      input.classList.add('bg-secondary'); // Optional: Add Bootstrap-styled class
    });
  } else {
    inputs.forEach(function (input) {
      input.disabled = false; // Enable the input
      input.classList.remove('bg-secondary'); // Optional: Remove the Bootstrap class
    });
  }
}

// =================== HANDLING TOGGALE SWITCH FOR EXTRAT TESTS ENDZ ======================

send_data({
  data_type: 'savingTest',
  text: '',
});
</script>
<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
