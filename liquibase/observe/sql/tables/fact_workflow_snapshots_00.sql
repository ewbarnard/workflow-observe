CREATE TABLE fact_workflow_snapshots
(
    id                             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dim_version_id                 INT UNSIGNED    NOT NULL,
    snapshot_timestamp             TIMESTAMP                DEFAULT CURRENT_TIMESTAMP,

    config_import_dim_stage_id     INT UNSIGNED    NULL,
    config_import_dim_status_id    INT UNSIGNED    NULL,
    config_import_start_timestamp  TIMESTAMP       NULL,
    config_import_end_timestamp    TIMESTAMP       NULL,

    folder_search_dim_stage_id     INT UNSIGNED    NULL,
    folder_search_dim_status_id    INT UNSIGNED    NULL,
    folder_search_start_timestamp  TIMESTAMP       NULL,
    folder_search_end_timestamp    TIMESTAMP       NULL,

    file_search_dim_stage_id       INT UNSIGNED    NULL,
    file_search_dim_status_id      INT UNSIGNED    NULL,
    file_search_start_timestamp    TIMESTAMP       NULL,
    file_search_end_timestamp      TIMESTAMP       NULL,

    batch_manifest_dim_stage_id    INT UNSIGNED    NULL,
    batch_manifest_dim_status_id   INT UNSIGNED    NULL,
    batch_manifest_start_timestamp TIMESTAMP       NULL,
    batch_manifest_end_timestamp   TIMESTAMP       NULL,

    batch_creation_dim_stage_id    INT UNSIGNED    NULL,
    batch_creation_dim_status_id   INT UNSIGNED    NULL,
    batch_creation_start_timestamp TIMESTAMP       NULL,
    batch_creation_end_timestamp   TIMESTAMP       NULL,

    total_files_processed          INT UNSIGNED    NOT NULL DEFAULT 0,
    total_batches_created          INT UNSIGNED    NOT NULL DEFAULT 0,
    total_bytes_processed          BIGINT UNSIGNED NOT NULL DEFAULT 0,
    error_count                    INT UNSIGNED    NOT NULL DEFAULT 0,

    created_at                     TIMESTAMP                DEFAULT CURRENT_TIMESTAMP,
    updated_at                     TIMESTAMP                DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (dim_version_id) REFERENCES dim_versions (id),
    FOREIGN KEY (config_import_dim_stage_id) REFERENCES dim_stages (id),
    FOREIGN KEY (config_import_dim_status_id) REFERENCES dim_statuses (id),
    FOREIGN KEY (folder_search_dim_stage_id) REFERENCES dim_stages (id),
    FOREIGN KEY (folder_search_dim_status_id) REFERENCES dim_statuses (id),
    FOREIGN KEY (file_search_dim_stage_id) REFERENCES dim_stages (id),
    FOREIGN KEY (file_search_dim_status_id) REFERENCES dim_statuses (id),
    FOREIGN KEY (batch_manifest_dim_stage_id) REFERENCES dim_stages (id),
    FOREIGN KEY (batch_manifest_dim_status_id) REFERENCES dim_statuses (id),
    FOREIGN KEY (batch_creation_dim_stage_id) REFERENCES dim_stages (id),
    FOREIGN KEY (batch_creation_dim_status_id) REFERENCES dim_statuses (id)
);
