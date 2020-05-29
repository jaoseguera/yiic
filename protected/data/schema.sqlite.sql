CREATE TABLE tui_users (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    `bi_id` BLOB NOT NULL,
	`bi_upload` BLOB NOT NULL,
	`customize` BLOB NOT NULL,
	`host_id` BLOB NOT NULL,
	`host_upload` BLOB NOT NULL,
	`past_time` DATETIME NOT NULL,
	`present_time` DATETIME NOT NULL,
	`profile` BLOB NOT NULL,
	`email` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,    
    `status` VARCHAR(20) NOT NULL,
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_user (email, password) VALUES ('maharajan@emergys.com', 'test123');