CREATE TABLE fact_batch_file_maps
(
    id                     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dim_batch_id           BIGINT UNSIGNED NOT NULL,
    dim_file_id            BIGINT UNSIGNED NOT NULL,
    file_sequence_in_batch INT UNSIGNED    NOT NULL,
    file_start_position    INT UNSIGNED    NOT NULL,
    file_end_position      INT UNSIGNED    NOT NULL,
    created_at             TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at             TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (dim_batch_id) REFERENCES dim_batches (id),
    FOREIGN KEY (dim_file_id) REFERENCES dim_files (id)
);
