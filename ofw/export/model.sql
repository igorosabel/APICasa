/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

CREATE TABLE `tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada tag',
  `id_user` INT(11) NOT NULL COMMENT 'Id del usuario que crea la tag',
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Texto de la tag',
  `slug` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug del texto de la tag',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único de cada usuario',
  `email` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Email del usuario',
  `pass` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contraseña del usuario',
  `name` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del usuario',
  `color` VARCHAR(6) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Color que identifique al usuario',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `message_tag` (
  `id_message` INT(11) NOT NULL COMMENT 'Id del mensaje',
  `id_tag` INT(11) NOT NULL COMMENT 'Id de la tag',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_message`,`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `invite` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id unico de cada relacion',
  `from` INT(11) NOT NULL COMMENT 'Id del usuario que manda la invitacion',
  `to` INT(11) NOT NULL COMMENT 'Id del usuario al que se le manda la invitacion',
  `accepted` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si la invitacion se ha aceptado 1 o no 0',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `message` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id unico de cada mensaje',
  `id_user` INT(11) NOT NULL COMMENT 'Id del usuario que crea el mensaje',
  `body` TEXT COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contenido del mensaje',
  `type` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de mensaje 0 nota 1 tarea',
  `done` TINYINT(1) NOT NULL COMMENT 'En caso de ser una tarea indica si esta completada 1 o no 0',
  `is_private` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Indica si un mensaje es privado 1 o no 0',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `tag`
  ADD KEY `fk_tag_user_idx` (`id_user`),
  ADD CONSTRAINT `fk_tag_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `message_tag`
  ADD KEY `fk_message_tag_message_idx` (`id_message`),
  ADD KEY `fk_message_tag_tag_idx` (`id_tag`),
  ADD CONSTRAINT `fk_message_tag_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_tag_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `invite`
  ADD KEY `fk_invite_user_from_idx` (`from`),
  ADD KEY `fk_invite_user_to_idx` (`to`),
  ADD CONSTRAINT `fk_invite_user_from` FOREIGN KEY (`from`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_invite_user_to` FOREIGN KEY (`to`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `message`
  ADD KEY `fk_message_user_idx` (`id_user`),
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
