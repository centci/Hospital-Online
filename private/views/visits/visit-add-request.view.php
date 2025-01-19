
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='container-fluids rounded shadow p-2 mx-auto col-md-12 mt-3'>
  <!-- Visit head client persional information -->
  <?php if ($row): ?>

  <div class="row">
    <div class="col-md-12 table-responsive">
      <table class="table bg-white">
        <tr>
          <th class="tb-nowrap x12-font">Full Name:</th>
          <td class="tb-nowrap "><?=$row->patientRow->name ?></td>
          <!-- ================= -->
          <th class="tb-nowrap x12-font">Mobile:</th>
          <td class="text-end"><?=$row->patientRow->phone ?></td>
        </tr>
        <!-- second table row -->
        <tr>
          <th class="x12-font">Gender:</th>
          <td class=""><?=$row->patientRow->gender ?></td>
          <!-- ================= -->
          <th class="tb-nowrap x12-font">Patient No:</th>
          <td class="text-end"><?=$row->patientRow->patientId ?></td>
        </tr>
        <tr>
          <th class="x12-font">Age:</th>
          <td class=""><?=$row->Age ?></td>
          <!-- =============== -->
          <th class="tb-nowrap x12-font">Visit Date:</th>
          <td class="text-end"><?=num_date($row->VisitDate) ?></td>
        </tr>

      </table>
    </div>
  </div>
  <!-- visit body gather information about tests -->

  <div class="row">
    <div class="col-lg-6">
      <div class="card" style="height:348px;">
        <div class="card-body" style="height:118px;">
          <div class="form-line">
            <div class="input-group mb-1">
              <h4>Select Tests</h4>
              <input class="js-search form-control ms-1" type="text" name="find" placeholder="Search">
              <span class="input-group-text"><i class="fa fa-search"></i>&nbsp</span>
            </div>
          </div>

          <!-- Select Tests Table -->
          <div class="tableFixHead bg-white" style="height: 270px;">
            <table class="tablefix">
              <thead class="thead-fix">
                <tr>
                <th class="th-fix tb-nowrap" style="width: 6%;">Code</th>
                <th class="th-fix tb-nowrap">Test Name</th>
                <th class="th-fix tb-nowrap">Sample</th>
                <th class="th-fix tb-nowrap">Fee</th>
                <th class="th-fix tb-nowrap text-end">Action</th>
              </tr>
              </thead>
              <tbody onclick="add_tests(event);" class="js-tests">
                <!-- tests here is being displayed by javascrips -->

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- end Select Tests Table -->
    </div>

    <div class="col-lg-6">
      <div class="card" style="height:348px;">
        <div class="card-body" style="height:118px;">
          <h5 class="card-title text-center">
            Selected Tests
            <div class="js-tests-count badge bg-primary mb-2 rounded-circle">
              0
            </div>
          </h5>
          <!-- Table with stripped rows -->
          <div class="tableFixHead bg-white" style="height: 235px;">
            <table class="tablefix">
              <thead class="thead-fix">
                <tr>
                <th class="th-fix tb-nowrap" style="width: 6%;">Code</th>
                <th class="th-fix tb-nowrap">Test Name</th>
                <th class="th-fix tb-nowrap">Fee</th>
                <th class="th-fix tb-nowrap">Sample</th>
                <th colspan="3" class="th-fix tb-nowrap">Container</th>
                <!-- <th class="th-fix tb-nowrap"></th> -->
              </tr>
              </thead>
              <tbody class="js-selected-tests">
                <!-- rows for selected tests to save request is displayed here by javascrips -->
              </tbody>
            </table>
          </div>
          <nav class="navbar navbar-light bg-light">
              <!-- button for removeing  -->
            <a href="#">
              <button onclick="clear_all()" type="button" class="btn btn-sm btn-outline-danger ms-2"><i class="fa fa-trash-alt"></i>Clear All</button>
            </a>

            <!-- button for Saving Tests -->
            <button type="button" class="js-gtotal btn btn-sm bg-secondary text-white">Total Cost: 0.00 Ugx</button>

            <!-- button for Saving Tests -->
            <button onclick="submit()" type="submit" class="btn btn-sm btn-outline-primary me-2"><i class="fa fa-plus"></i>Save</button>
          </nav>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <td colspan="100"><h3 class="text-center text-danger">Patient Request Not Found!</h3></td>
<?php  endif; ?>
</div>
<script>
var TESTS     = [];
var ADDED_TESTS  = [];
var PATIENT_VISIT_INFO  = [];

var search_input  =  document.querySelector(".js-search");
search_input.addEventListener("input", function(e){
    // console.log('changed');
  var text = e.target.value.trim();

  var data = {};
  data.data_type = "search_test";
  data.text = text;
  send_data(data);
});

function send_data(data)
{
  var ajax = new XMLHttpRequest();
  ajax.addEventListener('readystatechange', function(){

    if (ajax.readyState == 4)
    {
      if (ajax.status == 200)
      {
        handle_result(ajax.responseText);
        // console.log(ajax.responseText);
      }else
      {// errors
        console.log("An Error Occured, Error Code: "+ajax.status+". Error Massage: "+ajax.statusText);
        console.log(ajax);
      }
    }
  });
  ajax.open('post','',true);
  ajax.send(JSON.stringify(data));
}

