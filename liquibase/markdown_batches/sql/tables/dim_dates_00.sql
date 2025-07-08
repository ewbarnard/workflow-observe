CREATE TABLE dim_dates
(
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_date  DATE         NOT NULL,
    day        INT UNSIGNED NOT NULL,
    month      INT UNSIGNED NOT NULL,
    year       INT UNSIGNED NOT NULL,
    day_name   VARCHAR(10)  NOT NULL,
    month_name VARCHAR(10)  NOT NULL,
    is_weekend BOOLEAN      NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP             DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP             DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unq_full_date (full_date)
);
