<?php
?>
<script>
    const authForm = document.getElementById("authorization_form");
    const regForm = document.getElementById("registration_form");
    const regSwitch = document.getElementById("reg_switch");
    const authSwitch = document.getElementById("auth_switch");
    function login() {
        document.getElementById("hide").style.display = "block";
        document.getElementById("window").style.display = "block";

    }
    function registration(){
        authForm.classList.add('hidden');
        regForm.classList.remove('hidden');
        regSwitch.hidden = true;
        authSwitch.hidden = false;
    }
    function loginForm(){
        regForm.classList.add('hidden');
        authForm.classList.remove('hidden');
        authSwitch.hidden = true;
        regSwitch.hidden = false;
    }
    function hideForms(){
        document.getElementById("hide").style.display = "none";
        document.getElementById("window").style.display = "none";
    }
</script>
