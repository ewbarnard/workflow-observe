CREATE TABLE `dim_batches`
(
    `id`               int unsigned NOT NULL AUTO_INCREMENT,
    `batch_name`       varchar(255) NOT NULL,
    `dim_directory_id` int unsigned NOT NULL,
    `total_bytes`      int unsigned NOT NULL DEFAULT '0',
    `file_count`       int unsigned NOT NULL DEFAULT '0',
    `created_at`       timestamp    NULL     DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       timestamp    NULL     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `batch_name` (`batch_name`),
    KEY `dim_directory_id` (`dim_directory_id`),
    CONSTRAINT `batches_directory_fk` FOREIGN KEY (`dim_directory_id`) REFERENCES `dim_directories` (`id`)
)
