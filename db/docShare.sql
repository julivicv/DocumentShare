CREATE SCHEMA IF NOT EXISTS `docShare` DEFAULT CHARACTER SET utf8 ;
USE `docShare` ;


DROP TABLE IF EXISTS `docShare`.`users` ;

CREATE TABLE IF NOT EXISTS `docShare`.`users` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


DROP TABLE IF EXISTS `docShare`.`documents` ;

CREATE TABLE IF NOT EXISTS `docShare`.`documents` (
  `id` INT NOT NULL,
  `users_id` INT NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `description` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`, `users_id`),
  INDEX `fk_documentos_usuario_usuarios1_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_documentos_usuario_usuarios1`
    FOREIGN KEY (`users_id`)
    REFERENCES `docShare`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

DROP TABLE IF EXISTS `docShare`.`shared_documents` ;

CREATE TABLE IF NOT EXISTS `docShare`.`shared_documents` (
  `users_id` INT NOT NULL,
  `documents_id` INT NOT NULL,
  PRIMARY KEY (`users_id`, `documents_id`),
  INDEX `fk_compartilhamento_documentos_documentos_usuario1_idx` (`documents_id` ASC) VISIBLE,
  CONSTRAINT `fk_compartilhamento_documentos_usuarios`
    FOREIGN KEY (`users_id`)
    REFERENCES `docShare`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_compartilhamento_documentos_documentos_usuario1`
    FOREIGN KEY (`documents_id`)
    REFERENCES `docShare`.`documents` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
