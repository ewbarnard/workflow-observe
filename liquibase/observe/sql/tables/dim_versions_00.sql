CREATE TABLE `dim_versions`
(
    `id`                  int unsigned NOT NULL AUTO_INCREMENT,
    `version_name`        varchar(255) NOT NULL,
    `version_description` text,
    `created_at`          timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
    `active_flag`         tinyint(1)        DEFAULT '1',
    `updated_at`          timestamp    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `version_name` (`version_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
