CREATE TABLE fact_batches
(
    id                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dim_batch_id        INT UNSIGNED    NOT NULL,
    dim_date_created_id INT UNSIGNED    NOT NULL,
    total_size_bytes    INT UNSIGNED    NOT NULL,
    file_count          INT UNSIGNED    NOT NULL,
    directory_count     INT UNSIGNED    NOT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dim_batch_id) REFERENCES dim_batches (id),
    FOREIGN KEY (dim_date_created_id) REFERENCES dim_dates (id)
);
