
<?php require $this->viewsPath('head_foot/header'); ?>
<div class='container-fluids rounded shadow p-4 mx-auto mt-3 col-md-10'>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Search For Clinets By Name Or Phone</h5>
      <!-- search client by name and or name -->
      <nav class="navbar navbar-light bg-light">
        <div class="form-line">
          <div class="input-group">
            <input class="js-search form-control" type="text" value="" placeholder="Search">
            <span class="input-group-prepend">
              <button class="input-group-text"><i class="fa fa-search"></i>&nbsp</button>
            </span>
          </div>
        </div>
      </nav>
      <div class="card-body table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="tb-nowrap">#</th>
              <th class="tb-nowrap">First Name</th>
              <th class="tb-nowrap">Middle Name</th>
              <th class="tb-nowrap">Last Name</th>
              <th class="tb-nowrap">Gender</th>
              <th class="tb-nowrap">DOB</th>
              <th class="tb-nowrap">Phone</th>
              <th class="tb-nowrap text-end">Action</th>
            </tr>
          </thead>
          <tbody class="js-patients-searched">
              <!-- patients record are being displaied here by Ajax and javascrips -->
          </tbody>
        </table>
      </div>
      <!-- End search client by name and or name -->
    </div>
  </div>
</div>

<script>
var search_input  =  document.querySelector(".js-search");
search_input.addEventListener("input", function(e){
  //   console.log('changed');
  var text = e.target.value.trim();

  var data = {};
  data.data_type = "search";
  data.text = text;
  send_data(data);
});
// <--------Or------->
// function search_item(e){
//   console.log('changed');
// };

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
    if (typeof obj != "undefined")
    {
      // console.log(obj);

      //from here we have valid json
      var ptnrow = document.querySelector('.js-patients-searched');
      ptnrow.innerHTML = "";
      for (var i = 0; i < obj.length; i++) {
        ptnrow.innerHTML += patients_html(obj[i]);
      }
    }
  }

  function patients_html(data) {
    return  `<tr>
      <td class="tb-nowrap">${data.id}</td>
      <td class="tb-nowrap">${data.firstname}</td>
      <td class="tb-nowrap">${data.middlename}</td>
      <td class="tb-nowrap">${data.lastname}</td>
      <td class="tb-nowrap">${data.gender}</td>
      <td class="tb-nowrap">${data.dob}</td>
      <td class="tb-nowrap">${data.phone}</td>
      <td class="tb-nowrap text-end">
        <a href="<?=ROOT?>/visits/create/${data.patientId}">Details</a>
      </td>
    </tr>`;
  }
  send_data({
    data_type: "search",
    text: ""
  });
</script>

<?php require $this->viewsPath('head_foot/footer'); ?>
