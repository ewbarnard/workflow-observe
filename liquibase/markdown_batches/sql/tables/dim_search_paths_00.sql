CREATE TABLE dim_search_paths
(
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    search_path     VARCHAR(255) NOT NULL,
    source_csv_file VARCHAR(255) NOT NULL,
    is_active       BOOLEAN      NOT NULL DEFAULT TRUE,
    added_date      TIMESTAMP    NOT NULL,
    created_at      TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unq_search_path (search_path)
);
