<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Chữ ký khách hàng</title>
  
  <link rel="stylesheet" href="css/signature-pad.css">
    <style>
        .btn-edit {
            padding: 10px 10px;
            background-color: goldenrod;
            color: black;
            font-weight: bold;
            font-size: 10pt;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.5s;
        }
        .btn-edit:hover {
            background-color: gold;
            color: white;
        }
        .btn-info {
            text-decoration: none;
            color: white;
            background-color: royalblue;
            border-radius: 5px;
            padding: 10px 10px;
            font-size: 10pt;
        }
        .btn-info:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body onselectstart="return false">
  <div id="signature-pad" class="signature-pad">
      <h1>Mời quý khách ký tên bên dưới để xác nhận đánh giá</h1>
    <div class="signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="signature-pad--footer">
      <div class="signature-pad--actions">
        <div style="display:none;">
          <button type="button" class="button clear" data-action="clear">Clear</button>
          <button type="button" class="button" data-action="change-color">Change color</button>
          <button type="button" class="button" data-action="undo">Undo</button>
        </div>
        <div>
          <button style="display:none;" type="button" class="button save" data-action="save-png">Lưu chữ ký</button>
          <button type="button" class="btn-info" id="saveToPHP" style="width: 100%;">Hoàn thành</button>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="../" class="btn-info" style="text-align:right;display: none;">Về trang chủ</a>
        </div>
      </div>
    </div>
  </div>
  <?php
    if(isset($_GET['num_car'])){
        $num_car = $_GET['num_car'];
        $date_car = $_GET['date'];
        echo "<script>number_car='".$num_car."';date_car='".$date_car."';</script>";
    }
  ?>
  <script src="js/signature_pad.umd.js"></script>
  <script src="js/app.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#saveToPHP").click(function(){
          var photo = signaturePad.toDataURL('image/png');                
          $.ajax({
            method: 'POST',
            url: 'script.php',
            data: {
              photo: photo,
              name: number_car,
              date_car: date_car
            }
          }).done(function() {
              window.open("../index.php?do=thank","_self");
          });
        });
      });
  </script>
</body>
</html>
