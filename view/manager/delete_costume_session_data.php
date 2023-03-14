<?php
    session_start();
    $_SESSION["costumeIDArrayCount"] = 0;
    $_SESSION["costumeIDArray"] = array();
    $_SESSION["costumeNameArray"] = array();
    ?><script>
    window.location.href = '<?php echo $_POST["home_url"]; ?>';
    </script><?php  
?>