
CREATE DATABASE `hmfinapp3_dev`;
USE `hmfinapp3_dev`;



-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'tbl_user'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_user`;
		
CREATE TABLE `tbl_user` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `role` VARCHAR(100) NULL DEFAULT NULL COMMENT 'can be basic, premimum or admin',
  `last_login_time` DATETIME NULL DEFAULT NULL,
  `create_time` DATETIME NULL DEFAULT NULL,
  `create_user_id` INTEGER NULL DEFAULT NULL,
  `update_time` DATETIME NULL DEFAULT NULL,
  `update_user_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'tbl_account'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_account`;
		
CREATE TABLE `tbl_account` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `user_id` INTEGER NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `type` VARCHAR(100) NULL DEFAULT NULL,
  `balance` DECIMAL(10,2) NULL DEFAULT NULL,
  `create_time` DATETIME NULL DEFAULT NULL,
  `create_user_id` INTEGER NULL DEFAULT NULL,
  `update_time` DATETIME NULL DEFAULT NULL,
  `update_user_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'tbl_payee'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_payee`;
		
CREATE TABLE `tbl_payee` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `user_id` INTEGER NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `create_time` DATETIME NULL DEFAULT NULL,
  `create_user_id` INTEGER NULL DEFAULT NULL,
  `update_time` DATETIME NULL DEFAULT NULL,
  `update_user_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'tbl_transaction'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_transaction`;
		
CREATE TABLE `tbl_transaction` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `acc_id` INTEGER NULL DEFAULT NULL,
  `cat_id` INTEGER NULL DEFAULT NULL,
  `pay_id` INTEGER NULL DEFAULT NULL,
  `amount` DECIMAL(10,2) NULL DEFAULT NULL,
  `reconciled` bit NULL DEFAULT NULL,
  `notes` VARCHAR(256) NULL DEFAULT NULL,
  `create_time` DATETIME NULL DEFAULT NULL,
  `create_user_id` INTEGER NULL DEFAULT NULL,
  `update_time` DATETIME NULL DEFAULT NULL,
  `update_user_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'tbl_category'
-- 
-- ---

DROP TABLE IF EXISTS `tbl_category`;
		
CREATE TABLE `tbl_category` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `user_id` INTEGER NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `create_time` DATETIME NULL DEFAULT NULL,
  `create_user_id` INTEGER NULL DEFAULT NULL,
  `update_time` DATETIME NULL DEFAULT NULL,
  `update_user_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `tbl_account` ADD FOREIGN KEY (user_id) REFERENCES `tbl_user` (`id`);
ALTER TABLE `tbl_payee` ADD FOREIGN KEY (user_id) REFERENCES `tbl_user` (`id`);
ALTER TABLE `tbl_transaction` ADD FOREIGN KEY (acc_id) REFERENCES `tbl_account` (`id`);
ALTER TABLE `tbl_transaction` ADD FOREIGN KEY (cat_id) REFERENCES `tbl_category` (`id`);
ALTER TABLE `tbl_transaction` ADD FOREIGN KEY (pay_id) REFERENCES `tbl_payee` (`id`);
ALTER TABLE `tbl_category` ADD FOREIGN KEY (user_id) REFERENCES `tbl_user` (`id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `tbl_user` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `tbl_account` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `tbl_payee` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `tbl_transaction` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `tbl_category` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---


INSERT INTO `tbl_user` (`email`,`password`,`role`,`last_login_time`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('user1@test.com','user1','basic','','','','','');
INSERT INTO `tbl_user` (`email`,`password`,`role`,`last_login_time`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('user2@test.com','user2','premimum','','','','','');
INSERT INTO `tbl_user` (`email`,`password`,`role`,`last_login_time`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('user3@test.com','user3','admin','','','','','');
				
INSERT INTO `tbl_account` (`user_id`,`name`,`type`,`balance`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Santander','Current','1234.56','','','','');
INSERT INTO `tbl_account` (`user_id`,`name`,`type`,`balance`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Santander','Saving','789.56','','','','');
INSERT INTO `tbl_account` (`user_id`,`name`,`type`,`balance`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Nationwide','ISA','999.00','','','','');

INSERT INTO `tbl_payee` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Tesco','','','','');
INSERT INTO `tbl_payee` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Marks and Spencer','','','','');
INSERT INTO `tbl_payee` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Artie Grass','','','','');
INSERT INTO `tbl_payee` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Muff Service Station','','','','');

INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Food:Groceries','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Food:Dining Out','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','House:Grass Cutting','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','House:Accessories','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Car:Fuel','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('1','Charitable:Church','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','Food:Groceries','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','Food:Resturants','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','Car:Gas','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','House:Oil','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','House:Rates','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','House:Internet+Phone','','','','');
INSERT INTO `tbl_category` (`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2','House:Maintenance','','','','');

INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-02-15','1','1','1','56.20','','','','','','');
INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-02-17','1','2','2','156.20','','','','','','');
INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-02-19','1','3','3','546.20','','','','','','');
INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-02-22','2','4','4','6.20','','','','','','');
INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-02-10','2','1','2','576.20','','','','','','');
INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-02-02','2','2','2','26.20','','','','','','');
INSERT INTO `tbl_transaction` (`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES ('2013-03-25','2','2','1','16.20','','','','','','');























/**
 * Database schema required by CDbAuthManager.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @since 1.0
 */

drop table if exists `AuthAssignment`;
drop table if exists `AuthItemChild`;
drop table if exists `AuthItem`;

create table `AuthItem`
(
   `name`                 varchar(64) not null,
   `type`                 integer not null,
   `description`          text,
   `bizrule`              text,
   `data`                 text,
   primary key (`name`)
) engine InnoDB;

create table `AuthItemChild`
(
   `parent`               varchar(64) not null,
   `child`                varchar(64) not null,
   primary key (`parent`,`child`),
   foreign key (`parent`) references `AuthItem` (`name`) on delete cascade on update cascade,
   foreign key (`child`) references `AuthItem` (`name`) on delete cascade on update cascade
) engine InnoDB;

create table `AuthAssignment`
(
   `itemname`             varchar(64) not null,
   `userid`               varchar(64) not null,
   `bizrule`              text,
   `data`                 text,
   primary key (`itemname`,`userid`),
   foreign key (`itemname`) references `AuthItem` (`name`) on delete cascade on update cascade
) engine InnoDB;
