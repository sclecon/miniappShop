-- create config
CREATE TABLE IF NOT EXISTS `config` (
    `config_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
    `name` VARCHAR(255) NOT NULL COMMENT '配置名称',
    `intro` VARCHAR(255) NOT NULL COMMENT '配置说明',
    `uuid` CHAR(64) NOT NULL COMMENT '配置字段',
    `value` VARCHAR(255) DEFAULT NULL COMMENT '配置值',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`config_id`)
) comment='配置表';

ALTER TABLE `config` ADD `system` INT(1) NOT NULL DEFAULT '0' COMMENT '是否系统自带不允许删除' AFTER `value`;

-- create admin
CREATE TABLE IF NOT EXISTS `admin` (
    `admin_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
    `username` VARCHAR(32) NOT NULL COMMENT '管理员名称',
    `password` VARCHAR(32) NOT NULL COMMENT '管理员密码',
    `intro` VARCHAR(255) DEFAULT NULL COMMENT '管理员说明',
    `super` INT(1) DEFAULT 0 COMMENT '是否超级管理员',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`admin_id`)
) comment='管理员表';

-- create user
CREATE TABLE IF NOT EXISTS `user` (
    `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID',
    `avatar` CHAR(255) NOT NULL COMMENT '用户头像',
    `username` VARCHAR(32) NOT NULL COMMENT '用户名称',
    `password` VARCHAR(32) NOT NULL COMMENT '用户密码',
    `intro` VARCHAR(255) DEFAULT NULL COMMENT '用户说明',
    `openid` VARCHAR(40) NOT NULL COMMENT 'OPENID',
    `phone` CHAR(11) DEFAULT NULL COMMENT '手机号',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`user_id`)
) comment='用户表';

-- create send_code
CREATE TABLE IF NOT EXISTS `send_code` (
    `code_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '验证码ID',
    `user_id` INT(10) NOT NULL COMMENT '用户ID',
    `code` INT(6) NOT NULL COMMENT '验证码',
    `status` INT(1) DEFAULT 0 COMMENT '未验证',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`code_id`)
) comment='验证码表';

-- create painter
CREATE TABLE IF NOT EXISTS `painter` (
    `painter_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '画家ID',
    `avatar` CHAR(255) NOT NULL COMMENT '画家头像',
    `name` VARCHAR(32) NOT NULL COMMENT '画家名称',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`painter_id`)
) comment='画家表';

-- create auction
CREATE TABLE IF NOT EXISTS `auction` (
    `auction_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '拍品ID',
    `painter_id` INT(10) NOT NULL COMMENT '画家ID',
    `name` VARCHAR(255) NOT NULL COMMENT '作品名称',
    `intro` VARCHAR(32) NOT NULL COMMENT '作品描述',
    `specification` VARCHAR(32) NOT NULL COMMENT '作品规格',
    `start_price` FLOAT(10,2) NOT NULL COMMENT '起拍价格',
    `append_price` FLOAT(10,2) DEFAULT '0.01' COMMENT '最低加价',
    `buy_now_price` FLOAT(10,2) DEFAULT '0.00' COMMENT '一口价',
    `guaranteed_price` FLOAT(10,2) DEFAULT '0.00' COMMENT '保底价格',
    `status` INT(1) DEFAULT 0 COMMENT '拍卖状态 0=等待拍卖 1=拍卖中 2=拍卖成功 3=流拍',
    `start_time` INT(10) NOT NULL COMMENT '拍卖开始时间',
    `end_time` INT(10) NOT NULL COMMENT '拍卖结束时间',
    `boutique` INT(1) DEFAULT 0 COMMENT '是否精品',
    `get_user_id` INT(10) DEFAULT NULL COMMENT '拍卖成功用户UID',
    `commission` INT(3) DEFAULT 0 COMMENT '拍品佣金 百分比',
    `parcel` INT(1) DEFAULT 0 COMMENT '是否包邮',
    `join_number` INT(10) DEFAULT 0 COMMENT '竞拍参与次数',
    `views` INT(10) DEFAULT 0 COMMENT '浏览人数',
    `star` INT(10) DEFAULT 0 COMMENT '点赞人数',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`auction_id`)
) comment='拍品表';

