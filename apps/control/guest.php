<?php

/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 18/10/2019
 * Time: 11:19 AM
 */
class Apps_Control_Guest extends Apps_Class_Database
{
    protected $tableName = "tbl_guest";
    protected $column = [
        "guest_id" => "",
        "guest_date" => "",
        "guest_name" => "",
        "guest_phone" => "",
        "guest_number_car" => "",
        "guest_model" => "",
        "guest_sale" => "",
        "guest_comment" => "",
        "guest_type" => "",
        "guest_user_create" => "",
        "guest_have_image" => "",
        "guest_cost" => "",
        "vote_c1" => "", // Chu so huu hay quan ly xe
        "vote_c2" => "", // thuong su dung va theo doi theo nguon nao
        "vote_c3" => "", // mong muon cua quy khach
        "vote_c4" => "", // nhan duoc gi khi gioi thieu
        "vote_c5" => "", // giam sat sua xe tai camera phong cho
        "vote_comment" => "",
        "vote_kinhdoanh" => "" // Co duoc moi lai thu khong
    ];
}
?>