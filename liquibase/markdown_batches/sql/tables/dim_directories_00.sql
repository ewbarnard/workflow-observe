CREATE TABLE dim_directories
(
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    directory_path      VARCHAR(255) NOT NULL,
    directory_name      VARCHAR(255) NOT NULL,
    parent_directory    VARCHAR(255) NULL,
    creation_timestamp  TIMESTAMP    NOT NULL,
    first_discovered_at TIMESTAMP    NOT NULL,
    directory_level     INT UNSIGNED NOT NULL,
    current_flag        BOOLEAN      NOT NULL DEFAULT TRUE,
    effective_date      TIMESTAMP    NOT NULL,
    expiration_date     TIMESTAMP    NULL,
    created_at          TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_dir_path_current (directory_path, current_flag)
);
