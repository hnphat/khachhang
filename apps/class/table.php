<?php
/**
 * This is a class used to create all table in database when browser load page.
 * User: HNP
 * Date: 10/07/2019
 * Time: 9:03 PM
 */

class Apps_Class_Table
{
    const table = [
        "CREATE TABLE tbl_user(
    user_id int AUTO_INCREMENT,
    user_name varchar(255) NOT NULL,
    user_fullname varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_permission int DEFAULT 2,
    user_active int DEFAULT 1,
    UNIQUE(user_name),
    PRIMARY KEY (user_id)
);",
        "CREATE TABLE tbl_item(
    item_id int AUTO_INCREMENT,
    item_name varchar(255) not null,
    item_link varchar(255),
    UNIQUE (item_name),
    PRIMARY KEY (item_id)
);",
        "CREATE TABLE tbl_upload(
    upload_id int AUTO_INCREMENT,
    upload_src varchar(255),
    upload_name varchar(255),
    upload_date varchar(255) not null,
    UNIQUE (upload_src),
    PRIMARY KEY (upload_id)
);",
        "CREATE TABLE tbl_subitem(
    subitem_id int AUTO_INCREMENT,
    subitem_name varchar(255) not null,
    item_id int not null,
    subitem_link varchar(255),
    UNIQUE (subitem_name),
    PRIMARY KEY (subitem_id),
    FOREIGN KEY (item_id) REFERENCES tbl_item(item_id)
);",
        "CREATE TABLE tbl_comment(
    comment_id int AUTO_INCREMENT,
    comment_date varchar(255) not null,
    comment_user varchar(255) not null,
    comment_topic int,
    comment_email varchar(255) not null,
    comment_content varchar(255) not null,
    comment_active int DEFAULT 0,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (comment_topic) REFERENCES tbl_topic(topic_id)
);",
        "CREATE TABLE tbl_subcomment(
    subcomment_id int AUTO_INCREMENT,
    subcomment_comment int,
    subcomment_date varchar(255) not null,
    subcomment_user varchar(255) not null,
    subcomment_email varchar(255) not null,
    subcomment_content varchar(255) not null,
    subcomment_active int DEFAULT 0,
    PRIMARY KEY (subcomment_id),
    FOREIGN KEY (subcomment_comment) REFERENCES tbl_comment(comment_id)
);",
        "INSERT INTO `tbl_user`(`user_id`, `user_name`, `user_fullname`, `user_password`, `user_permission`, `user_active`) VALUES ('1','admin','Administrator','e3ceb5881a0a1fdaad01296d7554868d',1,0);",
        "CREATE TABLE tbl_topic(
    topic_id int AUTO_INCREMENT,
    topic_date varchar(255),
    topic_title varchar(255),
    topic_src varchar(255),
    topic_desc text,
    topic_content text,
    topic_picture varchar(255),
    topic_active int DEFAULT 1,
    topic_view int,
    topic_showads int DEFAULT 0,
    UNIQUE (topic_src),
    PRIMARY KEY (topic_id),
    FOREIGN KEY (topic_picture) REFERENCES tbl_upload(upload_src)
);",
        "CREATE TABLE tbl_info(
    info_id int AUTO_INCREMENT,
    info_date varchar(255) not null,
    info_user varchar(255) not null,
    info_email varchar(255),
    info_address varchar(255),
    info_phone varchar(255),
    info_content varchar(255),
    info_type int,
    PRIMARY KEY (info_id)
);",
        "CREATE TABLE tbl_slide(
    slide_id int AUTO_INCREMENT,
    slide_name varchar(255),
    slide_image varchar(255),
    slide_link int,
    slide_pos int,
    PRIMARY KEY (slide_id),
    FOREIGN KEY (slide_link) REFERENCES tbl_topic(topic_id),
    FOREIGN KEY (slide_image) REFERENCES tbl_upload(upload_src)
);",
        "CREATE TABLE tbl_list_service(
    service_id int AUTO_INCREMENT,
    service_name varchar(255) not null,
    PRIMARY KEY (service_id)
);",
        "CREATE TABLE tbl_question(
    question_id int AUTO_INCREMENT,
    question_content varchar(255) not null,
    question_type int not null,
    question_user int not null,
    PRIMARY KEY (question_id),
    FOREIGN KEY (question_user) REFERENCES tbl_user(user_id),
    FOREIGN KEY (question_type) REFERENCES tbl_list_service(service_id)
);",
        "CREATE TABLE tbl_guest(
    guest_id int AUTO_INCREMENT,
    guest_date varchar(255) not null,
    guest_name varchar(255) not null,
    guest_phone varchar(255),
    guest_number_car varchar(255) not null,
    guest_model varchar(255),
    guest_sale varchar(255),
    guest_comment varchar(255),
    guest_type int not null,
    guest_user_create int not null,
    guest_have_image int DEFAULT 0,
    guest_cost int DEFAULT 0,
    vote_c1 int DEFAULT 0,
    vote_c2 int DEFAULT 0,
    vote_c3 int DEFAULT 0,
    vote_c4 int DEFAULT 0,
    vote_c5 int DEFAULT 0,
    vote_comment varchar(255),
    vote_kinhdoanh int DEFAULT 0,
    PRIMARY KEY (guest_id),
    FOREIGN KEY (guest_user_create) REFERENCES tbl_user(user_id),
    FOREIGN KEY (guest_type) REFERENCES tbl_list_service(service_id)
);",
        "CREATE TABLE tbl_vote(
    vote_guest int not null,
    vote_question int not null,
    vote_point int,
    vote_type int not null,
    PRIMARY KEY (vote_guest,vote_question),
    FOREIGN KEY (vote_guest) REFERENCES tbl_guest(guest_id),
    FOREIGN KEY (vote_question) REFERENCES tbl_question(question_id),
    FOREIGN KEY (vote_type) REFERENCES tbl_list_service(service_id)
);",
        "INSERT INTO `tbl_list_service`(`service_id`, `service_name`) VALUES ('1','Kinh doanh');",
        "CREATE TABLE tbl_picture(
    picture_id int AUTO_INCREMENT,
    picture_guest int not null,
    picture_src varchar(255) not null,
    PRIMARY KEY (picture_id),
    FOREIGN KEY (picture_guest) REFERENCES tbl_guest(guest_id)
);",
        "CREATE TABLE tbl_event(
    event_id int AUTO_INCREMENT,
    event_set int DEFAULT 0,
    PRIMARY KEY (event_id)
);"
    ];
}

//TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP