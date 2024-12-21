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
              <h5 class="card-title">Add Extra Tests</h5>

              <!-- <form class="" method="POST"> -->
              <table class="table table-hover table-stripped"><!-- End Table -->
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
                      <input type="text" class=" form-control" name="xtraTestName_0" value="<?=esc(set_value('xtraTestName'))?>" placeholder="Enter ">
                      <div class="text-danger">
                        <?php if (isset($errors['xtraTestName'])): ?> <?= $errors['xtraTestName']?> <?php endif; ?>
                      </div>
                    </td><!-- laboratory extra Test Name end -->

                    <td><!-- laboratory extra Ref Ranges -->
                      <input type="text" class=" form-control" name="xtraRefRanges_0" value="<?=esc(set_value('xtraRefRanges'))?>" placeholder="Enter ">
                      <div class="text-danger">
                        <?php if (isset($errors['xtraRefRanges'])): ?> <?= $errors['xtraRefRanges']?> <?php endif; ?>
                      </div>
                    </td><!-- laboratory extra Ref Ranges end -->

                    <td><!-- laboratory extra Test Unit Name -->
                      <select name="xtraUnitid_0" class=" form-control">
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
                    <td> <!-- Empty Cell --> </td>

                    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->
                    <input type="hidden"  name="xtraTestCode_0" value="<?=esc($id)?>">
                    <input type="hidden"  name="xtraUserId_0" value="<?=esc(Auth::getId())?>">
                    <input type="hidden"  name="xtraTestDate_0" value="<?=esc(date('Y-m-d H:i:s'))?>">
                    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->

                  </tr>
                </tbody>
              </table><!-- End Table -->
              <div class='form-group mt-2 my-2'>
                <a href="<?=ROOT?>/Tests">
                  <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
                </a>
                <button onclick="save_content()" class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
              </div>
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

    if(obj.data_type == "extra test saved")
    {

      // alert(obj.data);
      alert('data saved');

      // //clear all errors
      // var error_containers = document.querySelectorAll(".error");
      // for (var i = 0; i < error_containers.length; i++) {
      //   error_containers[i].innerHTML = "";
      // }
      //
      // //show any errors
      // if(typeof obj.errors == 'object')
      // {
      //   for(key in obj.errors)
      //   {
      //     document.querySelector(".error-"+key).innerHTML = obj.errors[key];
      //   }
      //
      // }else{
      //   disable_save_button(false);
      //   dirty = false;
      //   alert(obj.data);
      //   window.location.reload();
      // }
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
var num = 1;

function add_extra(e)
{
  var extraTest = document.querySelector(".extra-tests");
  var mydiv = document.createElement("tr");
  mydiv.setAttribute('onclick','remove_test_row(event)');
  // console.log(mydiv);
  num ++;
  mydiv.innerHTML =`
    <td>${num}</td>
    <td><!-- laboratory extra Test Name-->
      <input type="text" class=" form-control" name="xtraTestName_${extraTest.children.length}" value="<?=esc(set_value('xtraTestName'))?>" placeholder="Enter ">
      <div class="text-danger">
        <?php if (isset($errors['xtraTestName'])): ?> <?= $errors['xtraTestName']?> <?php endif; ?>
      </div>
    </td><!-- laboratory extra Test Name end -->

    <td><!-- laboratory extra Ref Ranges -->
      <input type="text" class=" form-control" name="xtraRefRanges_${extraTest.children.length}" value="<?=esc(set_value('xtraRefRanges'))?>" placeholder="Enter ">
      <div class="text-danger">
        <?php if (isset($errors['xtraRefRanges'])): ?> <?= $errors['xtraRefRanges']?> <?php endif; ?>
      </div>
    </td><!-- laboratory extra Ref Ranges end -->

    <td><!-- laboratory extra Test Unit Name -->
      <select name="xtraUnitid_${extraTest.children.length}" class=" form-control">
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

    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->
    <input type="hidden"  name="xtraTestCode_${extraTest.children.length}" value="<?=esc($id)?>">
    <input type="hidden"  name="xtraUserId_${extraTest.children.length}" value="<?=esc(Auth::getId())?>">
    <input type="hidden"  name="xtraTestDate_${extraTest.children.length}" value="<?=esc(date('Y-m-d H:i:s'))?>">
    <!--hidden input for xtraTestCode, xtraUserId, xtraTestDate-->

    <td class="text-end" id="delete-test-row"><!-- Add extra Test Row Button -->
      <span class="text-danger" id="delete-test-row"><i id="delete-test-row" class="fa fa-trash-alt fs-2"></i></span>
    </td>`; //<!-- Add extra Test Row Button End -->

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
// console.log(inputs);
  var obj = {};
  obj.data_type = "save";

  for (var i = 0; i < inputs.length; i++) {

    var key = inputs[i].name;
    obj[key] = inputs[i].value;

    // if(inputs[i].type == 'file')
    //   obj[key] = inputs[i].files[0];
    //
    // if(inputs[i].getAttribute('uid'))
    //   obj['uid_'+key] = inputs[i].getAttribute('uid');

    /*
    if(inputs[i].getAttribute('index'))
      obj['index_'+key] = inputs[i].getAttribute('index');
    */
  }

  send_data(obj);
}
</script>
<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
