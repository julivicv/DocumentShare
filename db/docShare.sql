CREATE SCHEMA IF NOT EXISTS `docShare` DEFAULT CHARACTER SET utf8 ;
USE `docShare` ;

DROP TABLE IF EXISTS `docShare`.`shared_documents` ;
DROP TABLE IF EXISTS `docShare`.`documents` ;
DROP TABLE IF EXISTS `docShare`.`users` ;

CREATE TABLE IF NOT EXISTS `docShare`.`users` (
                                            `id` INT AUTO_INCREMENT NOT NULL,
                                            `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `docShare`.`documents` (
                                                `id` INT NOT NULL,
                                                `users_id` INT NOT NULL,
                                                `file` BLOB NOT NULL,
  `description` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`, `users_id`),
  FOREIGN KEY (`users_id`)
  REFERENCES `docShare`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
  ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `docShare`.`shared_documents` (
                                                       `users_id` INT NOT NULL,
                                                       `documents_id` INT NOT NULL,
                                                       PRIMARY KEY (`users_id`, `documents_id`),
  FOREIGN KEY (`users_id`)
  REFERENCES `docShare`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  FOREIGN KEY (`documents_id`)
  REFERENCES `docShare`.`documents` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
  ENGINE = InnoDB;