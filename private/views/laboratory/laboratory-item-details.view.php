
<?php require $this->viewsPath('head_foot/header'); ?>
<div class="container-fluids shadow p-4 mt-2 mx-auto">

<!-- ================================================================ -->
<div class="row">
  <div class="col-lg-12">
    <div class="card" style="min-height:490px;">

      <div class="card-body" style="min-height:118px;">
        <div class="row">
          <h2 class="text-center">Laboratory Request Details</h2>
        </div>
        <!-- Select item Table -->
        <div class="tableFixHead bg-white" style="min-height: 320px;">
          <table class="tablefix">
          <thead class="thead-fix">
            <tr>
              <th class="th-fix tb-nowrap" style="width: 6%;">X</th>
              <th class="th-fix tb-nowrap" style="width: 6%;">Code</th>
              <th class="th-fix tb-nowrap">Item Name</th>
              <th class="th-fix tb-nowrap">Full Name</th>
              <th class="th-fix tb-nowrap">Patient No</th>
              <th class="th-fix tb-nowrap">Fee</th>
              <th class="th-fix tb-nowrap">Status</th>
              <th class="th-fix tb-nowrap text-end">Record Date</th>
            </tr>
          </thead>
          <tbody class="js-lab-item-detail">
            <!-- item-details -->
                <!-- <tr class="tr-fix">
                  <td class="td-fix tb-nowrap"> <input type="checkbox" name="" value=""> </td>
                  <td class="td-fix tb-nowrap">code</td>
                  <td class="td-fix tb-nowrap">items name</td>
                  <td class="td-fix tb-nowrap">patient name</td>
                  <td class="td-fix tb-nowrap">department</td>
                  <td class="td-fix tb-nowrap">cost </td>
                  <td class="td-fix tb-nowrap">status </td>
                  <td class="td-fix tb-nowrap text-end">date</td>
                  <td class="td-fix tb-nowrap text-end">Acrion</td>
                </tr> -->
            <!--end table row-->
          </tbody>
          </table>
        </div>
        <nav class="navbar navbar-light bg-light mt-2">
            <!-- button for removeing  -->
          <a href="<?=ROOT?>/laboratorys/laboratory">
            <button type="button" class="btn btn-sm btn-outline-danger ms-2"><i class="fa fa-chevron-left"></i>Back</button>
          </a>
          <!-- button for Saving Tests -->
          <button type="button" class="js-gtotal-items btn btn-sm bg-secondary text-white">Total Cost: 0.00 Ugx</button>
          <!-- button for Saving Tests -->
          <button onclick="labItemSubmit(event)" type="button" class="btn btn-sm btn-outline-primary me-2"><i class="fa fa-plus"></i>Save</button>
        </nav>
      </div>
    </div>
    <!-- end Select Tests Table -->
  </div>
</div>

</div>


<script type="text/javascript">
// Variables
LAB_ITEMS_DETAILS = [];
let labdiv = document.querySelector('.js-lab-item-detail');


function send_data(data)
{
  let ajax = new XMLHttpRequest();
  ajax.addEventListener('readystatechange', function(){

    if (ajax.readyState == 4)
    {
      if (ajax.status == 200)
      {
        handle_result(ajax.responseText);
        // console.log(ajax.responseText);
      }else
      {
        // errors
        console.log("An Error Occured, Error Code: "+ajax.status+". Error Massage: "+ajax.statusText);
        console.log(ajax);
      }
    }
  });
  ajax.open('post','',true);
  ajax.send(JSON.stringify(data));
}
// handle results coming from controller
function handle_result(result)
{
  console.log(result);

  let obj = JSON.parse(result);
  //from here we have valid json
  if (typeof obj != "undefined")
  {
    if (obj.data_type == 'LabitemDetail')
    {
      if (obj.data != "")
      {
        // update LAB_ITEMS_DETAILS by adding obj.data to it
        LAB_ITEMS_DETAILS = [];
        LAB_ITEMS_DETAILS = obj.data;

        refresh_tests_display();
      }
    }
  }
}

function Item_detailsHtml(data,index)
{
  return `
    <!--table row-->
    <tr class="tr-fix">
      <td onclick="remove_item(${index})" class="td-fix tb-nowrap" style="cursor:pointer"><span class="danger"><i class="fa fa-trash-alt text-danger"></i></span></td>
      <td class="td-fix tb-nowrap">${data.testCode}</td>
      <td class="td-fix tb-nowrap">${data.testname.toUpperCase()}</td>
      <td class="td-fix tb-nowrap">${data.firstname +" "+ data.lastname}</td>
      <td class="td-fix tb-nowrap">${data.patientId}</td>
      <td class="td-fix tb-nowrap">${data.cost} </td>
      <td class="td-fix tb-nowrap">${data.pymt_status} </td>
      <td class="td-fix tb-nowrap text-end">${data.cashierSavedDate}</td>
    </tr>
    <!--end table row-->
  `;
}

// function to refresh or reload display
function refresh_tests_display()
{
  labdiv.innerHTML = "";
  // loop d array of items for new requested items
  for (let i = 0; i < LAB_ITEMS_DETAILS.length; i++)
  {
    labdiv.innerHTML += Item_detailsHtml(LAB_ITEMS_DETAILS[i],i);
  }

  // CALCULATE THE COST OF THE TEST

  var testObjectsArray = LAB_ITEMS_DETAILS;
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
  var total_tests_cost = document.querySelector('.js-gtotal-items');
  total_tests_cost.innerHTML = "Total Cost: " + totalTestCost + " Ugx";
  //End of display fanction
}

// remove a test from request for reason unavoidable
function remove_item(index)
{
  if (!confirm('Are You Sure You Want To Remove '+ LAB_ITEMS_DETAILS[index].testname.toUpperCase() +' from the list?'))
    return;

 LAB_ITEMS_DETAILS.splice(index,1);
 // console.log(LAB_ITEMS_DETAILS);

 refresh_tests_display();
}

// submit the request for result reporting
function labItemSubmit(e)
{
  var LAB_ITEM_TO_INSERT = [];

  for (var i = 0; i < LAB_ITEMS_DETAILS.length; i++)
  {
    var tmp_tests = {};
    tmp_tests.cashierSavedReceiptNo = LAB_ITEMS_DETAILS[i].cashierSavedReceiptNo;
    tmp_tests.testCode = LAB_ITEMS_DETAILS[i].testCode;
    tmp_tests.patientId = LAB_ITEMS_DETAILS[i].patientId;
    LAB_ITEM_TO_INSERT.push(tmp_tests);
    // console.log(LAB_ITEM_TO_INSERT);
  }

  send_data({
    data_type: "submit_lab_item",
    text: LAB_ITEM_TO_INSERT,
  });
}

send_data({
  data_type: "requestDetails",
  text: '',
});
</script>
<?php require $this->viewsPath('head_foot/footer'); ?>
