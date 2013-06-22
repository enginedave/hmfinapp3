



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

-- INSERT INTO `tbl_user` (`id`,`email`,`password`,`role`,`last_login_time`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES
-- ('','','','','','','','','');
-- INSERT INTO `tbl_account` (`id`,`user_id`,`name`,`type`,`balance`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES
-- ('','','','','','','','','');
-- INSERT INTO `tbl_payee` (`id`,`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES
-- ('','','','','','','');
-- INSERT INTO `tbl_transaction` (`id`,`date`,`acc_id`,`cat_id`,`pay_id`,`amount`,`reconciled`,`notes`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES
-- ('','','','','','','','','','','','');
-- INSERT INTO `tbl_category` (`id`,`user_id`,`name`,`create_time`,`create_user_id`,`update_time`,`update_user_id`) VALUES
-- ('','','','','','','');


