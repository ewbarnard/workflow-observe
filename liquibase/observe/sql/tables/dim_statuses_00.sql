CREATE TABLE `dim_statuses`
(
    `id`                 int unsigned NOT NULL AUTO_INCREMENT,
    `status_name`        varchar(255) NOT NULL,
    `status_color`       varchar(50)  NOT NULL,
    `status_description` text,
    `created_at`         timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         timestamp    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `status_name` (`status_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
