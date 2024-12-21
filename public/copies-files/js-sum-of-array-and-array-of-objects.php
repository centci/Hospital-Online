<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>SUMMING ARRAY NUMBERS IN JAVASCRIPT AND ARRAY OF OBJECTS</h1>
  </body>
  <script>
  // FIRST PART OF THE TUTS

  // ARRAY OF NUMBERS
  // var cost = [ 5000, 20000, 2500, 15000, 5000, 25000 ];
  // var arr = cost;
  // let total = 0;

  // method 01
  // const total = cost.reduce((accumulator, value)=>{
  //   return accumulator + value;
  // },0);

  // method 02
  // arr.forEach(value => {
  //   total += value;
  // });

  // method 03
  // for (var i = 0; i < arr.length; i++) {
  //   total += arr[i];
  // }
  // console.log(total);

  // SECOND PART OF THE TUTS

  // ARRAY OF OBJECTS
  var arrOfStrObj = [
  {
    "id": "6",
    "testname": "rft",
    "cost": "25000",
  },
  {
    "id": "5",
    "testname": "rhumatoid factor",
    "cost": "5000",
  },
  {
    "id": "4",
    "testname": "CBC",
    "cost": "15000",
  },
  {
    "id": "3",
    "testname": "BS",
    "cost": "2500",
  },
  {
    "id": "2",
    "testname": "BAT",
    "cost": "5000",
  },
  {
    "id": "1",
    "testname": "RFT",
    "cost": "20000",
  }
  ];
  var testObjectsArray = arrOfStrObj;
  let total = 0;

  // extracting cost from array of objects
  const stringOfTestsCost = testObjectsArray.map((obj) =>{
    return obj.cost;
  }); //End

  // converting array of stringOfTestsCost to array of integer
  const arrOfTestsCostInt = stringOfTestsCost.map(str =>{
    return parseInt(str,10);
  });  //End

  // console.log(arrOfTestsCostInt);

  // METHOD 01
  // Summing the total cost of the test from the arrOfTestsCostInt
  const totalTestCost = arrOfTestsCostInt.reduce((accumulator, value)=>{
    return accumulator + value;
  },0);  //End

  // METHOD 02
  // arrOfTestsCostInt.forEach(value => {
  //   total += value;
  // });

  // METHOD 03
  // for (var i = 0; i < arrOfTestsCostInt.length; i++) {
  //   total += arrOfTestsCostInt[i];
  // }

  // FOR METHOD ONE
  console.log(totalTestCost);

  // FOR METHOD TWO AND THREE
  // console.log(total);

  </script>

</html>
