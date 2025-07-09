CREATE TABLE `dim_batch_files`
(
    `id`              int unsigned NOT NULL AUTO_INCREMENT,
    `dim_batch_id`    int unsigned NOT NULL,
    `dim_file_id`     int unsigned NOT NULL,
    `sequence_number` int unsigned NOT NULL,
    `created_at`      timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      timestamp    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `batch_file_unique` (`dim_batch_id`, `dim_file_id`),
    KEY `dim_file_id` (`dim_file_id`),
    CONSTRAINT `batch_files_batch_fk` FOREIGN KEY (`dim_batch_id`) REFERENCES `dim_batches` (`id`),
    CONSTRAINT `batch_files_file_fk` FOREIGN KEY (`dim_file_id`) REFERENCES `dim_files` (`id`)
)
