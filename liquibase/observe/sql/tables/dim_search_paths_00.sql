CREATE TABLE `dim_search_paths`
(
    `id`                       int unsigned NOT NULL AUTO_INCREMENT,
    `search_path`              varchar(255) NOT NULL,
    `directory_search_command` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `is_active`                tinyint(1)   NOT NULL                                          DEFAULT '1',
    `created_at`               timestamp    NULL                                              DEFAULT CURRENT_TIMESTAMP,
    `updated_at`               timestamp    NULL                                              DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unq_search_path` (`search_path`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
