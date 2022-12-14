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
    `delay` INT(10) DEFAULT 0 COMMENT '延时时间',
    `postage` INT(1) DEFAULT 0 COMMENT '是否包邮',
    `status` INT(1) DEFAULT 0 COMMENT '拍卖状态 0=等待拍卖 1=拍卖中 2=拍卖成功 3=流拍',
    `start_time` INT(10) NOT NULL COMMENT '拍卖开始时间',
    `end_time` INT(10) NOT NULL COMMENT '拍卖结束时间',
    `boutique` INT(1) DEFAULT 0 COMMENT '是否精品',
    `gallery` INT(1) DEFAULT 0 COMMENT '加入画廊',
    `get_user_id` INT(10) DEFAULT NULL COMMENT '拍卖成功用户UID',
    `commission` INT(3) DEFAULT 0 COMMENT '拍品佣金 百分比',
    `parcel` INT(1) DEFAULT 0 COMMENT '是否包邮',
    `join_number` INT(10) DEFAULT 0 COMMENT '竞拍参与次数',
    `views` INT(10) DEFAULT 0 COMMENT '浏览人数',
    `star` INT(10) DEFAULT 0 COMMENT '点赞人数',
    `share` INT(10) DEFAULT 0 COMMENT '分享次数',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`auction_id`)
    ) comment='拍品表';

-- create auction_like
CREATE TABLE IF NOT EXISTS `auction_like` (
    `like_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '记录ID',
    `auction_id` INT(10) NOT NULL COMMENT '拍品ID',
    `user_id` INT(10) NOT NULL COMMENT '用户UID',
    `username` VARCHAR(255) NOT NULL COMMENT '用户名',
    `avatar` CHAR(255) NOT NULL COMMENT '用户头像',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`like_id`)
    ) comment='拍品点赞表';

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
    `sign_up_number` INT(10) DEFAULT 0 COMMENT '报名人数',
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

-- create shop_category
CREATE TABLE IF NOT EXISTS `shop_category` (
    `category_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID',
    `name` VARCHAR(255) NOT NULL COMMENT '分类名称',
    `intro` VARCHAR(255) DEFAULT NULL COMMENT '分类说明',
    `image` CHAR(255) NOT NULL COMMENT '分类图标图片',
    `options` TEXT NOT NULL COMMENT '分类商品需要的属性 JSON',
    `weight` INT(10) DEFAULT 0 COMMENT '分类权重',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`category_id`)
    ) comment='商品分类表';

-- create shop
CREATE TABLE IF NOT EXISTS `shop` (
    `shop_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品ID',
    `category_id` INT(10) UNSIGNED NOT NULL COMMENT '分类ID',
    `name` VARCHAR(255) NOT NULL COMMENT '商品名称',
    `intro` VARCHAR(255) DEFAULT NULL COMMENT '商品说明',
    `price` FLOAT(10, 2) NOT NULL COMMENT '商品价格',
    `weight` INT(10) DEFAULT 0 COMMENT '商品权重',
    `options` TEXT DEFAULT NULL COMMENT '商品属性',
    `message` TEXT DEFAULT NULL COMMENT '商品详情 富文本',
    `recommend` INT(1) DEFAULT 0 COMMENT '是否推荐',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`shop_id`)
    ) comment='商品表';

-- create shop_image
CREATE TABLE IF NOT EXISTS `shop_image` (
    `image_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品ID',
    `shop_id` INT(10) UNSIGNED NOT NULL COMMENT '商品ID',
    `url` VARCHAR(255) NOT NULL COMMENT '主图图片',
    `weight` INT(10) DEFAULT 0 COMMENT '主图权重',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`image_id`)
    ) comment='商品主图表';

CREATE TABLE `shop`.`user_address` (`address_id` INT NOT NULL AUTO_INCREMENT COMMENT '地址ID' , `user_id` INT NOT NULL COMMENT '用户ID' , `default` INT NOT NULL DEFAULT '0' COMMENT '是否为默认' , `name` VARCHAR(32) NOT NULL COMMENT '收件人姓名' , `province` VARCHAR(32) NOT NULL COMMENT '省' , `city` VARCHAR(32) NOT NULL COMMENT '市' , `area` VARCHAR(32) NOT NULL COMMENT '区' , `detail` VARCHAR(255) NOT NULL COMMENT '详细地址' , `phone` CHAR(11) NOT NULL COMMENT '联系电话' , `created_time` INT NOT NULL COMMENT '添加时间' , `updated_time` INT NOT NULL COMMENT '修改时间' , `deleted_time` INT NOT NULL COMMENT '删除时间' , PRIMARY KEY (`address_id`)) ENGINE = InnoDB;


