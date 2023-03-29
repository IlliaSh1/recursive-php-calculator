<?php 
  session_start();
  if( !isset($_SESSION['history']) ) {
    $_SESSION['iteration']=0;
    $_SESSION['history']=array();
  }
  $_SESSION['iteration']+=1;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 4</title>
  <link rel="stylesheet" href="src/css/normalize.css">
  <link rel="stylesheet" href="src/css/style.css">
</head>
<body class="body">
  <div class="body__wrapper">

    <header class="header">
      <div class="wrapper header__container">
        <img src="src/img/logo.svg" alt="mospolytech logo" width="300">
        <h1 class="title">1.2 Solve the equation</h1>
        <nav class="header__menu">
          <ul class="header__menu-list list">
            <li class="header__menu-item"><a href="" class="link"></a></li>
          </ul>
        </nav>
      </div>
    </header>
    <main class="main main--theme-dark">
      <section class="calc-sect">
        
        <div class="wrapper wrapper--vert calc-sect__container">
          <!-- .calc>.calc__container>.calc__screen+.calc__btns>.calc__btn -->
          
          <form action="" method="post" class="calc calc--theme-gradient">
            
            <div class="calc__container">
              <div class="calc__screen calc__screen--theme-gradient">
                <!-- <div class="calc__head">4+_+adsfsadfsadfasdfasdfadsf</div> -->
                <input class="input calc__res" type="text" name="val" id="" placeholder="0">
              </div>

              <button type="reset" class="btn calc__btn calc__btn--theme-gradient" value="AC">AC</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="(">(</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value=")">)</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="/">÷</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="7">7</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="8">8</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="9">9</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="*">×</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="4">4</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="5">5</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="6">6</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient calc__btn--big" value="-">-</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="1"> 1</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="2"> 2</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="3"> 3</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient calc__btn--span-2" value="+">+</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="0">0</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient calc__btn--big" value=".">•</button>
              <button type="submit" class="btn calc__btn calc__btn--theme-gradient calc__btn--big" value="">=</button>
              
              <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
            </div>
          </form>

          <!-- CALC -->
          <?php
              include('trigonom.php');

              function isnegative($x) {
                $x = strval($x);
                
                if(strlen($x)==0)
                  return false;

                if($x[0] != '-') 
                  return false;
                
                return true;
              }

            function isnum($x) {
              // echo "isnum - ".$x."<br>";
              $x = strval($x);
              if(strlen($x)==0)
                return false;
              
              $i=0;
              $flag_point = false;
              if(isnegative($x)) {
                if(strlen($x)==1)
                return false;
                $i++;
              }
              
              
              for($i;$i<strlen($x);$i++) {
                if($x[$i] == '.') {
                  if(!$flag_point) 
                    $flag_point = true;
                  else 
                    return false;
                }
                
                if(!(($x[$i]>='0' && $x[$i]<='9') || $x[$i]=='.')) 
                  return false;
              }
              return true;
            }

            function ispref($x) {
              $x = strval($x);
              if(strlen($x)==0)
                return false;
              
              $i=0;
              $flag_point = false;
              if(isnegative($x)) {
                if(strlen($x)==1)
                return false;
                $i++;
              }
              
              
              for($i;$i<strlen($x);$i++) {
                
                if(!($x[$i]>='a' && $x[$i]<='z')) {
                  if(isnum(substr($x,$i,strlen($x)-$i)))
                    return true;
                  else 
                    return false;
                }
              }
              return false;
            }

            function get_pref_val($x) {
              $x = strval($x);

              $i=0;
              $flag_point = false;
              if(isnegative($x)) {
                if(strlen($x)==1)
                return false;
                $i++;
              }
              
              
              for($i;$i<strlen($x);$i++) {
                
                if(!($x[$i]>='a' && $x[$i]<='z')) {
                  return [substr($x,0,$i), substr($x,$i,strlen($x)-$i)];
                }
              }
              return ['',''];
            }
            
            function addZero($s) {
              // echo '<i>'.$s.'</i>';
              $s=strval($s);
              if($s[0]!='-') 
                return "0+".$s;
              else 
                return "0".$s;
            }

            function bktValid($val) {
              $bal = 0;
              for($i=0;$i<strlen($val);$i++) {
                if($val[$i]=='(')
                  $bal++;
                else if ($val[$i]==')') {
                  $bal--;
                  if($bal<0) 
                    return false;
                }
              }
              if($bal!=0) 
                return false;
              return true;
            }

            function explodeMinus($s) { // Исключаем случаи, когда '-'
              $s = strval($s); //стоит внутри умножаемых/делимых значений
              $flag_exception = false;
              $res = [];
              $sub_s = "";
              for($i=0;$i<strlen($s);$i++) {
                
                if($s[$i] == '-' && !$flag_exception) {
                  $res[] = $sub_s;
                  $sub_s = "";
                  
                } else {
                  $flag_exception = false;
                  $sub_s.=$s[$i];
                  if(!($s[$i] >= '0' && $s[$i] <= '9')) {
                    $flag_exception = true;
                  }
                }
              }
              $res[] = $sub_s;
              return $res;
            }
            
            function formatCalc($s) { // форматирование входной строки
              $s = strval($s);
              $new_s = "";
              for($i=0;$i<strlen($s); $i++) {
                switch($s[$i]) {
                  case(' ');
                  break;

                  case(':'); 
                  $new_s .= $s[$i];
                  break;
                  
                  default: 
                    $new_s .= $s[$i];
                }  
              }
              //  Замена num(num2) на num*(num2)
              for($i='0';$i<='9';$i++) {
                $new_s=str_replace($i."(", $i.'*(',$new_s);
              }
              return $new_s;
              
            }

            function calc($val) {
              echo "|".$val."|<br>";
              $val = strval($val);
              if(strlen($val)==0) 
                return "Выражение не задано!";

              if( isnum($val)) {
                  return $val;
              }

              if(ispref($val)) {
                $separated = get_pref_val($val);
                $res = calcTrigonom($separated[0], $separated[1]);
                if(isnum($res)) 
                  return $res;
                else
                  return "Ошибка в триномоетрической функции!";
              }

              $res=0;
              $args = explode('+',$val);

              if(count($args)>1) {
                
                $res = 0;
                for($i=0;$i<count($args);$i++) {
                  $res_i = calc($args[$i]); 
                  if(isnum($res_i)) 
                    $res += $res_i;
                  else
                    return $res_i;
                }

                return $res;
                
              }
              /// Исключение для -num/num1*num2 при вычислении
              if($val[0]=='-' && $val!='-' && substr_count($val, '-') == 1) {
                $res_i = calc(substr($val, 1, strlen($val)-1));
                if(isnum($res_i))
                  $res -= $res_i;
                else 
                  return $res_i;
                
                  return $res;
              }

              
              $args = explodeMinus($val);
              if(count($args)>1) {
                  $res = 0;
                  

                  for($i=0;$i<count($args);$i++) {
                    $res_i = calc($args[$i]);
                    if(isnum($res_i)) 
                      if($i==0)
                        $res = $res_i;
                      else
                        $res -= $res_i;
                    else
                      return $res_i;
                  }


                  return $res;
              } 


              $args = explode('*',$val);
              if(count($args)>1) {
                
                $res = 1;
                
                for($i=0;$i<count($args);$i++) {
                  $res_i = calc($args[$i]); 
                  
                  if(isnum($res_i)) 
                    $res *= $res_i;
                  else
                    return $res_i;
                }

                return $res;
              }

              $args = explode('/',$val);
              if(count($args)>1) {
                
                $res = calc($args[0]);
                if(!isnum($res)) 
                  return $res;

                for($i=1;$i<count($args);$i++) {
                  $res_i = calc($args[$i]); 

                  if($res_i==0) {
                    return "Деление на ноль";
                  }
                  if(isnum($res_i)) 
                    $res /= $res_i;
                  else
                    return $res_i;
                }
                return $res;
              }

              if(isnum($val)) 
                return $val;
              else 
                return 'Неправильный формат числа';
            }

            function calcBkt($val) { // Сначала раскрываем скобки
              echo $val." ] ";
              $val = strval($val);
              if(strlen($val)==0) 
                return "Выражение не задано!";
              
              if(!bktValid($val)) {
                return "Неправильный формат скобок";
              }

              $beg = strpos($val, "(");
              if($val[0]!='(')
              if (!$beg) {
                return calc(addZero($val));
              } 
              $en = 0;
              $bal = 1;
              
              for($i=$beg+1;$bal!=0;$i++) {
                if($val[$i]=='(')
                  $bal++;
                else if ($val[$i]==')')
                  $bal--;
                  if($bal==0)
                    $en=$i;
              }
              
              echo "|bkt+zero ".addZero(substr($val, $beg+1, $en-$beg-1));
              
              $new_val = calcBkt(addZero(substr($val, $beg+1, $en-$beg-1)));
              $new_val = strval($new_val);
              if(!isnum($new_val))
                return $new_val;
              echo "new =".$new_val."<br>";

              // Учитываем "-" в новом значении

              if($val[$beg-1]=='-' && $new_val[0]=='-') {
                  // replace "- - " to "+"
                  $val = calcBkt(substr($val, 0, $beg-1)."+".
                  substr($new_val, 1, strlen($new_val)-1).
                  substr($val, $en+1, strlen($val)-$en));
              
              } else if ($val[$beg-1]=='+' && $new_val[0]=='-') {
                  // replace "+ - " to "-"
                  echo "var2 ";
                  // echo "<br>P ".substr($val, 0, $beg-1).$new_val.substr($val, $en+1, strlen($val)-$en);
                  $val = calcBkt(substr($val, 0, $beg-1).$new_val.substr($val, $en+1, strlen($val)-$en)); 
                  
              } else {
                // not replace
                echo "var3 ";
                // echo "<br>Pa ".substr($val, 0, $beg).$new_val.substr($val, $en+1, strlen($val)-$en);
                $val = calcBkt(substr($val, 0, $beg).$new_val.substr($val, $en+1, strlen($val)-$en)); 
              }
              
              
               echo "<br>a ".$val;
              return $val;
            }


            function calculator($val) {
              $val = strval($val);

              $val = formatCalc($val);
              if(strlen($val)==0)
                return "Пустое выражение!";
              $val = addZero($val);
              
              
              $res = calcBkt($val);
              return $res;
            }
            


            ?>
          <!-- HISTORY -->
          <div class="calc-history">
            <div class="calc-history__container">

                <?php
              if(isset($_POST['val'])) {
                
                $res = calculator($_POST['val']);
                  if(isnum($res)) 
                    echo "Результат вычисления: ".$res."<br>";
                  else 
                    echo 'Ошибка вычисления: '.$res."<br>";
                }

              if(isset($_POST['iteration']))
              if($_POST['val'] && $_POST['iteration']+1==$_SESSION['iteration']) 
                $_SESSION['history'][] = $_POST['val'].' = '.$res;
              
                for($i=count($_SESSION['history'])-2;$i>=0; $i--) 
                echo strval($i+1).". ".$_SESSION['history'][$i].'<br>';
                ?>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php 
      $test_ans = [
        "1", "1",
        "1+1", "2",
        "(-7)*2-1", "-15",
        "((-5)*-2)-(-2-2)", "14",
        "-1--1", "0",
        "((-5)*2)-0.02", "-10.02",
        "(-7)*(-17)/17", "7",
        "(7*5)-(5+5)", "25",
        "(-7)*(-2-15)/17-1-(-1-(-1))", "6",
        "3*sin(60)-1-1*tan-30", "2.1754264805429",
      ];

      for ($i=0;$i<count($test_ans);$i+=2) {
        echo "<br><b>";
        echo $test_ans[$i]." ans ".$test_ans[$i+1];
        echo "<br></b>";
        if($test_ans[$i+1]==calcBkt(addZero($test_ans[$i]))) {
          echo "<b>"."Ok"."</b>";
        } else {
          echo '<b style="color:red">'."Expression:".$test_ans[$i]."<br>Not:".calcBkt(addZero($test_ans[$i]))."<br>"."correct:".$test_ans[$i+1]."</b>";
        }
        echo "<br>";
      }

      echo file_get_contents('task/expression.txt');
    ?>
    <footer class="footer">
      <div class="wrapper footer__container">
        <p>
          Шамаров Илья Глебович, 221-321
        </p>
      </div>
      
    </footer>
  
  </div>
  <script src="src/js/calc.js"></script>
  
</body>
</html>