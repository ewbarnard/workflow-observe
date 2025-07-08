CREATE TABLE fact_file_processings
(
    id                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dim_version_id     INT UNSIGNED    NOT NULL,
    dim_file_id        int UNSIGNED    NOT NULL,
    dim_stage_id       INT UNSIGNED    NOT NULL,
    dim_status_id      INT UNSIGNED    NOT NULL,
    process_timestamp  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dim_batch_id       int UNSIGNED    NULL,
    error_message      TEXT            NULL,
    processing_time_ms INT UNSIGNED    NULL,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (dim_version_id) REFERENCES dim_versions (id),
    FOREIGN KEY (dim_file_id) REFERENCES dim_files (id),
    FOREIGN KEY (dim_stage_id) REFERENCES dim_stages (id),
    FOREIGN KEY (dim_status_id) REFERENCES dim_statuses (id),
    FOREIGN KEY (dim_batch_id) REFERENCES dim_batches (id)
);