CREATE TABLE `shop`.`shop_order` (`order_id` INT NOT NULL AUTO_INCREMENT COMMENT '订单自增ID' , `user_id` INT NOT NULL COMMENT '用户UID' , `shop_id` INT NOT NULL COMMENT '商品ID' , `username` VARCHAR(255) NOT NULL COMMENT '用户名称' , `shop_name` VARCHAR(255) NOT NULL COMMENT '商品名称' , `order_number` CHAR(20) NOT NULL COMMENT '订单号' , `shop_price` FLOAT(10,2) NOT NULL COMMENT '商品价格' , `buy_number` INT NOT NULL DEFAULT '1' COMMENT '购买数量' , `total_price` FLOAT(10,2) NOT NULL COMMENT '订单金额' , `payed` INT NOT NULL DEFAULT '1' COMMENT '支付状态 1=待支付 0=已关闭 2=已支付' , `sended` INT NOT NULL DEFAULT '0' COMMENT '发货状态 0=未发货 1=已发货' , `status` INT NOT NULL DEFAULT '1' COMMENT '支付状态 1=等待支付 0=订单已关闭 2=等待发货 3=已经发货 4=订单完成' , `send_code` CHAR(255) NULL DEFAULT NULL COMMENT '发货详情' , `submited_time` INT NULL DEFAULT NULL COMMENT '下单时间' , `payed_time` INT NULL DEFAULT NULL COMMENT '支付时间' , `sended_time` INT NULL DEFAULT NULL COMMENT '发货时间' , `created_time` INT NULL DEFAULT NULL COMMENT '创建时间' , `updated_time` INT NULL DEFAULT NULL COMMENT '修改时间' , `deleted_time` INT NULL DEFAULT NULL COMMENT '删除时间' , PRIMARY KEY (`order_id`)) ENGINE = InnoDB;

ALTER TABLE `user` ADD `deposit` FLOAT(10,2) NOT NULL COMMENT '保证金' AFTER `phone`;
ALTER TABLE `user` CHANGE `deposit` `deposit` FLOAT(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金';
ALTER TABLE `user` ADD `freeze_deposit` FLOAT(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额' AFTER `deposit`;


-- create user_deposit
CREATE TABLE IF NOT EXISTS `user_deposit` (
    `deposit_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '记录ID',
    `user_id` INT(10) UNSIGNED NOT NULL COMMENT '用户ID',
    `amount` FLOAT(10,2) NOT NULL COMMENT '变动金额',
    `type` INT(1) DEFAULT 1 COMMENT '押金变动类型 1=充值 2=冻结 3=解除冻结 4=提现',
    `params` text DEFAULT NULL COMMENT '变动相关凭证',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`deposit_id`)
) comment='押金变动表';

-- create user_pay
CREATE TABLE IF NOT EXISTS `user_pay` (
    `pay_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '支付ID',
    `user_id` INT(10) UNSIGNED NOT NULL COMMENT '用户ID',
    `amount` FLOAT(10,2) NOT NULL COMMENT '支付金额',
    `status` INT(1) DEFAULT 1 COMMENT '支付状态 1=等待支付 2=支付成功',
    `type` CHAR(255) NOT NULL COMMENT '关联支付类型',
    `order_id` CHAR(255) NOT NULL COMMENT '关联订单ID',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`pay_id`)
) comment='系统用户支付记录表';


-- create auction_order
CREATE TABLE IF NOT EXISTS `auction_order` (
    `order_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单ID',
    `order_number` CHAR(32) NOT NULL COMMENT '订单号',
    `user_id` INT(10) UNSIGNED NOT NULL COMMENT '用户ID',
    `auction_id` INT(10) UNSIGNED NOT NULL COMMENT '拍品ID',
    `amount` FLOAT(10,2) NOT NULL COMMENT '拍品支付金额',
    `status` INT(1) DEFAULT 1 COMMENT '支付状态 1=等待支付 2=支付成功 3=订单关闭',
    `send_id` CHAR(255) NOT NULL COMMENT '发货快递ID',
    `created_time` INT(10) DEFAULT NULL COMMENT '创建时间',
    `updated_time` INT(10) DEFAULT NULL COMMENT '修改时间',
    `deleted_time` INT(10) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`order_id`)
) comment='拍品订单表';

CREATE TABLE `shop`.`phone_msg` (`msg` INT NOT NULL AUTO_INCREMENT , `phone` CHAR(11) NOT NULL COMMENT '手机号' , `code` INT NOT NULL COMMENT '验证码' , `verify` INT NOT NULL DEFAULT '0' COMMENT '是否已验证' , `created_time` INT NULL DEFAULT NULL COMMENT '创建时间' , `updated_time` INT NULL DEFAULT NULL COMMENT '修改时间' , `deleted_time` INT NULL DEFAULT NULL COMMENT '删除时间' , PRIMARY KEY (`msg`)) ENGINE = InnoDB COMMENT = '手机验证码表';


