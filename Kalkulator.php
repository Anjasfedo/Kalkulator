<?php
$currentValue = 0;

$input = [];

function getInputAsString($values){
	$a = "";
	foreach ($values as $value){
		$a .= $value;
	}
	return $a;
}

function calculateInput($userInput){
    $arr = [];
    $char = "";
    foreach ($userInput as $num){
        if(is_numeric($num) || $num == "."){
            $char .= $num;
        }else if(!is_numeric($num)){
            if(!empty($char)){
                $arr[] = $char;
                $char = "";
            }
            $arr[] = $num;
        }
    }
    if(!empty($char)){
        $arr[] = $char;
    }

    $current = 0;
    $action = null;
    for($i=0; $i<= count($arr)-1; $i++){
        if(is_numeric($arr[$i])){
            if($action){
                if($action == "+"){
                    $current = $current + $arr[$i];
                }
                if($action == "-"){
                    $current = $current - $arr[$i];
                }
                if($action == "x"){
                    $current = $current * $arr[$i];
                }
                if($action == "/"){
                    $current = $current / $arr[$i];
				}
                $action = null;
            }else{
                if($current == 0){
                    $current = $arr[$i];
                }
            }
        }else{
            $action = $arr[$i];
        }
    }
    return $current;

}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['input'])){
        $input = json_decode($_POST['input']);
	}

    if(isset($_POST)){
		
        foreach ($_POST as $key=>$value){
            if($key == 'equal'){
               $currentValue = calculateInput($input);
               $input = [];
               $input[] = $currentValue;
            }elseif($key == "c"){
                $input = [];
                $currentValue = 0;
            }elseif($key == "back"){
                $lastPointer = count($input) -1;
                if(is_numeric($input[$lastPointer])){
                    array_pop($input);
                }
            }elseif($key != 'input'){
                $input[] = $value;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Kalkulator</title>
    <style>
    html{
    display: grid;
    place-items: center;
    background-color: burlywood;
}

body{
    margin: 5vw auto;
}

.main {
    max-width: 500px;
    margin: 0 auto;
    background-color: grey;
    border-radius: 10px;
    padding: 25px;
  }
  
  h3 {
    text-align: center;
  }
  
  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  .tabel {
    width: 100%;
  }
  
  table {
    width: 100%;
    margin-top: 10px;
  }
  
  td {
    border: 1px solid #ccc;
    text-align: center;
    background-color: whitesmoke;
  }
  
  .isi {
    margin: 15px auto;
    border-radius: 5px;
    width: 90%;
    font-size: 20px;
    text-align: right;
  }

  /* */

  input{
    padding: 10px;
    width: 100%;
    height: 100%;
    border: 0;
  }

  form{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .hasil{
    display: flex;
    justify-content: center;
  }
  </style>
</head>
<body>
    <h3>Kalkulator</h3>
	<div class="main">
        <div class="container">
            <form method="post" id="form">
	            <div class="hasil">
                    <input class="isi" value="<?php echo getInputAsString($input);?>">
                    <input class="form-control" type="hidden" name="input" value='<?php echo json_encode($input);?>'/>
                </div>
                <div class="tabel">
                    <table>
                        <tr>
                            <td><input class="form-control" type="submit" name="c" value="C"/></td>
                            <td><input class="form-control" type="submit" name="back" value="D"/></td>
                            <td><input class="form-control" type="submit" name="divide" value="/"/></td>
                            <td><input class="form-control" type="submit" name="multiply" value="x"/></td>
                        </tr>
                        <tr>
                            <td><input class="form-control" type="submit" name="7" value="7"/></td>
                            <td><input class="form-control" type="submit" name="8" value="8"/></td>
                            <td><input class="form-control" type="submit" name="9" value="9"/></td>
                            <td><input class="form-control" type="submit" name="minus" value="-"/></td> 
                        </tr>
                        <tr>
                            <td><input class="form-control" type="submit" name="4" value="4"/></td>
                            <td><input class="form-control" type="submit" name="5" value="5"/></td>
                            <td><input class="form-control" type="submit" name="6" value="6"/></td>
                            <td><input class="form-control" type="submit" name="add" value="+"/></td>     
                        </tr>
                        <tr>
                            <td><input class="form-control" type="submit" name="1" value="1"/></td>
                            <td><input class="form-control" type="submit" name="2" value="2"/></td>
                            <td><input class="form-control" type="submit" name="3" value="3"/></td>
                            <td rowspan="0"><input class="form-control" type="submit" name="equal" value="="/></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="form-control" type="submit" name="zero" value="0"/></td>
                            <td><input class="form-control" type="submit" name="." value="."/></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</body>
</html>