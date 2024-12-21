
<?php require $this->viewsPath('head_foot/header'); ?>
<div class="container-fluids shadow p-3 mx-auto">

<!-- ================================================================ -->
<div class="row">
  <div class="col-lg-12 submit-tests-report">
    <div class="card" style="min-height:490px;">
      <div class="row">
        <div class="col-md-12 table-responsive">
          <table class="table bg-white">
            <tr>
              <th class="tb-nowrap x12-font">Full Name:</th>
              <td class="tb-nowrap "><?=$row->lastname." ".$row->lastname ?></td>
              <!-- ================= -->
              <th class="tb-nowrap x12-font">Mobile:</th>
              <td class="text-end"><?=$row->phone ?></td>
            </tr>
            <!-- second table row -->
            <tr>
              <th class="x12-font">Gender:</th>
              <td class=""><?=$row->gender ?></td>
              <!-- ================= -->
              <th class="tb-nowrap x12-font">Patient No:</th>
              <td class="text-end"><?=$row->patientId ?></td>
            </tr>
            <tr>
              <th class="x12-font">Age:</th>
              <td class=""><?=$row->Age ?></td>
              <!-- =============== -->
              <th class="tb-nowrap x12-font">Visit Date:</th>
              <td class="text-end"><?=num_date($row->date) ?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- SINGLE REPORTING FORM -->
      <div class="card-body py-1">
      <div class="row g-3">
        <div class="form-floating col-md-3 my-1">
          <select onchange="selectTestsToChnageRangesAndUnits(event)" class="js-labtestdisplay form-control form-control-sm col-6" name="" readonly>
            <option>Select</option>
            <!-- <option>1</option> -->
          </select>
          <label for="floatingInput">Select Test</label>
        </div>
        <div class="form-floating col-md-3 my-1">
          <input type="text" class="form-control js-test-testResult" name="testResult" placeholder="Enter Result">
          <label for="">Enter Result</label>
          <!--error handling-->
          <small class="error errors-testResult text-danger"> </small>
        </div>
        <div class="form-floating col-md-3 my-1">
          <input type="text" class="form-control js-test-range" id="" placeholder="Ranges" readonly>
          <label for="">Ranges</label>
        </div>
        <div class="form-floating col-md-3 my-1">
          <input type="text" class="form-control js-test-unit" id="" placeholder="Test Unit" readonly>
          <label for="">Test Unit</label>
        </div>

        <!-- hidden fields -->
        <input type="hidden" class="form-control" name="reportLabReqSampleId" value="<?= $labReqSampleId ?>" readonly>
        <input type="hidden" class="form-control js-reportTestCode" name="reportTestCode" value="" readonly>
        <input type="hidden"  name="labReportId" value="<?=esc(random_string(10))?>" readonly>
        <input type="hidden"  name="reportUserId" value="<?=esc(Auth::getId())?>" readonly>
        <input type="hidden"  name="reportDate" value="<?=esc(date('Y-m-d H:i:s'))?>" readonly>

      </div>
    </div><!--END SINGLE REPORTING FORM -->

      <div class="card-body py-0" style="min-height:118px; displhay:none;">

        <!-- Select item Table -->
        <div class="tableFixHead bg-white" style="min-height: 320px;">
          <table class="tablefix">
          <thead class="thead-fix">
            <tr>
              <th class="th-fix tb-nowrap">Sub Test Code</th>
              <th class="th-fix tb-nowrap">Sub Test Name</th>
              <th class="th-fix tb-nowrap text-center">Result</th>
              <th class="th-fix tb-nowrap text-center">Normal Range</th>
              <th class="th-fix tb-nowrap text-end">Result Flag</th>
              <th class="th-fix tb-nowrap text-end">Test Unit</th>
              <th class="th-fix tb-nowrap text-end">Report</th>
            </tr>
          </thead>
          <tbody class="js-xtratest">
            <!-- <tr class="tr-fix">
              <td class="td-fix tb-nowrap">
                <input style="min-width: 120px;" class="form-control" name="" value="" readonly>
              </td>
              <td class="td-fix tb-nowrap">
                <input style="min-width: 120px;" class="form-control" type="text" name="" value="">
              </td>
              <td class="td-fix tb-nowrap text-center">Normal Range</td>
              <td class="td-fix tb-nowrap text-end">Result Flag</td>
              <td class="td-fix tb-nowrap text-end">Test Unit</td>
              <td class="td-fix tb-nowrap text-end">Report</td>
            </tr> -->
          </tbody>
          </table>
        </div>
        <div class='form-group mt-2 my-2'>
          <a href="<?=ROOT?>/laboratorys/Laboratorysavedrequest">
            <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
          </a>
          <button onclick="submit_tests_report()" class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
        </div>
      </div>
    </div>
    <!-- end Select Tests Table -->
  </div>
</div>

