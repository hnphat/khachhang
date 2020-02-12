<?php
defined("ALLOW") or die("<p style='text-align: center;'><img src='image/khoa.jpg' alt='lock'/></p>");
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?php
            echo "<p><br/><span class='w3-text-gray'><a href='tin-tuc.html'> TIN TỨC TỔNG HỢP </a></span> > <span class='w3-text-black'>".$dataTopic[0]['topic_title']."</span></p>";
            echo "<div class=\"fb-share-button\" data-href=\"<?php echo $actual_link;?>\" data-layout=\"button\" data-size=\"large\"><a target=\"_blank\" href=\"https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse\" class=\"fb-xfbml-parse-ignore\">Chia sẻ</a></div>";
            echo "<h1 class='text-danger hyundai-boldfont'>".$dataTopic[0]['topic_title']."</h1>";
            echo "<p class='hyundai-arialfont w3-text-gray'><span class='fa fa-calendar-times-o'></span> <i>".$dataTopic[0]['topic_date']."</i></p>";
            echo "<p class='hyundai-arialfont'>".$dataTopic[0]['topic_content']."</p>";
            ?>
            <div class="fb-share-button" data-href="<?php echo $actual_link;?>" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
        </div>
        <div class="col-md-3">
            <?php
                include "aside_right.php";
            ?>
        </div>
    </div>
</div>

