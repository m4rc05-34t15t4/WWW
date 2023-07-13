<?php

session_start();

if(((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)) OR !isset($_SESSION['codigo']) OR !isset($_SESSION['usuario']) OR 
    !isset($_SESSION['funcao']) ){
        unset ($_SESSION['login']);
        unset ($_SESSION['senha']);
        unset ($_SESSION['pagina']);
        unset ($_SESSION['codigo']);
        unset ($_SESSION['usuario']);
        unset ($_SESSION['funcao']);
        if($pagina != "Todos_mi.php"){
            header('location:Todos_mi.php');
        }
}
else{

    echo "session_cache_limiter:" . session_cache_limiter() . "<br>";
    echo "session_cache_expire:" . session_cache_expire() . "<br>";
    echo "session_status:" .  session_status() . "<br>";
    echo "session_gc_maxlifetime:" .  ini_get('session.gc_maxlifetime') . "<br>";
    echo "session.use_cookies:" . ini_get("session.use_cookies") . "<br>";
    echo date('h:i:s') . "<br>";
    //sleep for 3 seconds
    sleep(3);
    //start again
    echo date('h:i:s') . "<br>";
    echo "session_cache_expire:" . session_cache_expire() . "<br>";
    echo "session_status:" .  session_status() . "<br>";
    echo "session_gc_maxlifetime:" .  ini_get('session.gc_maxlifetime') . "<br>";

    header("Refresh:5");//recarrega em 5 segundos

}

?>