-- create auction_images
CREATE TABLE IF NOT EXISTS `auction_images` (
    `images_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '图片ID',
    `auction_id` INT(10) NOT NULL COMMENT '拍品ID',
    `name` VARCHAR(255) NOT NULL COMMENT '图片名称',
    `intro` VARCHAR(255) NOT NULL COMMENT '图片描述',
    `url` CHAR(255) NOT NULL COMMENT '图片地址',
    `weight` INT(3) DEFAULT 0 COMMENT '图片权重排序',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
 PRIMARY KEY (`images_id`)
) comment='拍品图片表';

-- create auction_join
CREATE TABLE IF NOT EXISTS `auction_join` (
    `join_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '参与记录ID',
    `auction_id` INT(10) NOT NULL COMMENT '拍品ID',
    `avatar` CHAR(255) NOT NULL COMMENT '用户头像',
    `user_id` INT(10) NOT NULL COMMENT '用户ID',
    `join_price` FLOAT(10, 2) NOT NULL COMMENT '竞拍价格',
    `status` INT(1) DEFAULT 1 COMMENT '竞拍结果 1=等待最终结果敲定 0=竞拍失败 2=竞拍成功',
    `is_pay` INT(1) DEFAULT 0 COMMENT '是否支付 1=已支付 0=未支付',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`join_id`)
) comment='参与竞拍记录表';

-- create auction_topic
CREATE TABLE IF NOT EXISTS `auction_topic` (
    `topic_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '拍场ID',
    `name` VARCHAR(255) NOT NULL COMMENT '拍场名称',
    `image` CHAR(255) NOT NULL COMMENT '拍场宣传图',
    `start_time` INT(10) NOT NULL COMMENT '拍卖开始时间',
    `end_time` INT(10) NOT NULL COMMENT '拍卖结束时间',
    `status` INT(1) DEFAULT 0 COMMENT '拍卖状态 0=等待拍卖 1=拍卖中 2=已结束',
    `view` INT(10) DEFAULT 0 COMMENT '围观人数',
    `join_number` INT(10) DEFAULT 0 COMMENT '出价次数',
    `boutique` INT(1) DEFAULT 0 COMMENT '是否精品',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`topic_id`)
) comment='拍场表';

-- create auction_topic_access
CREATE TABLE IF NOT EXISTS `auction_topic_access` (
    `access_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '关系ID',
    `auction_id` INT(10) NOT NULL COMMENT '拍品ID',
    `topic_id` INT(10) NOT NULL COMMENT '拍场ID',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`access_id`)
) comment='拍场拍品关系表';

-- create shop_banner
CREATE TABLE IF NOT EXISTS `shop_banner` (
    `banner_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '轮播图ID',
    `url` CHAR(255) NOT NULL COMMENT '轮播图地址',
    `weight` INT(10) DEFAULT 0 COMMENT '轮播图权重',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`banner_id`)
) comment='市场轮播图';

-- create banner
CREATE TABLE IF NOT EXISTS `banner` (
    `banner_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '轮播图ID',
    `url` CHAR(255) NOT NULL COMMENT '轮播图地址',
    `weight` INT(10) DEFAULT 0 COMMENT '轮播图权重',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`banner_id`)
) comment='首页轮播图';

ALTER TABLE `painter` ADD `intro` VARCHAR(255) NOT NULL COMMENT '画家简介 个人说明' AFTER `name`;

INSERT INTO `config` (`config_id`, `name`, `intro`, `uuid`, `value`, `system`, `created_time`, `updated_time`, `deleted_time`) VALUES (NULL, '公众号APPID', '微信公众号的APPID', 'wx_appid', 'value', '0', NULL, NULL, NULL);

-- create banner
CREATE TABLE IF NOT EXISTS `announcement` (
    `announcement_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '公告ID',
    `title` VARCHAR(255) NOT NULL COMMENT '公告标题',
    `message` VARCHAR(255) DEFAULT NULL COMMENT '公告内容',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`announcement_id`)
) comment='公告数据表';