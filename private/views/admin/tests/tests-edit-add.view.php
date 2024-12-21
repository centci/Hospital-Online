<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>
<div class="container-fluid">
  <div class="card">
    <div class="card-header text-center">Add More Row To Extra Test</div>
    <div class="card-body table-responsive ">
    <table class="table table-hover table-stripped"><!-- start Table -->
      <thead>
        <tr>
          <th class="tb-nowrap">Sub Test code</th>
          <th class="tb-nowrap">Tests</th>
          <th class="tb-nowrap">Ranges</th>
          <th class="tb-nowrap">Units</th>
          <th class="tb-nowrap text-end pe-0" style="width: 7%;">
            <span type="button" onclick="add_extra(event)" class=" btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add Row</span>
          </th>
        </tr>
      </thead>
      <tbody class="extra-tests save-test-content">
        <?php if ($testxtra): ?>
          <?php foreach ($testxtra as $row):?>
            <tr>
              <td> <?= $row->subTestCode ?> </td>
              <td> <?= $row->xtraTestName ?> </td>
              <td> <?= $row->xtraRefRanges ?> </td>
              <td> <?= $row->unitRow->unitname ?> </td>
              <td class="text-end ">
                <!-- empty space -->
              </td>
            </tr>
          <?php endforeach;?>
        <?php endif; ?>
      </tbody>
    </table><!-- End Table -->
    </div>
    <div class="card-footer">
    <!-- =============SECOND BACK AND SAVE BUTTON=========== -->
      <div class='form-group mt-2 my-2'>
        <a href="<?=ROOT?>/Tests">
          <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
        </a>
        <button onclick="save_content()" class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
      </div>
    <!-- =========SECOND BACK AND SAVE BUTTON ENDZ=========== -->
    </div>
  </div>
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
      alert(obj.data);
      if (obj.data == 'extra test saved Successfully!')
      {
        //clear all errors
        var error_containers = document.querySelectorAll(".error");
        for (var i = 0; i < error_containers.length; i++)
        {
          error_containers[i].innerHTML = "";
        }

        // Reload the page back to the previous page after Successfull saving
        window.history.back();
      }

      //show any errors
      if(typeof obj.errors == 'object')
      {
        for(key in obj.errors)
        {
          document.querySelector(".errors-"+key).innerHTML = obj.errors[key];
        }
      }
    }
  }
}

// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS=========================
// add tabale rows
// GLOBAL VARIABLE TO CREATE AUTO INCREMENT SUB TEST CODE
var lastSubTestCode = '<?= $lastSubTestCode ?>';
var xtrsubtestcode = '<?= $xtraTestCode ?>';
let lastDigit = lastSubTestCode.substring(lastSubTestCode.length - 1);
// END OF GLOBAL VARIABLE

function add_extra()
{
  var extraTest = document.querySelector(".extra-tests");
  var input_count = extraTest.children.length;
  var mydiv = document.createElement("tr");
  mydiv.setAttribute('onclick', 'remove_test_row(event)');
// console.log(input_count);
  mydiv.innerHTML =`
    <td class="tb-nowrap"><!-- lab subTestCode -->
      <input type="text" class="form-control" name="subTestCode_${input_count}" value="${xtrsubtestcode}-${++lastDigit}" placeholder="subTestCode" readonly>
      <small class="error errors-subTestCode_${input_count} text-danger"> </small>
    </td><!-- lab subTestCode -->

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
          <?php foreach ($unit as $unitrow): ?>
            <option <?= get_select('xtraUnitid', $unitrow->id) ?> value="<?= $unitrow->id ?>"><?= $unitrow->unitname ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
      <!--error handling-->
      <small class="error errors-xtraUnitid_${input_count} text-danger"> </small>
    </td><!-- laboratory extra Test Unit Name end -->

    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->
    <input type="hidden"  name="xtraTestCode_${input_count}" value="<?=esc($xtraTestCode)?>">
    <input type="hidden"  name="xtraUserId_${input_count}" value="<?=esc(Auth::getId())?>">
    <input type="hidden"  name="xtraTestDate_${input_count}" value="<?=esc(date('Y-m-d H:i:s'))?>">
    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate endz-->

    <td class="text-end" id="delete-test-row"><!-- Delete extra Test Row Button -->
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
} //endz of Remove table rows

// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS ENDZ ========================

function save_content()
{
  var content = document.querySelector(".save-test-content");
  var inputs = content.querySelectorAll("input,select, checkbox");
  console.log(inputs);
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
