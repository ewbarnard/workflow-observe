CREATE TABLE `dim_directories`
(
    `id`                 int unsigned  NOT NULL AUTO_INCREMENT,
    `directory_path`     varchar(255) NOT NULL,
    `creation_timestamp` timestamp     NULL DEFAULT NULL,
    `dim_search_path_id` int unsigned  NOT NULL,
    `created_at`         timestamp     NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         timestamp     NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `directory_path` (`directory_path`),
    KEY `dim_search_path_id` (`dim_search_path_id`),
    CONSTRAINT `directories_search_path_fk` FOREIGN KEY (`dim_search_path_id`) REFERENCES `dim_search_paths` (`id`)
)
