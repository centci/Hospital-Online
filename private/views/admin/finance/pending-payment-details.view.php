
<?php require $this->viewsPath('head_foot/header'); ?>
<div class="container-fluids shadow p-4 mt-2 mx-auto profile">
  <div class="row">
    <div class="col-sm-12 col-md-12 bg-light">
      <table class="table table-striped table-hover">
        <tbody>
          <tr>
            <th>First Name:</th>
            <td><?=esc(ucfirst($patientInfo->firstname)) ?></td>
            <th>Last Name:</th>
            <td><?=esc(ucfirst($patientInfo->lastname)) ?></td>
          </tr>

          <tr>
            <th>Gender:</th>
            <td><?=esc(ucfirst($patientInfo->gender)) ?></td>
            <th>Age:</th>
            <td><?=esc(ucfirst($patientInfo->Age)) ?></td>
          </tr>

          <tr>
            <th>Phone:</th>
            <td><?=esc(ucfirst($patientInfo->phone)) ?> </td>
            <th>Date Joined:</th>
            <td><?=esc(get_date($patientInfo->date)) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <hr>
<!-- ================================================================ -->
<div class="row">
  <div class="col-lg-12">
    <div class="card" style="height:348px;">
      <div class="card-body" style="height:118px;">
        <!-- Select Tests Table -->
        <div class="tableFixHead bg-white" style="height: 270px;">
          <table class="tablefix">
          <thead class="thead-fix">
            <tr>
              <th class="th-fix tb-nowrap" style="width: 6%;"></th>
              <th class="th-fix tb-nowrap" style="width: 6%;">Code</th>
              <th class="th-fix tb-nowrap">Test Name</th>
              <th class="th-fix tb-nowrap">Department</th>
              <th class="th-fix tb-nowrap">Fee</th>
              <th class="th-fix tb-nowrap text-end">Record Date</th>
            </tr>
          </thead>
          <tbody class="js-item-details">
            <!-- item-details -->
            <!--table row-->
              <!-- <tr class="tr-fix">
                <td class="td-fix tb-nowrap">6</td>
                <td class="td-fix tb-nowrap">RFT</td>
                <td class="td-fix tb-nowrap">Blood </td>
                <td class="td-fix tb-nowrap">25000 </td>
                <td class="td-fix tb-nowrap text-end">01-Jan-2023</td>
              </tr> -->
            <!--end table row-->
          </tbody>
          </table>
        </div>
        <nav class="navbar navbar-light bg-light mt-2">
            <!-- button for removeing  -->
          <a href="<?=ROOT?>/PendingPayments">
            <button type="button" class="btn btn-sm btn-outline-danger ms-2"><i class="fa fa-chevron-left"></i>Back</button>
          </a>
          <!-- button for Saving Tests -->
          <button type="button" class="js-item-details-gtotal btn btn-sm bg-secondary text-white">Total Cost: 0.00 Ugx</button>

          <!-- button for Saving Tests -->
          <button onclick="submit()" type="submit" class="btn btn-sm btn-outline-primary me-2"><i class="fa fa-plus"></i>Save</button>
        </nav>
      </div>
    </div>
    <!-- end Select Tests Table -->
  </div>
</div>

</div>
<script type="text/javascript">
let ITEMS     = [];

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
  let obj = JSON.parse(result);
  //from here we have valid json
  if (typeof obj != "undefined")
  {
    if (obj.data_type == 'test_details')
    {
      if (obj.data != "")
      {
        // update ITEMS by adding obj.data to it
        ITEMS = obj.data;
        refresh_item_display();
      }
    }
    // Tests saved succesfully
    if (obj.data_type == 'submit_items' && obj.data == "items saved saccessfully")
    {
      alert('Test saved saccessfully');
      window.location.reload();
    }
  }
}

// here is the code that will refresh item detail list and after Splice
function refresh_item_display()
{
  let mydiv = document.querySelector('.js-item-details');
  mydiv.innerHTML = "";
  // loop d array of items for pendingPayments
  for (let i = 0; i < ITEMS.length; i++)
  {
    mydiv.innerHTML += paymentItem_detailsHtml(ITEMS[i],i);
  }

  /* ********************************
  * CALCULATE THE COST OF THE ITEM  *
  **********************************/

  let itemObjectsArray = ITEMS;
  // extracting cost from array of objects
  let stringOfItemsCost = itemObjectsArray.map((obj) =>{
    return obj.cost;
  }); //End

  // converting array of stringOfItemsCost to array of integer
  let arrOfItemsCostInt = stringOfItemsCost.map(str =>{
    return parseInt(str,10);
  });  //End

  // Summing the total cost of the item from the arrOfItemsCostInt
  let totalItemCost = arrOfItemsCostInt.reduce((accumulator, value)=>{
    return accumulator + value;
  },0);  //End

  let item_details_Gcost = document.querySelector('.js-item-details-gtotal');
  item_details_Gcost.innerHTML = "Total Cost: " + totalItemCost + " Ugx";
}

// Remove one item from the cart at a time
function remove_one(index)
{
  if (!confirm('Are You Sure You Want To Remove '+ ITEMS[index].testname +' from the list?'))
    return;
    ITEMS.splice(index,1);
    refresh_item_display();
}

// this is the pending payment item list table
function paymentItem_detailsHtml(data,index)
{
  return `
    <!--table row-->
      <tr class="tr-fix">
      <td onclick="remove_one(${index})" class="td-fix tb-nowrap" style="cursor:pointer"><span class="danger"><i class="fa fa-trash-alt text-danger"></i></span></td>
        <td class="td-fix tb-nowrap">${data.testCode}</td>
        <td class="td-fix tb-nowrap">${data.testname.toUpperCase()}</td>
        <td class="td-fix tb-nowrap">${data.department} </td>
        <td class="td-fix tb-nowrap">${data.cost}</td>
        <td class="td-fix tb-nowrap text-end">${data.pendingPayDate}</td>
      </tr>
    <!--end table row-->
  `;
}

function submit()
{
  let ITEMS_TO_INSERT = [];
  for (let i = 0; i < ITEMS.length; i++)
  {
    let tmp_items = {};
    tmp_items.testCode = ITEMS[i].testCode;
    tmp_items.pendingPayId = ITEMS[i].pendingPayId;
    ITEMS_TO_INSERT.push(tmp_items);
    // console.log(ITEMS_TO_INSERT);
  }

  send_data({
    data_type: "submit_items",
    text: ITEMS_TO_INSERT,
  });
}


send_data({
  data_type: "test_details",
  text: ""
});
</script>
<?php require $this->viewsPath('head_foot/footer'); ?>
