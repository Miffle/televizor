<?php ?>
<script>

    passwdDub.addEventListener("input", function () {
        if (passwd.value.trim() !== passwdDub.value.trim()) {
            document.getElementById("window").style.borderColor = "red";
        } else {
            document.getElementById("window").style.borderColor = "";
            regBtn.disabled = false;
        }
    })
</script>