</div>
<script type="text/javascript">
// Global Variables
var TEST_DETAILS = [];
var EXTRATEST_ID     = [];
var EXTRATESTDETAILS  = [];
var testextra = document.querySelector('.js-xtratest');

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
// handle results coming from controller
function handle_results(results)
{
  // debuging the errors
  // console.log(results);
  try
  {
    let obj = JSON.parse(results);
    if (typeof obj == "object")
    {
      if (obj.data_type == 'labtests')
      {
        TEST_DETAILS = [];

        if (obj.data != " ")
        {
          TEST_DETAILS = obj.data;

          var  mydiv = document.querySelector('.js-labtestdisplay');
          for (var i = 0; i < obj.data.length; i++)
          {
            mydiv.innerHTML += selectTest(obj.data[i]);
          }
        }
      }
      else
      if (obj.data_type == 'xtralabtests')
      {
        if (obj.data != " ")
        {
          EXTRATESTDETAILS = [];
          EXTRATESTDETAILS = obj.data;
          for (var i = 0; i < obj.data.length; i++)
          {
            testextra.innerHTML += xtraTest_HTML(obj.data[i],i);
          }
        }
      }
      else
      if(obj.data_type == "save")
      {
        // HANDLING ERROR AND DISPLAYING ITS MESSAGE ACCORDINGLY
        alert(obj.data);

        //clear all errors if all goes well
        var error_containers = document.querySelectorAll(".error");
        for (var i = 0; i < error_containers.length; i++) {
          error_containers[i].innerHTML = "";
        }
        //Refreshing the page if there is no error or if result has been Successfully saved
        if(typeof obj.errors != 'object')
        {
          window.location.reload();
        }
        //show any errors if any.
        if(typeof obj.errors == 'object')
        {
          for(key in obj.errors)
          {
            document.querySelector(".errors-"+key).innerHTML = obj.errors[key];
          }
        }
      }// END OF HANDLING ERROR
    }
  } catch (error) {
    // console.error("Error parsing JSON:", error);
    return {};
  }
}

// function for selecting test to report
function selectTest(data,index)
{
  return `<option value="${data.testCode}">${data.testname.toUpperCase()}</option>`;
}
function selectTestsToChnageRangesAndUnits(e)
{
  // clear extra tests area on changed to a singl tests.
  testextra.innerHTML = "";

  // variables to change tests units and Ranges
  var  Tvalue           = e.target.value;
  var  testRange        = document.querySelector('.js-test-range');
  var  testUnit         = document.querySelector('.js-test-unit');
  var  singeTestCode    = document.querySelector('.js-reportTestCode');

  testUnit.innerHTML = "";
  testRange.innerHTML = "";

// for each to loop through the tests ranges and units
  for (var i = 0; i < TEST_DETAILS.length; i++)
  {
    if (Tvalue == TEST_DETAILS[i].labReqTestCode)
    {
      // display test uinits
      if (TEST_DETAILS[i].uintid !== null)
      {
        if (typeof TEST_DETAILS[i].unitRow !== "undefined")
        {
          testUnit.setAttribute('value',TEST_DETAILS[i].unitRow.unitname);
          testUnit.setAttribute('name','unitname');
        }else {
          testUnit.setAttribute('value','N/A');
        }
      }
      // colecting singe Test Code to report
      if (TEST_DETAILS[i].refRanges !== null)
      {
        if (typeof TEST_DETAILS[i].refRanges !== "undefined")
        {
          singeTestCode.setAttribute('value',TEST_DETAILS[i].testCode);
        }
      }else {
        singeTestCode.setAttribute('value',' ');
      }
      // display test ranges
      if (TEST_DETAILS[i].refRanges !== null)
      {
        testRange.setAttribute('value',TEST_DETAILS[i].refRanges);
      }else {
        testRange.setAttribute('value','N/A');
      }
    }
    // show extra test items here, the same way we changing normal ranges and units.
    if (Tvalue == TEST_DETAILS[i].testCode && TEST_DETAILS[i].testCode !== null)
    {
      EXTRATEST_ID = [];
      EXTRATEST_ID = TEST_DETAILS[i].testCode;

      send_data({
        data_type: "xtralabtests",
        extraTest_id: EXTRATEST_ID,
      });
      EXTRATEST_ID = [];
    }
  }
}
// append extraTest for result reporting
function xtraTest_HTML(data,index)
{
  return `
  <tr class="tr-fix">
    <input type="hidden" class="form-control" name="extraTestReportSampId_${index}" value="<?= $labReqSampleId ?>" readonly>
    <input type="hidden" class="form-control" name="extraTestReportTestCode_${index}" value="${data.xtraTestCode}" readonly>

    <td class="td-fix tb-nowrap">
      <input style="min-width: 120px;" class="form-control" name="extraTestReportSubTestCode_${index}" value="${data.subTestCode}" readonly>
    </td>
    <td class="td-fix tb-nowrap">
      <input style="min-width: 120px;" class="form-control" name="" value="${data.xtraTestName}" readonly>
    </td>
    <td class="td-fix tb-nowrap">
      <input style="min-width: 120px;" class="form-control" type="text" name="extratestResults_${index}" value="">
      <!--error handling-->
      <small class="error errors-extratestResults_${index} text-danger"> </small>
    </td>
    <td class="td-fix tb-nowrap text-center">${data.xtraRefRanges}</td>
    <td class="td-fix tb-nowrap text-end">N/A</td>
    <td class="td-fix tb-nowrap text-end">${data.unitname}</td>
    <td class="td-fix tb-nowrap text-end">Report</td>

    <input type="hidden"  name="extraTestReportId_${index}" value="<?=esc(random_string(10))?>">
    <input type="hidden"  name="extraTestReportBy_${index}" value="<?=esc(Auth::getId())?>">
    <input type="hidden"  name="extraTestReportDate_${index}" value="<?=esc(date('Y-m-d H:i:s'))?>">

  </tr>
  `;
}

function submit_tests_report()
{
  var submitTestsReport = document.querySelector('.submit-tests-report');
  var inputs = submitTestsReport.querySelectorAll("input,select");
  // console.log(inputs);
  var obj = {};
  obj.data_type = "save";

  for (var i = 0; i < inputs.length; i++)
  {
    var key = inputs[i].name;
    obj[key] = inputs[i].value;
  }
  send_data(obj);
}

send_data({
  data_type: "labtests",
  text: ""
});
</script>
<?php require $this->viewsPath('head_foot/footer'); ?>
