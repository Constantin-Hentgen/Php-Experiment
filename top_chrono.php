<?php
    session_start();
    $_SESSION['tentatives'] = 0;
?>
<!DOCTYPE html>
<html>
    <?php
        include 'head.php';
        ?>
    <body>
    <p id="demo"></p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>


        <?php
           echo "<strong id='strong'>",$_SESSION['nombre_A'],' ',$_SESSION['operation'],' ',$_SESSION['nombre_B'],"</strong>";
            ?>
        <form id='form' action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="variable" name="variable" autofocus autocomplete="off"/>
        </form>

        <?php
            if ($_SESSION['operation'] === '+'){
                $result = $_SESSION['nombre_A']+$_SESSION['nombre_B'];
            }
            elseif($_SESSION['operation'] === '-'){
                $result = $_SESSION['nombre_A']-$_SESSION['nombre_B'];
            }
            elseif($_SESSION['operation'] === '×'){
                $result = $_SESSION['nombre_A']*$_SESSION['nombre_B'];
            }
            else{
                echo "<strong>erreur pour le calcul du résultat</strong>";
            }

            if (isset($_POST['variable'])){
                if ($_SESSION['counter'] === 2 && (int)$_POST['variable']===$result) 
                // prendre garde à ce que la condition de réussite soit remplie
                {
                    echo "<img id='fireworks' src='fireworks.gif'/>";
                    echo "
                    <script>
                    document.getElementById('strong').style.display = 'none';
                    document.getElementById('form').style.display = 'none';
                    document.getElementById('strong').style.color = '#282828';
                    </script>";
                    echo "<strong id='congrats'>Félicitations,<br>Tu as réussi ",$_SESSION['counter']+1,' calculs !',"</strong>";
                    header('Refresh:5;url=index.php');
                }
                elseif ((int)$_POST['variable']===$result)
                {
                    echo "
                    <strong id='answer'>",$_SESSION['nombre_A'],' ',$_SESSION['operation'],' ',$_SESSION['nombre_B'],' = ',$result,"</strong>
                    <img id='valide' src='valide.png'/>
                    <script>
                    document.getElementById('form').style.display = 'none';
                    document.getElementById('valide').style.display = 'flex';
                    document.getElementById('strong').style.display = 'none';
                    document.getElementById('answer').style.color = '#282828';
                    document.body.style.background = 'yellowgreen';
                    document.form.style.display = 'none';
                    </script>
                    ";
                    //echo "<strong id='strong'>",$_SESSION['nombre_A'],' ',$_SESSION['operation'],' ',$_SESSION['nombre_B'],"</strong>"," = ",$result;
                    $_SESSION['counter'] += 1;
                    $temp_A = random_int(1,10);
                    $temp_B = random_int(1,10);
                    while ($temp_A < $temp_B){
                        $temp_A = random_int(1,10);
                        $temp_B = random_int(1,10);
                    }
                    $_SESSION['nombre_A'] = $temp_A;
                    $_SESSION['nombre_B'] = $temp_B;
                    $dico = ['+','-','×'];
                    $dico_picker = random_int(0,2);
                    $_SESSION['operation'] = $dico[$dico_picker];
                    header("Refresh:1");
                }
                
                else
                {
                    echo "<strong id='cross'> ❌</strong>
                    <script>
                    document.getElementById('form').style.display = 'none';
                    document.getElementById('cross').style.display = 'flex';
                    document.getElementById('strong').style.display = 'none';
                    document.body.style.background = 'transparent';
                    document.form.style.display = 'none';
                    </script>
                    ";
                    header("Refresh:1;url=entrainement.php");
                }
            }
            //gestion générique en cas de problème
            ?>
    </body>
</html>