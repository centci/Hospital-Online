<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>


<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <a href="<?=ROOT?>/Tests/add">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#add-test">New Test</button>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?=ROOT?>/Tests/addExtraTests">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-extra-tests">Extra</button>
              </a>
            </li>

            </ul>
            <!-- Bordered Tabs endz-->

          <div class="tab-content pt-2">
            <!-- ====================ADD EXTRA TESTS======================= -->
            <div class="card">
            <div class="card-body table-responsive save-test-content">
              <!-- <th class="tb-nowrap text-end pe-0" colspan="4"> -->

                <div class='form-group'>
                  <h5 class="card-title text-center py-0">Add Extra Tests</h5>

                  <span type="button" onclick="add_extra(event)" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add Row</span>
                  <span type="button" onclick="if (!confirm('Are You Sure You Want To Save these Rows?!'))return; save_content(event)" class="btn btn-sm btn-warning float-end"><i class="fa fa-plus"></i>Save</span>
                </div>

              <!-- </th> -->
              <!-- <form class="" method="POST"> -->
              <table class="table table-hover table-stripped"><!-- End Table -->
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th class="tb-nowrap">Tests Name</th>
                    <th class="tb-nowrap">Normal Ranges</th>
                    <th class="tb-nowrap text-center" colspan="4">Test Units</th>
                  </tr>
                </thead>

                <tbody class="extra-tests">
                  <tr>
                    <td class="tb-nowrap">1</td>
                    <td class="tb-nowrap"><!-- laboratory extra Test Name-->
                      <input type="text" class=" form-control" name="xtraTestName_0" value="<?=esc(set_value('xtraTestName'))?>" placeholder="Please Enter Test Name">
                      <small class="error errors-xtraTestName_0 text-danger"> </small>
                    </td><!-- laboratory extra Test Name end -->

                    <td class="tb-nowrap"><!-- laboratory extra Ref Ranges -->
                      <input type="text" class=" form-control" name="xtraRefRanges_0" value="<?=esc(set_value('xtraRefRanges'))?>" placeholder="Please Enter Ref Ranges">
                      <small class="error errors-xtraRefRanges_0 text-danger"> </small>
                    </td><!-- laboratory extra Ref Ranges end -->

                    <td class="tb-nowrap" colspan="4"><!-- laboratory extra Test Unit Name -->
                      <select name="xtraUnitid_0" class=" form-control">
                        <option selected value="">Select Unit..</option>
                        <?php if ($unit): ?>
                          <?php foreach ($unit as $row): ?>
                            <option <?= get_select('xtraUnitid', $row->unitId) ?> value="<?= $row->unitId ?>"><?= $row->unitname ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <small class="error errors-xtraUnitid_0 text-danger"> </small>
                    </td><!-- laboratory extra Test Unit Name end -->

                    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->
                    <input type="hidden"  name="xtraTestCode_0" value="<?=esc($TestCode)?>">
                    <input type="hidden"  name="xtraUserId_0" value="<?=esc(Auth::getUserId())?>">
                    <input type="hidden"  name="xtraTestDate_0" value="<?=esc(date('Y-m-d H:i:s'))?>">
                    <input type="hidden"  name="subTestCode_0" value="<?=$TestCode?>">
                    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->

                  </tr>
                </tbody>
              </table><!-- End Table -->
            <!-- </form> Form end -->

            </div>
          </div>
          <!-- ====================ADD EXTRA TESTS ENDZ ======================= -->

          </div><!--tab-content & Bordered Tabs -->
        </div><!-- card-body End -->
      </div><!--End card -->
    </div><!--End col-lg-12 -->
  </div><!--End row -->
</div><!--End container fluides -->
<script>
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

    if(obj.data_type == "save")
    {
      // alert(obj.data);
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
      }else //show Success message and refresh the page if no errors detected
      if (obj.data_type == 'save' && obj.data == "extra test saved Successfully!")
      {
        alert('Extra Test Saved Successfully!');
        window.location.reload();
      }
      // else{
      //   disable_save_button(false);
      //   dirty = false;
      //   alert(obj.data);
      //   window.location.reload();
      // }
    }
  }
}

// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS=========================
// add tabale rows
var num = 1;

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
            <option <?= get_select('xtraUnitid', $row->unitId) ?> value="<?= $row->unitId ?>"><?= $row->unitname ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
      <!--error handling-->
      <small class="error errors-xtraUnitid_${input_count} text-danger"> </small>
    </td><!-- laboratory extra Test Unit Name end -->

    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->
    <input type="hidden"  name="xtraTestCode_${input_count}" value="<?=esc($TestCode)?>">
    <input type="hidden"  name="xtraUserId_${input_count}" value="<?=esc(Auth::getUserId())?>">
    <input type="hidden"  name="xtraTestDate_${input_count}" value="<?=esc(date('Y-m-d H:i:s'))?>">
    <input type="hidden"  name="subTestCode_${input_count}" value="<?=$TestCode?>">
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
  var inputs = content.querySelectorAll("input,select");

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
