CREATE TABLE `dim_stages`
(
    `id`                int unsigned NOT NULL AUTO_INCREMENT,
    `stage_name`        varchar(255) NOT NULL,
    `stage_order`       int          NOT NULL,
    `stage_description` text,
    `active_flag`       tinyint(1)        DEFAULT '1',
    `created_at`        timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        timestamp    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `stage_name` (`stage_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
