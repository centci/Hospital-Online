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
            <div class="card-body">
              <h5 class="card-title">Add Extra Tests</h5>

              <form class="" method="POST">
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
                <?php if (isset($_POST['xtraTestName0'])): ?>
                  <?php $numbering = 1; $num = 0 ?>
                  <?php foreach ($_POST as $key => $value): ?>

                    <?php if (strstr($key, 'xtraTestName')): ?>
                      <?php if ($key = 'xtraTestName'.$num || 'xtraRefRanges'.$num || 'xtraUnitid'.$num):?>

                      <tr>
                        <td><?=$numbering;?></td>
                        <td><!-- laboratory extra Test Name -->
                          <input type="text" class=" form-control" name="<?='xtraTestName'.$num?>" value="<?=esc(set_value('xtraTestName'.$num))?>" placeholder="Enter ">
                          <div class="text-danger">
                            <?php if (isset($errors['xtraTestName'.$num])): ?> <?= $errors['xtraTestName'.$num]?> <?php endif; ?>
                          </div>
                        </td><!-- laboratory extra Test Name end -->

                        <td><!-- laboratory extra Ref Ranges -->
                          <input type="text" class=" form-control" name="<?='xtraRefRanges'.$num ?>" value="<?=esc(set_value('xtraRefRanges'.$num))?>" placeholder="Enter ">
                          <div class="text-danger">
                            <?php if (isset($errors['xtraRefRanges'.$num ])): ?> <?= $errors['xtraRefRanges'.$num ]?> <?php endif; ?>
                          </div>
                        </td><!-- laboratory extra Ref Ranges end -->

                        <td><!-- laboratory extra Test Unit Name -->
                          <select name="<?='xtraUnitid'.$num?>" class=" form-control">
                            <option selected value="">Select...</option>
                            <?php if ($unit): ?>
                              <?php foreach ($unit as $row): ?>
                                <option <?= get_select('xtraUnitid'.$num, $row->id) ?> value="<?= $row->id ?>"><?= $row->unitname ?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                          <div class="text-danger">
                            <?php if (isset($errors['xtraUnitid'.$num])): ?> <?= $errors['xtraUnitid'.$num]?> <?php endif; ?>
                          </div>
                        </td><!-- laboratory extra Test Unit Name end -->

                        <td class="text-end "><!-- Add extra Test Row Button -->
                          <span class="text-danger" onclick="remove_row()"><i class="fa fa-trash-alt"></i></span>
                        </td><!-- Add extra Test Row Button End -->

                      </tr>
                    <?php endif; ?>

                      <?php $num++; $numbering++; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php else: ?>

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
                <?php endif; ?>
                </tbody>
              </table><!-- End Table -->
              <div class='form-group mt-2 my-2'>
                <a href="<?=ROOT?>/Tests">
                  <button class='btn btn-warning' type='button' name='btn_add_test'><i class='fa fa-chevron-left'></i>Back</button>
                </a>
                <button class='btn btn-primary float-end'><i class='fa fa-plus'></i>Save</button>
              </div>
            </form><!--Form end-->

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
var extraTest = document.querySelector(".extra-tests");
var num = 1;

function add_extra(e)
{
  // console.log(extraTest.children);
  num ++;
  extraTest.innerHTML += `
  <tr>
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
      <span class="text-danger" onclick="remove_row()"><i class="fa fa-trash-alt"></i></span>
    </td><!-- Add extra Test Row Button End -->

  </tr>`;
}
// Remove table rows
function remove_row()
{
  extraTest.lastElementChild.remove();
}
// ======================APPENDING MORE ROWS TO ADD EXTRA TESTS ENDZ ========================

send_data({
  data_type: 'savingTest',
  text: '',
});
</script>
<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
