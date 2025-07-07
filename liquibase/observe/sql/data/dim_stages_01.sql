INSERT INTO dim_stages (stage_name, stage_order, stage_description, active_flag)
VALUES ('Configuration Import', 1, 'Import configuration data from CSV files', 1),
       ('Folder Search', 2, 'Search for folders containing markdown files', 1),
       ('Markdown File Search', 3, 'Identify all markdown files within target folders', 1),
       ('Batch Manifest Creation', 4, 'Map markdown files into logical batches', 1),
       ('Batch Group Creation', 5, 'Concatenate files together into target batches', 1);
