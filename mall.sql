create table activity
(
  activity_title    char(32)  null,
  activity_icon_url char(200) null,
  activity_type     int       null,
  activity_id       int auto_increment
    primary key
)
  charset = utf8;

create table address
(
  address_id int auto_increment
    primary key,
  name       text          null,
  mobile     tinytext      null,
  province   text          null,
  city       char(40)      null,
  area       char(40)      null,
  address    text          null,
  status     int default 0 null,
  user_id    int           null
)
  charset = utf8;

create table admin_user
(
  user_id     int auto_increment
    primary key,
  user_name   text                                    null,
  user_pass   text                                    null,
  user_token  text                                    null,
  create_time timestamp default CURRENT_TIMESTAMP     not null on update CURRENT_TIMESTAMP,
  update_time timestamp default '0000-00-00 00:00:00' not null,
  type        int       default 0                     null,
  type_name   text                                    null
)
  charset = utf8;

create table base_user
(
  user_name   char(20)                                null,
  password    text                                    null,
  user_id     int auto_increment
    primary key,
  email       text                                    null,
  mobile      text                                    null,
  token       char(32)                                null,
  valiCode    int(6)                                  null,
  create_time timestamp default CURRENT_TIMESTAMP     not null on update CURRENT_TIMESTAMP,
  update_time timestamp default '0000-00-00 00:00:00' not null
)
  charset = utf8;

create table cart
(
  product_id   int       null,
  cart_id      int auto_increment
    primary key,
  quantity     int       null,
  user_id      int       null,
  product_name char(200) null,
  sku          char(250) null,
  product_img  text      null,
  price        float     null
)
  charset = utf8;

create table home_banner
(
  banner_type int(10) default 0 null,
  banner_url  char(200)         null,
  banner_id   int auto_increment
    primary key,
  good_id     int               null
)
  charset = utf8;

create table message_sender
(
  user_id     int                                     not null
    primary key,
  mes_token   text                                    null,
  create_time timestamp default CURRENT_TIMESTAMP     not null on update CURRENT_TIMESTAMP,
  update_time timestamp default '0000-00-00 00:00:00' not null
)
  charset = utf8;

create table `order`
(
  order_id      char(16)                            not null
    primary key,
  create_time   timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
  status        text                                null,
  status_id     int                                 null,
  totalPayPirce float                               null
)
  charset = utf8;

create table order_address
(
  address_id int           not null,
  name       text          null,
  mobile     tinytext      null,
  province   text          null,
  city       char(40)      null,
  area       char(40)      null,
  address    text          null,
  status     int default 0 null,
  user_id    int           null,
  order_id   char(16)      not null
    primary key
)
  charset = utf8;

create table order_product
(
  product_title    char(20)        null,
  product_sub      char(100)       null,
  product_id       int             not null,
  `desc`           text            null,
  price            float default 0 null,
  strik_price      float default 0 null,
  stock            int   default 0 null,
  product_main_url text            null,
  order_id         char(16)        not null
)
  charset = utf8;

create table product
(
  product_title    char(20)        null,
  product_sub      char(100)       null,
  product_id       int auto_increment
    primary key,
  `desc`           text            null,
  price            float default 0 null,
  strik_price      float default 0 null,
  stock            int   default 0 null,
  product_main_url text            null
)
  charset = utf8;

create table sku
(
  sku_id   int(10) auto_increment
    primary key,
  sku_name tinytext null
)
  charset = utf8;

create table vali_code
(
  mobile     char(20)                                not null
    primary key,
  code       int(6)                                  null,
  valitype   int(2)                                  null,
  `update`   timestamp default CURRENT_TIMESTAMP     not null on update CURRENT_TIMESTAMP,
  creat_time timestamp default '0000-00-00 00:00:00' not null
)
  charset = utf8;