function handle_result(result)
{
  // console.log(result);

  var obj = JSON.parse(result);
  //from here we have valid json

  if (typeof obj != "undefined")
  {
    if (obj.data_type == 'search_test')
    {
      var mydiv = document.querySelector('.js-tests');
      mydiv.innerHTML = "";
      TESTS = [];
      if (obj.data != "" && obj.visits != "")
      {
        // update tests by adding obj.data to it
        TESTS = obj.data;
        PATIENT_VISIT_INFO = obj.visits;
        // loop d array of tests
        for (var i = 0; i < obj.data.length; i++)
        {
          mydiv.innerHTML += tests_html(obj.data[i],i);
        }
      }
    }

    if (obj.data_type == 'submit_test' && obj.data == "Test saved saccessfully")
    {
      alert('Test saved saccessfully');
      window.location.reload();
    }
  }
}
// tests to be selected and added to selected row to add request
function tests_html(data,index)
{
  return `
    <tr  class="tr-fix">
      <td class="td-fix tb-nowrap">${data.id}</td>
      <td class="td-fix tb-nowrap">${data.testname.toUpperCase()}</td>
      <td class="td-fix tb-nowrap">${data.sampleRow.samplename} </td>
      <td class="td-fix tb-nowrap">${data.cost} </td>
      <td class="td-fix tb-nowrap text-end">
        <span class='btn-sm btn-primary' role='button' index="${index}">
          <i index="${index}" class="fa fa-add"></i> Add
        </span>
      </td>
    </tr>
  `;
}
// selected test to add request
function request_html(data,index)
{
  return `
    <tr class="tr-fix">
      <td class="td-fix tb-nowrap">${data.id}</td>
      <td class="td-fix tb-nowrap">${data.testname.toUpperCase()}</td>
      <td class="td-fix tb-nowrap">${data.cost}</td>
      <td class="td-fix tb-nowrap">${data.sampleRow.samplename}</td>
      <td class="td-fix tb-nowrap">${data.containerRow.containername}</td>
      <td onclick="remove_one(${index})" class="td-fix tb-nowrap"><span class="danger"><i class="fa fa-trash-alt text-danger"></i></span></td>
    </tr>
  `;
}
// function to add tests to the lab Request
function add_tests(e)
{
  if (e.target.tagName == "I" || e.target.tagName == "SPAN")
  {
    var index = e.target.getAttribute('index');
    // check if tests already exist in the array and stop it from being repeated
    for (var i = ADDED_TESTS.length - 1; i >= 0; i--)
    {
      if (ADDED_TESTS[i].id == TESTS[index].id)
      {
        alert("Test is already in the list");
        return;
      }
    }
    // adding test from TESTS to ADDED_TESTS array
    ADDED_TESTS.push(TESTS[index]);
    refresh_tests_display();
  }
}
// function to reload/refresh the test list
function refresh_tests_display()
{
  var tests_count = document.querySelector('.js-tests-count');
  tests_count.innerHTML = ADDED_TESTS.length;

  var selected_tests = document.querySelector('.js-selected-tests');
  selected_tests.innerHTML = "";
  var grand_total = 0;

  for (var i = ADDED_TESTS.length - 1; i >= 0; i--) {
    selected_tests.innerHTML += request_html(ADDED_TESTS[i],i);
  }

  // CALCULATE THE COST OF THE TEST

  var testObjectsArray = ADDED_TESTS;
  // extracting cost from array of objects
  var stringOfTestsCost = testObjectsArray.map((obj) =>{
    return obj.cost;
  }); //End

  // converting array of stringOfTestsCost to array of integer
  var arrOfTestsCostInt = stringOfTestsCost.map(str =>{
    return parseInt(str,10);
  });  //End

  // Summing the total cost of the test from the arrOfTestsCostInt
  var totalTestCost = arrOfTestsCostInt.reduce((accumulator, value)=>{
    return accumulator + value;
  },0);  //End

  // Displaying the total test cost;
  var total_tests_cost = document.querySelector('.js-gtotal');
  total_tests_cost.innerHTML = "Total Cost: " + totalTestCost + " Ugx";
  //End of display fanction
}

// clear all tests from the cart
function clear_all()
{
  if (!confirm('Are You Sure You Want To Clear All Tests In The List?'))
    return;

    ADDED_TESTS = [];
    refresh_tests_display();
}
// Remove one test from the cart at a time
function remove_one(index)
{
  if (!confirm('Are You Sure You Want To Remove '+ ADDED_TESTS[index].testname.toUpperCase() +' from the list?'))
    return;
    ADDED_TESTS.splice(index,1);
    refresh_tests_display();
}

function submit()
{
  var TEST_TO_INSERT = [];

  for (var i = 0; i < ADDED_TESTS.length; i++)
  {
    var tmp_tests = {};
    tmp_tests.departmentId = PATIENT_VISIT_INFO.departmentId;
    tmp_tests.testCode = ADDED_TESTS[i].testCode;
    TEST_TO_INSERT.push(tmp_tests);
    // console.log(TEST_TO_INSERT);
  }

  send_data({
    data_type: "submit_test",
    text: TEST_TO_INSERT,
  });
}

send_data({
  data_type: "search_test",
  text: ""
});

</script>
<?php require $this->viewsPath('head_foot/footer'); ?>
