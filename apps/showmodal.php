<div style="display:none;" id="modal_success" class="modal_local alert alert-success">
    <div class="modal-content" style="max-width: 500px; padding: 20px; margin:auto;">
        <p><strong>Success!</strong> <span id="txt_message"></span><span class="close">&times;</span></p>
    </div>
</div>
<div style="display:none;" id="modal_warning" class="modal_local alert alert-warning">
    <div class="modal-content" style="max-width: 500px; padding: 20px; margin:auto;">
        <p><strong>Warning!</strong> <span id="txt_message2"></span><span class="close">&times;</span></p>
    </div>
</div>
<div style="display:none;" id="modal_danger" class="modal_local alert alert-danger">
    <div class="modal-content" style="max-width: 500px; padding: 20px; margin:auto;">
        <p><strong>Danger!</strong> <span id="txt_message3"></span><span class="close">&times;</span></p>
    </div>
</div>

<div style="display:none;" id="modal_info" class="modal_local alert alert-info">
    <div class="modal-content" style="max-width: 500px; padding: 20px; margin:auto;">
        <p><strong>Info!</strong> <span id="txt_message4"></span><span class="close">&times;</span></p>
    </div>
</div>
<script>
    // Get the modal
    var modal_success = document.getElementById("modal_success");
    var modal_warning = document.getElementById("modal_warning");
    var modal_danger = document.getElementById("modal_danger");
    var modal_info = document.getElementById("modal_info");

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal_success) {
            modal_success.style.display = "none";
        }
        if (event.target == modal_warning) {
            modal_warning.style.display = "none";
        }
        if (event.target == modal_danger) {
            modal_danger.style.display = "none";
        }
        if (event.target == modal_info) {
            modal_info.style.display = "none";
        }
    }

    function showMessageSuccess(txt = "", link = "", timeout = 2000) {
        document.getElementById('txt_message').innerText = txt;
        modal_success.style.display = "block";
        setTimeout(function(){window.open(link,"_self");},timeout);
    }
    function showMessageWarning(txt = "", link = "", timeout = 2000) {
        document.getElementById('txt_message2').innerText = txt;
        modal_warning.style.display = "block";
        setTimeout(function(){window.open(link,"_self");},timeout);
    }
    function showMessageDanger(txt = "", link = "", timeout = 2000) {
        document.getElementById('txt_message3').innerText = txt;
        modal_danger.style.display = "block";
        setTimeout(function(){window.open(link,"_self");},timeout);
    }
    function showMessageInfo(txt = "", link = "", timeout = 2000) {
        document.getElementById('txt_message4').innerText = txt;
        modal_info.style.display = "block";
        setTimeout(function(){window.open(link,"_self");},timeout);
    }
</script>
