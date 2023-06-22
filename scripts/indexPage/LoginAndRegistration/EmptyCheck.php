<?php
?>
<script>
    regLogin.addEventListener("input", function () {
        RegEmptyCheck()
    })
    regEmail.addEventListener("input", function () {
        RegEmptyCheck()
    })
    passwd.addEventListener("input", function () {
        RegEmptyCheck()
    })
    logLogin.addEventListener("input", function () {
        LogEmptyCheck()
    })
    logPassword.addEventListener("input", function () {
        LogEmptyCheck()
    })

    function RegEmptyCheck() {

        if (passwd.value.trim() === "" || regLogin.value.trim() === "" ||
            regEmail.value.trim() === "") {
            document.getElementById("window").style.borderColor = "red";
            regBtn.disabled = true;
        } else {
            document.getElementById("window").style.borderColor = "";
            regBtn.disabled = false;
        }
    }

    function LogEmptyCheck() {
        if (logLogin.value.trim() === "" || logPassword.value.trim() === "") {
            document.getElementById("window").style.borderColor = "red";
            logBtn.disabled = true;
        } else {
            document.getElementById("window").style.borderColor = "";
            logBtn.disabled = false;
        }
    }

</script>
