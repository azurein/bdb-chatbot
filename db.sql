--SELECT * FROM questions
--SELECT * FROM debuglog ORDER BY Timestamp DESC LIMIT 5
--SELECT * FROM users ORDER BY Timestamp DESC LIMIT 5
--UPDATE users SET number = 0, mode = ''
--SELECT * FROM eventlog

DROP TABLE IF EXISTS debuglog;
CREATE TABLE debuglog
(
    "id" serial,
    "descr" varchar(100) NOT NULL,
    "timestamp" timestamp NOT NULL DEFAULT now(),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS eventlog;
CREATE TABLE eventlog
(
    "id" serial,
    "signature" varchar(64),
    "events" text,
    "timestamp" timestamp NOT NULL DEFAULT now(),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS questions;
CREATE TABLE questions
(
    "id" serial,
    "number" smallint NOT NULL,
    "text" text NOT NULL,
    "image" varchar(250) NOT NULL,
    "option_a" varchar(200) NOT NULL,
    "option_b" varchar(200) NOT NULL,
    "option_c" varchar(200) NOT NULL,
    "option_d" varchar(200) NOT NULL,
    "timestamp" timestamp NOT NULL DEFAULT now(),
    PRIMARY KEY ("id")
);

INSERT INTO questions (id, number, text, image, option_a, option_b, option_c, option_d) VALUES
(1, 1, 'Berapa rentang usia Anda?', 'https://res.cloudinary.com/dawqzmoq4/image/upload/v1513356076/Age_avgfpm.jpg', '12-15', '16-21', '22-27', '26-45'),
(2, 2, 'Apa yang Anda rasakan saat ini?', 'https://res.cloudinary.com/dawqzmoq4/image/upload/v1513356076/mood_qtl9cj.jpg', 'Marah', 'Depresi', 'Sakit Fisik', 'Netral'),
(3, 3, 'Bantuan apa yang paling Anda perlukan secepatnya?', 'https://res.cloudinary.com/dawqzmoq4/image/upload/v1513356078/help_dsjdpt.jpg', 'Teman Curhat', 'Konsultasi Psikolog', 'Konsultasi Hukum', 'Belum ada');

DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    "id" serial,
    "user_id" varchar(100) NOT NULL,
    "display_name" varchar(100) NOT NULL,
    "line_id" varchar(50) NULL,
    "number" smallint NOT NULL DEFAULT '0',
    "isTalking" smallint NOT NULL DEFAULT '0',
    "mode" varchar(100) NOT NULL DEFAULT '',
    "phone" varchar(100) NOT NULL DEFAULT '',
    "timestamp" timestamp NOT NULL DEFAULT now(),
    PRIMARY KEY ("id")
);

DROP TABLE IF EXISTS safehouse;
CREATE TABLE safehouse
(
    "id" serial,
    "safehouse_name" varchar(100) NOT NULL,
    "latitude" varchar(100) NOT NULL,
    "longitude" varchar(100) NOT NULL,
    "radius" float NULL,
    "pic1" varchar(100) NOT NULL DEFAULT '',
    "phone1" varchar(100) NOT NULL DEFAULT '',
    "pic2" varchar(100) NULL,
    "phone2" varchar(100) NULL,
    "pic3" varchar(100) NULL,
    "phone3" varchar(100) NULL,
    "timestamp" timestamp NULL DEFAULT now(),
    PRIMARY KEY ("id")
);