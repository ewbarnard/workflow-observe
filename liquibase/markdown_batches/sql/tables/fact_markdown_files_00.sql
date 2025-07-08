CREATE TABLE fact_markdown_files
(
    id                     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dim_directory_id       INT UNSIGNED    NOT NULL,
    dim_search_path_id     INT UNSIGNED    NOT NULL,
    dim_date_discovered_id INT UNSIGNED    NOT NULL,
    dim_date_processed_id  INT UNSIGNED    NULL,
    dim_batch_id           INT UNSIGNED    NULL,
    file_path              VARCHAR(255)    NOT NULL,
    filename               VARCHAR(255)    NOT NULL,
    file_size_bytes        INT UNSIGNED    NOT NULL,
    word_count             INT UNSIGNED    NULL,
    is_processed           BOOLEAN         NOT NULL DEFAULT FALSE,
    created_at             TIMESTAMP                DEFAULT CURRENT_TIMESTAMP,
    updated_at             TIMESTAMP                DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unq_file_path (file_path),
    FOREIGN KEY (dim_directory_id) REFERENCES dim_directories (id),
    FOREIGN KEY (dim_search_path_id) REFERENCES dim_search_paths (id),
    FOREIGN KEY (dim_date_discovered_id) REFERENCES dim_dates (id),
    FOREIGN KEY (dim_date_processed_id) REFERENCES dim_dates (id),
    FOREIGN KEY (dim_batch_id) REFERENCES dim_batches (id)
);
