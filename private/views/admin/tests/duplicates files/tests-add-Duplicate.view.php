<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-test" id="add-test-tab">New Test</button>
            </li>

            <li class="nav-item" id="">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#add-extra-tests" id="add-extra-tests-tab">Extra</button>
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

                <?php
                  if (isset($errors['xtraTestName']) || isset($errors['xtraRefRanges']) || isset($errors['xtraUnitid']))
                  {
                    echo "<p class='text-danger'> Please Check empty Fields From Extra Test Tab</>";
                  }
                ?>

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
                    <select class='form-control <?= isset($errors['labSecId']) ? 'border-danger' : 'border-primary';?>' name='labSecId'>
                      <option selected value="">Select...</option>
                      <?php if ($lab): ?>
                        <?php foreach ($lab as $row): ?>
                          <option <?= get_select('labSecId', $row->id) ?>  value="<?= $row->id ?>"><?= $row->labname ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <div class="text-danger">
                      <?php if (isset($errors['labSecId'])): ?> <?= $errors['labSecId']?> <?php endif; ?>
                    </div>
                  </div>
                  <!-- laboratory section end -->

                  <div class="row">
                    <!-- laboratory Sample type -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Sample type</label>
                      <select name="sampleid" class="form-control <?= isset($errors['sampleid']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="">Select...</option>
                        <?php if ($sample): ?>
                          <?php foreach ($sample as $row): ?>
                            <option <?= get_select('sampleid', $row->id) ?> value="<?= $row->id ?>"><?= $row->samplename ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['sampleid'])): ?> <?= $errors['sampleid']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Sample type end-->

                    <!-- laboratory Sample Container -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Sample Container</label>
                      <select name="containerid" class="form-control <?= isset($errors['containerid']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="">Select...</option>
                        <?php if ($container): ?>
                          <?php foreach ($container as $row): ?>
                            <option <?= get_select('containerid', $row->id) ?> value="<?= $row->id ?>"><?= $row->containername ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['containerid'])): ?> <?= $errors['containerid']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Sample Container end-->

                  </div>

                  <div class="row">
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
                      <select name="unitid" class="form-control <?= isset($errors['unitid']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="">Select Test Unit..</option>
                        <?php if ($unit): ?>
                          <?php foreach ($unit as $row): ?>
                            <option <?= get_select('unitid', $row->id) ?> value="<?= $row->id ?>"><?= $row->unitname ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['unitid'])): ?> <?= $errors['unitid']?> <?php endif; ?>
                      </div>
                    </div>
                    <!-- laboratory Tests Units end-->
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
              </div>
            </div>
            <!-- ====================ADD EXTRA TESTS======================= -->
            <div class="tab-pane fade" id="add-extra-tests">
              <div class="card-body table-responsive">

                <table style="width: 100%;"><!-- End Table -->
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th class="tb-nowrap">Tests</th>
                      <th class="tb-nowrap">Ranges</th>
                      <th class="tb-nowrap">Units</th>
                      <th class="tb-nowrap text-end pe-0" style="width: 7%;">
                        <span type="button" onclick="add_extra(event)" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add</span>
                      </th>
                    </tr>
                  </thead>

                  <tbody class="extra-tests">
                    <tr>
                      <td>1</td>

                      <td><!-- laboratory extra Test Name-->
                        <input type="text" class=" form-control" name="xtraTestName0" value="<?=esc(set_value('xtraTestName'))?>" placeholder="Enter ">
                        <div class="text-danger">
                          <?php if (isset($errors['xtraTestName'])): ?> <?= $errors['xtraTestName']?> <?php endif; ?>
                        </div>
                      </td><!-- laboratory extra Test Name end -->

                      <td><!-- laboratory extra Ref Ranges -->
                        <input type="text" class=" form-control" name="xtraRefRanges0" value="<?=esc(set_value('xtraRefRanges'))?>" placeholder="Enter ">
                        <div class="text-danger">
                          <?php if (isset($errors['xtraRefRanges'])): ?> <?= $errors['xtraRefRanges']?> <?php endif; ?>
                        </div>
                      </td><!-- laboratory extra Ref Ranges end -->

                      <td><!-- laboratory extra Test Unit Name -->
                        <select name="xtraUnitid0" class=" form-control">
                          <option selected value="">Select...</option>
                          <?php if ($unit): ?>
                            <?php foreach ($unit as $row): ?>
                              <option <?= get_select('xtraUnitid', $row->id) ?> value="<?= $row->id ?>"><?= $row->unitname ?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                        <div class="text-danger">
                          <?php if (isset($errors['xtraUnitid'])): ?> <?= $errors['xtraUnitid']?> <?php endif; ?>
                        </div>
                      </td><!-- laboratory extra Test Unit Name end -->
                    </tr>

                  </tbody>
                </table><!-- End Table -->
              </div><!-- End Card-Body -->
            </div><!-- Add Extra End -->
            <div class='form-group mt-2 my-2'>
              <a href="<?=ROOT?>/Tests">
                <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
              </a>
              <button class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
            </div>
          </form><!--Form end-->

          </div><!--tab-content & Bordered Tabs -->
        </div><!-- card-body End -->
      </div><!--End card -->
    </div><!--End col-lg-12 -->
  </div><!--End row -->
