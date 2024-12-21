<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-3 save-test-content">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-test" id="add-test-tab">Edit Test</button>
            </li>

            <li class="nav-item" id="txt" style="<?php if($tests->toggleswitch != 'checked'){echo "display:none;";} ?>">
              <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#add-extra-tests" id="add-extra-tests-tab">Extra</button>
            </li>

          </ul>
          <div class="tab-content pt-2">
            <!-- =============================ADD NEW TESTS=========================== -->
            <div class="tab-pane fade show active add-test" id="add-test">
              <div class="col-lg-8 my-3">

                <small class='text-center;' style="font-size: 30px;">
                  <i class="fa fa-flask" style="font-size: 45px;"></i>
                  <b>Edit Test</b>
                </small>

                <?php
                  if (isset($errors['xtraTestName']) || isset($errors['xtraRefRanges']) || isset($errors['xtraUnitid']))
                  {
                    echo "<p class='text-danger'> Please Check empty Fields From Extra Test Tab</>";
                  }
                ?>

                <!--Form for Adding New Test-->
                <!-- <form method="POST"> -->
                  <div class="form-check form-switch float-end" style="<?php if($tests->toggleswitch != 'checked'){echo "display:none;";} ?>">
                    <label class="form-check-label" for="toggleswitch">Extra</label>
                    <input id="toggleswitch" type="checkbox" class="form-check-input check-box"
                    name="toggleswitch" value="checked" <?php if ($tests->toggleswitch === 'checked'){ echo "checked";}?> >
                  </div>

                  <!-- Lab Test Name -->
                  <div class='form-group mt-2'>
                    <label>Test Name</label>
                    <input class='form-control <?= isset($errors['testname']) ? 'border-danger' : 'border-primary';?>' type='text' name='testname' value="<?=esc(set_value('testname', $tests->testname))?>" placeholder='Test Name'>
                    <div class="text-danger">
                      <?php if (isset($errors['testname'])): ?> <?= $errors['testname']?> <?php endif; ?>
                    </div>
                  </div>

                  <!-- LAB SECTION NAME -->
                  <div class='form-group mt-2'>
                    <label>Lab Section</label>
                    <select class='form-select <?= isset($errors['labSecId']) ? 'border-danger' : 'border-primary';?>' name='labSecId'>
                      <option selected value="<?= $tests->labSecId ?>">
                        <?= $tests->labSectionRow->labname?>
                      </option>
                      <?php if ($lab): ?>
                        <?php foreach ($lab as $row): ?>
                          <option <?= get_select('labname', $row->labname) ?>  value="<?= $row->id ?>"><?= $row->labname ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <div class="text-danger">
                      <?php if (isset($errors['labSecId'])): ?> <?= $errors['labSecId']?> <?php endif; ?>
                    </div>
                  </div>

                  <!-- SAMPLE TYPE And SAMPLE CONTAINER -->
                  <div class="row">
                    <!-- SAMPLE TYPE -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Sample type</label>
                      <select name="sampleid" class="form-select <?= isset($errors['sampleid']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="<?= $tests->sampleid ?>">
                          <?= $tests->sampleRow->samplename ?>
                        </option>

                        <?php if ($sample): ?>
                          <?php foreach ($sample as $row): ?>
                            <option <?= get_select('samplename', $row->samplename) ?> value="<?= $row->id ?>"><?= $row->samplename ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['sampleid'])): ?> <?= $errors['sampleid']?> <?php endif; ?>
                      </div>
                    </div>

                    <!-- SAMPLE CONTAINER -->
                    <div class="form-group mt-2 col-md-6">
                      <label>Sample Container</label>
                      <select name="containerid" class="form-control <?= isset($errors['containerid']) ? 'border-danger' : 'border-primary';?>">
                        <option selected value="<?= $tests->containerid ?>">
                          <?= $tests->containerRow->containername ?>
                        </option>

                        <?php if ($container): ?>
                          <?php foreach ($container as $row): ?>
                            <option <?= get_select('containername', $row->containername) ?> value="<?= $row->id ?>"><?= $row->containername ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['containerid'])): ?> <?= $errors['containerid']?> <?php endif; ?>
                      </div>
                    </div>
                  </div><!--End Sample Type And Sample Container Div-->

                  <!-- REFERANCE RANGES And TEST UNIT -->
                  <div class="row">

                    <!-- REFERANCE RANGES -->
                    <div class="form-group mt-2 col-md-8">
                      <!-- <label for="">Refrance Range</label> -->
                      <input class="form-control <?= isset($errors['refRanges']) ? 'border-danger' : 'border-primary';?>" type="text" value="<?=esc(set_value('refRanges', $tests->refRanges))?>"
                      name="refRanges" placeholder="Refrance Range" style="<?php if($tests->toggleswitch === 'checked'){echo "display:none;";} ?>">

                      <div class="text-danger">
                        <?php if (isset($errors['refRanges'])): ?> <?= $errors['refRanges']?> <?php endif; ?>
                      </div>
                    </div>

                    <!-- TEST UNIT -->
                    <div class="form-group mt-2 col-md-4">
                      <!-- <label>Test Unit</label> -->
                      <select name="unitid" class="form-control <?= isset($errors['unitid']) ? 'border-danger' : 'border-primary';?>" style="<?php if($tests->toggleswitch === 'checked'){echo "display:none;";} ?>">

                        <option selected value="<?= $tests->unitid ?>">
                          <?= $tests->unitRow->unitname ?>
                        </option>

                        <?php if ($unit): ?>
                          <?php foreach ($unit as $row): ?>
                            <option <?= get_select('unitname', $row->unitname) ?> value="<?= $row->id ?>"><?= $row->unitname ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="text-danger">
                        <?php if (isset($errors['unitid'])): ?> <?= $errors['unitid']?> <?php endif; ?>
                      </div>
                    </div>
                  </div><!--End Refrance Range And Test Unit Div-->

                  <!-- Test Status -->
                  <div class='form-group mt-2'>
                    <!-- <label>Test Status</label> -->
                    <select class="form-control <?= isset($errors['testStatus']) ? 'border-danger' : 'border-primary';?>" name="testStatus" placeholder="Test Status">
                      <option <?= get_select('testStatus', $tests->testStatus) ?> value="<?=$tests->testStatus?>"><?= ucfirst($tests->testStatus) ?></option>
                      <option <?= get_select('testStatus', 'disabled') ?> value="disabled">Disabled</option>
                      <option <?= get_select('testStatus', 'enabled') ?> value="enabled">Enabled</option>
                    </select>
                  </div>
                  <!-- =============BACK AND SAVE BUTTON=========== -->
                  <div class='form-group mt-2 my-2' style="<?php if($tests->toggleswitch === 'checked'){echo "display:none;";} ?>">
                    <a href="<?=ROOT?>/Tests">
                      <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
                    </a>
                    <button class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
                  </div>
                  <!-- ===========BACK AND SAVE BUTTON ENDZ========== -->
              </div>
            </div>
            <!-- ====================ADD EXTRA TESTS======================= -->
            <div class="tab-pane fade" id="add-extra-tests">
              <div class="card-body table-responsive">
                <table style="<?php if($tests->toggleswitch != 'checked'){echo "display: none; width: 100%;";} ?>"><!-- start Table -->
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
                    <?php if ($testxtra): $num = 1; $input_Num = 0;?>
                      <?php foreach ($testxtra as $row): ?>
                        <tr>
                          <td><?= $num++; ?></td>
                          <td>
                            <input type="text" class=" form-control" name="xtraTestName_<?=$input_Num?>" value="<?= isset($row->xtraTestName) ? esc(set_value('xtraTestName', $row->xtraTestName)) : "";?>" placeholder="Enter ">
                            <div class="text-danger">
                              <?php if (isset($errors['xtraTestName'])): ?> <?= $errors['xtraTestName']?> <?php endif; ?>
                            </div>
                          </td>
                          <td>
                            <input type="text" class=" form-control" name="xtraRefRanges_<?=$input_Num?>" value="<?= isset($row->xtraRefRanges) ? esc(set_value('xtraRefRanges', $row->xtraRefRanges)) : "";?>" placeholder="Enter ">
                            <div class="text-danger">
                              <?php if (isset($errors['xtraRefRanges'])): ?> <?= $errors['xtraRefRanges']?> <?php endif; ?>
                            </div>
                          </td>
                          <td>
                            <select name="xtraUnitid_<?=$input_Num?>" class=" form-control">
                              <option selected value="<?= isset($row->xtraUnitid) ? $row->xtraUnitid : ""; ?>">
                                <?= $row->unitRow->unitname ?>
                              </option>

                              <?php if ($unit): ?>
                                <?php foreach ($unit as $row): ?>
                                  <option value="<?= $row->id ?>"><?= $row->unitname ?></option>
                                <?php endforeach; ?>
                              <?php endif; ?>
                            </select>
                            <div class="text-danger">
                              <?php if (isset($errors['xtraUnitid'])): ?> <?= $errors['xtraUnitid']?> <?php endif; ?>
                            </div>
                          </td>
                          <td class="text-end ">

                          </td>
                        </tr>
                        <!-- input numbering for saving -->
                            <?php $input_Num++; ?>
                        <!-- input numbering for saving -->

                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table><!-- End Table -->
              </div><!-- End Card-Body -->
            </div><!-- Add Extra End -->
    <!-- =============SECOND BACK AND SAVE BUTTON=========== -->
            <div class='form-group mt-2 my-2' style="<?php if($tests->toggleswitch != 'checked'){echo "display:none;";} ?>">
              <a href="<?=ROOT?>/Tests">
                <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
              </a>
              <button onclick="save_content()" class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
            </div>
    <!-- =============SECOND BACK AND SAVE BUTTON ENDZ=========== -->
          <!-- </form> -->
          <!--Form end-->

          </div><!--tab-content & Bordered Tabs -->
        </div><!-- card-body End -->
      </div><!--End card -->
    </div><!--End col-lg-12 -->
  </div><!--End row -->
