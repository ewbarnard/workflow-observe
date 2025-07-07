CREATE TABLE dim_batches
(
    id                      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    batch_name              VARCHAR(255)    NOT NULL,
    batch_description       TEXT,
    batch_created_timestamp TIMESTAMP       NULL,
    batch_size_bytes        INT UNSIGNED    NOT NULL DEFAULT 0,
    file_count              INT UNSIGNED    NOT NULL DEFAULT 0,
    created_at              TIMESTAMP                DEFAULT CURRENT_TIMESTAMP,
    updated_at              TIMESTAMP                DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