</div><!--End container fluides -->
<script>
// GLOBAL VARIABLE

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

// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS=========================
// add tabale rows
var num = 1;

function add_extra(e)
{
  var extraTest = document.querySelector(".extra-tests");
  var mydiv = document.createElement("tr");
  // console.log(mydiv);
  num ++;
  mydiv.innerHTML =`
    <td>${num}</td>
    <td><!-- laboratory extra Test Name-->
      <input type="text" class=" form-control" name="xtraTestName${extraTest.children.length}" value="<?=esc(set_value('xtraTestName'))?>" placeholder="Enter ">
      <div class="text-danger">
        <?php if (isset($errors['xtraTestName'])): ?> <?= $errors['xtraTestName']?> <?php endif; ?>
      </div>
    </td><!-- laboratory extra Test Name end -->

    <td><!-- laboratory extra Ref Ranges -->
      <input type="text" class=" form-control" name="xtraRefRanges${extraTest.children.length}" value="<?=esc(set_value('xtraRefRanges'))?>" placeholder="Enter ">
      <div class="text-danger">
        <?php if (isset($errors['xtraRefRanges'])): ?> <?= $errors['xtraRefRanges']?> <?php endif; ?>
      </div>
    </td><!-- laboratory extra Ref Ranges end -->

    <td><!-- laboratory extra Test Unit Name -->
      <select name="xtraUnitid${extraTest.children.length}" class=" form-control">
        <option selected value="">Select...</option>
        <?php if ($unit): ?>
          <?php foreach ($unit as $row): ?>
            <option <?= get_select('xtraUnitid', $row->id) ?> value="<?= $row->id ?>"><?= $row->unitname ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
      <div class="text-danger">
        <?php if (isset($errors['xtraUnitid'])): ?> <?= $errors['xtraUnitid']?> <?php endif; ?>
      </div>
    </td><!-- laboratory extra Test Unit Name end -->

    <td class="text-end "><!-- Add extra Test Row Button -->
      <span class="text-danger" onclick="remove_row(event)"><i class="fa fa-trash-alt"></i></span>
    </td>`; //<!-- Add extra Test Row Button End -->

  // appending rows of table
  extraTest.appendChild(mydiv);
  // end row appending
}
// Remove table rows
function remove_row()
{
  var extraTest = document.querySelector(".extra-tests");
  extraTest.lastElementChild.remove();
}

// ===================SHIFT BETWEEN TAB AND KEEP ON, AFTER REFRESHING======================
  var tab = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab") : "#add-test-tab";
  function show_tab(tab_name)
  {
    var TabTrigger = document.querySelector(tab_name + "-tab");
    var tab = new bootstrap.Tab(TabTrigger);
    tab.show();
  }
  function set_tab(tab_name)
  {
    tab = tab_name;
    sessionStorage.setItem("tab", tab_name);
  }
  window.onload = function ()
  {
    show_tab(tab);
  }
// ===================SHIFT BETWEEN TAB END ==========================================

// =================== HANDLING TOGGALE SWITCH FOR EXTRAT TESTS ======================
var TogglesWitch = document.querySelector('.save-togglesWitch-state');
var ToggaleState = JSON.parse(localStorage['TOGState'] || '{}');

window.addEventListener('load',function(){
  for(var i in ToggaleState)
  {
    var checkboxinput = document.querySelector('input[name="' + i + '"]');
    if (checkboxinput) checkboxinput.checked = true;
  }
  //bind click event handler
  TogglesWitch.addEventListener('click', function(evt) {
  // If checkboxe is checked then save to state
    if (this.checked) {
      ToggaleState[this.name] = true;
    }
  // Else remove from state
    else if (ToggaleState[this.name])
    {
      delete ToggaleState[this.name];
    }
  // Persist state
    localStorage.TOGState = JSON.stringify(ToggaleState);
  });
});
// =================== HANDLING TOGGALE SWITCH FOR EXTRAT TESTS ENDZ ======================

send_data({
  data_type: 'savingTest',
  text: '',
});
</script>
<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
