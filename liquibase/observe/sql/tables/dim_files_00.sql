CREATE TABLE dim_files
(
    id                          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    file_path                   VARCHAR(1024)   NOT NULL,
    file_name                   VARCHAR(255)    NOT NULL,
    file_type                   VARCHAR(50)     NOT NULL,
    directory_path              VARCHAR(1024)   NOT NULL,
    directory_created_timestamp TIMESTAMP       NULL,
    file_created_timestamp      TIMESTAMP       NULL,
    file_size_bytes             INT UNSIGNED    NOT NULL,
    original_source_reference   VARCHAR(255),
    created_at                  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at                  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
