CREATE SCHEMA IF NOT EXISTS `docShare` DEFAULT CHARACTER SET utf8;
USE `docShare`;
DROP TABLE IF EXISTS `docShare`.`shared_documents`;
DROP TABLE IF EXISTS `docShare`.`documents`;
DROP TABLE IF EXISTS `docShare`.`users`;
CREATE TABLE IF NOT EXISTS `docShare`.`users` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) UNIQUE NOT NULL,
  `password` VARCHAR(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `docShare`.`documents` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `users_id` INT NOT NULL,
  `path` VARCHAR(140) NOT NULL,
  `name` VARCHAR(140) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `users_id`),
  FOREIGN KEY (`users_id`) REFERENCES `docShare`.`users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
CREATE TABLE document_permissions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  documents_id INT,
  users_id INT,
  can_view TINYINT(1),
  can_edit TINYINT(1),
  can_delete TINYINT(1),
  FOREIGN KEY (documents_id) REFERENCES documents(id),
  FOREIGN KEY (users_id) REFERENCES users(id)
);