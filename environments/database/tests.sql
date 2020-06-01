SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "-03:00";
SET names 'utf8';

--
-- Leads Content
--
CREATE TABLE `leads_content` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `type` CHAR(100) DEFAULT NULL,
    `title` VARCHAR(255) DEFAULT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `content` TEXT DEFAULT NULL,
    `date_time` DATETIME DEFAULT NULL,
    `cover_id` INT(5) UNSIGNED DEFAULT NULL,
    `slug` VARCHAR(255) DEFAULT NULL,
    `form_link` VARCHAR(255) DEFAULT NULL,
    `topics` JSON DEFAULT NULL,
    `status` TINYINT(1) UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='version:1.0';

INSERT INTO `leads_content` (
    `id`, 
    `type`, 
    `title`, 
    `description`, 
    `content`, 
    `date_time`, 
    `cover_id`, 
    `slug`, 
    `form_link`, 
    `topics`, 
    `status`
) VALUES (
    1,
    'webinar',
    'Title 01', 
    'Description 01',
    '<p>Content 01</p>',
    '2020-04-28 11:54:00',
    4,
    'slug-01',
    'http://localhost/',
    '[{"title": "Topic 01"}, {"title": "Topic 02"}]',
    3
), (
    2, 
    'webinar', 
    'Title 02', 
    NULL,
    NULL,
    NULL,
    NULL,
    'slug-02',
    NULL,
    NULL,
    3
), (
    3,
    'webinar',
    'Title 03', 
    'Description 03',
    '<p>Content 03</p>',
    '2020-04-29 10:32:00',
    4,
    'slug-03',
    'http://localhost/03/',
    '[{"title": "Topic 04"}, {"title": "Topic 05"}]',
    0
);


--
-- Leads Author
--
CREATE TABLE `leads_author` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `content_id` INT(5) UNSIGNED NOT NULL,
    `person_id` INT(5) UNSIGNED NOT NULL,
    `subject` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='version:1.0';

INSERT INTO `leads_author` (
    `content_id`, `person_id`, `subject`
) VALUES (
    1, 1, NULL
),(
    2, 3, NULL
);


--
-- Leads Guest
--
CREATE TABLE `leads_guest` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `content_id` INT(5) UNSIGNED NOT NULL,
    `person_id` INT(5) UNSIGNED NOT NULL,
    `subject` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='version:1.0';

INSERT INTO `leads_guest` (
    `content_id`, `person_id`, `subject`
) VALUES (
    1, 2, 'Subject 01 of Content 01'
), (
    1, 3, 'Subject 02 of Content 01'
), (
    2, 4, 'Subject 01 of Content 02'
), (
    2, 5, 'Subject 02 of Content 02'
);

--
-- Leads Content View
--
CREATE VIEW `leads_content_view` AS
    SELECT 
        `leads_content`.*,
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'content_id',
                        `leads_guest`.`content_id`,
                        'person_id',
                        `leads_guest`.`person_id`,
                        'subject',
                        `leads_guest`.`subject`,
                        'id',
                        `leads_guest`.`id`
                    )
                )
            FROM `leads_guest`
            WHERE `leads_guest`.`content_id` = `leads_content`.`id`
        ) AS `guests`,
        (
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'content_id',
                        `leads_author`.`content_id`,
                        'person_id',
                        `leads_author`.`person_id`,
                        'subject',
                        `leads_author`.`subject`,
                        'id',
                        `leads_author`.`id`
                    )
                )
            FROM `leads_author`
            WHERE `leads_author`.`content_id` = `leads_content`.`id`
        ) AS `authors`
    FROM `leads_content`;

--
-- Leads records
--
CREATE TABLE `leads_records` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `content_id` INT(5) UNSIGNED NOT NULL,
    `name` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(255) DEFAULT NULL,
    `phone` BIGINT(13) DEFAULT NULL,
    `profile_id` TINYINT(2) UNSIGNED DEFAULT NULL,
    `date_time` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='version:1.0';

INSERT INTO `leads_records` (
    `content_id`, `name`, `email`, `phone`, `profile_id`, `date_time`
) VALUES (
    5, 'Leonardo da Vince', 'leo@art.com', '0012341234', 1, '2020-06-01 16:28:00'
),(
    4, 'Salvador Dalí', 'salvador@art.com', '0012345678', 2, '2020-06-01 17:28:00'
),(
    3, 'Michelangelo', 'michelangelo@art.com', '0012340123', 3, '2020-06-01 18:28:00'
);

--
-- Leads Messages
--
CREATE TABLE `leads_messages` (
    `id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `content_id` INT(5) UNSIGNED NOT NULL,
    `body` text,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='version:1.0';

INSERT INTO `leads_messages` (
    `content_id`, `body`
) VALUES (
    1, '<p>Hello!</p>'
),(
    2, '<p>Olá!</p>'
),(
    3, '<p>Welcome!</p>'
);

COMMIT;