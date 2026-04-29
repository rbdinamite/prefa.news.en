BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "city" (
	"city_id"	INTEGER NOT NULL,
	"city_state"	TEXT NOT NULL,
	"city_name"	TEXT NOT NULL,
	"url_type"	TEXT,
	"url_path"	TEXT,
	"date_lastcheck"	TEXT,
	"date_lastnews"	TEXT,
	"instagram_path"	TEXT,
	"is_active"	INTEGER NOT NULL DEFAULT 0,
	PRIMARY KEY("city_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "news" (
	"news_id"	INTEGER NOT NULL,
	"city_id"	INTEGER NOT NULL,
	"news_title"	REAL NOT NULL,
	"news_title_pt"	TEXT,
	"date_publish"	TEXT,
	"url_news"	TEXT NOT NULL,
	"url_img"	TEXT,
	"news_description"	TEXT,
	"news_score"	REAL NOT NULL DEFAULT 0,
	"is_active"	NUMERIC NOT NULL DEFAULT 1,
	PRIMARY KEY("news_id" AUTOINCREMENT),
	CONSTRAINT "fk_city_news" FOREIGN KEY("city_id") REFERENCES ""
);
COMMIT;