</div><!--End container fluides -->

<script>
var tab = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab") : "#profile-overview-tab";

function show_tab(tab_name)
{
  const someTabTriggerEl = document.querySelector(tab_name + "-tab");
  const tab = new bootstrap.Tab(someTabTriggerEl);
  tab.show();
}

function set_tab(tab_name)
{
  tab = tab_name;
  sessionStorage.setItem("tab", tab_name);
}
function load_image(file)
{
  document.querySelector(".js-filename").innerHTML = "Selected File: " + file.name;
  var imglink = window.URL.createObjectURL(file);
  document.querySelector(".js-image-preview").src = imglink;
}

window.onload = function ()
{
  show_tab(tab);
}
// send and receive data function
function send_data(obj)
{
  var myform = new FormData();
  for(key in obj){
    myform.append(key,obj[key]);
  }

  var ajax = new XMLHttpRequest();

  ajax.addEventListener('readystatechange',function(){

    if(ajax.readyState == 4){

      if(ajax.status == 200){
        //everything went well
        //alert("upload complete");
        handle_results(ajax.responseText);
      }else{
        //error
        console.log("An Error Occured, Error Code: "+ajax.status+". Error Massage: "+ajax.statusText);
        console.log(ajax);
      }
    }
  });

  ajax.open('post','',true);
  ajax.send(myform);

}
function handle_results(result)
{
  // debagging with.
  console.log(result);

  var obj = JSON.parse(result);
  if(typeof obj == 'object')
  {

    if(obj.data_type == save)
    {
      alert(obj.data);
      // alert('data saved');

      //clear all errors
      var error_containers = document.querySelectorAll(".error");
      for (var i = 0; i < error_containers.length; i++) {
        error_containers[i].innerHTML = "";
      }

      //show any errors
      if(typeof obj.errors == 'object')
      {
        for(key in obj.errors)
        {
          document.querySelector(".errors-"+key).innerHTML = obj.errors[key];
        }

      }else{
        disable_save_button(false);
        dirty = false;
        alert(obj.data);
        window.location.reload();
      }
    }
    // else
    // if(obj.data_type == "get-meta")
    // {
    //
    //   var obj_name = tab.replaceAll("-","_");
    //   window[obj_name].handle_result(obj.data);
    // }

  }
}

// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS=========================
// add tabale rows
var num = 0;

function add_extra(e)
{
  var extraTest = document.querySelector(".extra-tests");
  var input_count = extraTest.children.length;
  var mydiv = document.createElement("tr");
  mydiv.setAttribute('onclick','remove_test_row(event)');
  // console.log(mydiv);
  num ++;
  mydiv.innerHTML =`
    <td class="tb-nowrap">${num}</td>
    <td class="tb-nowrap"><!-- laboratory extra Test Name-->
      <input type="text" class=" form-control" name="xtraTestName_${input_count}" value="<?=esc(set_value('xtraTestName'))?>" placeholder="Please Enter Test Name">
      <!--error handling-->
      <small class="error errors-xtraTestName_${input_count} text-danger"> </small>
    </td><!-- laboratory extra Test Name end -->

    <td class="tb-nowrap"><!-- laboratory extra Ref Ranges -->
      <input type="text" class=" form-control" name="xtraRefRanges_${input_count}" value="<?=esc(set_value('xtraRefRanges'))?>" placeholder="Please Enter Ref Range">
      <!--error handling-->
      <small class="error errors-xtraRefRanges_${input_count} text-danger"> </small>
    </td><!-- laboratory extra Ref Ranges end -->

    <td class="tb-nowrap"><!-- laboratory extra Test Unit Name -->
      <select name="xtraUnitid_${input_count}" class="form-control">
        <option selected value="">Select Unit..</option>
        <?php if ($unit): ?>
          <?php foreach ($unit as $row): ?>
            <option <?= get_select('xtraUnitid', $row->id) ?> value="<?= $row->id ?>"><?= $row->unitname ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
      <!--error handling-->
      <small class="error errors-xtraUnitid_${input_count} text-danger"> </small>
    </td><!-- laboratory extra Test Unit Name end -->

    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->
    <!--<input type="hidden"  name="xtraTestCode_${input_count}" value="<?=esc($id)?>">
    <input type="hidden"  name="xtraUserId_${input_count}" value="<?=esc(Auth::getId())?>">
    <input type="hidden"  name="xtraTestDate_${input_count}" value="<?=esc(date('Y-m-d H:i:s'))?>">-->
    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->

    <td class="text-end" id="delete-test-row" ><!-- Delete extra Test Row Button -->
    <span class="text-danger" id="delete-test-row"><i id="delete-test-row" class="fa fa-trash-alt fs-2"></i></span>
    </td>`; //<!-- Delete extra Test Row Button End -->

  // appending rows of table
  extraTest.appendChild(mydiv);
  // end row appending
}
// Remove table rows
function remove_test_row(e)
{
  var action = e.target.id;
  if (action == 'delete-test-row')
  {
    if (!confirm('Are You Sure You Want To Delete This Row?!'))
    {
      return;
    }
    e.currentTarget.remove();
  }
}
// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS ENDZ ========================

function save_content()
{
  var content = document.querySelector(".save-test-content");
  var inputs = content.querySelectorAll("input,select, checkbox");

  var obj = {};
  obj.data_type = "save";

  for (var i = 0; i < inputs.length; i++) {
    var key = inputs[i].name;
    obj[key] = inputs[i].value;
  }

  send_data(obj);
}
</script>

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
