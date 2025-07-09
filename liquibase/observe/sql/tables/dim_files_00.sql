CREATE TABLE `dim_files`
(
    `id`               int unsigned  NOT NULL AUTO_INCREMENT,
    `dim_directory_id` int unsigned  NOT NULL,
    `file_path`        varchar(255) NOT NULL,
    `file_size_bytes`  int unsigned  NOT NULL,
    `created_at`       timestamp     NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       timestamp     NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `file_path` (`file_path`),
    KEY `dim_directory_id` (`dim_directory_id`),
    CONSTRAINT `files_directory_fk` FOREIGN KEY (`dim_directory_id`) REFERENCES `dim_directories` (`id`)
)
