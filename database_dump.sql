-- Sequence structure for chore_settings_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."chore_settings_id_seq";


CREATE SEQUENCE "public"."chore_settings_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for chore_status_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."chore_status_id_seq";


CREATE SEQUENCE "public"."chore_status_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for chores_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."chores_id_seq";


CREATE SEQUENCE "public"."chores_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for households_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."households_id_seq";


CREATE SEQUENCE "public"."households_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for roles_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."roles_id_seq";


CREATE SEQUENCE "public"."roles_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for schedules_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."schedules_id_seq";


CREATE SEQUENCE "public"."schedules_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for user_chores_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."user_chores_id_seq";


CREATE SEQUENCE "public"."user_chores_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for user_household_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."user_household_id_seq";


CREATE SEQUENCE "public"."user_household_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for users_details_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."users_details_id_seq";


CREATE SEQUENCE "public"."users_details_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------

DROP SEQUENCE IF EXISTS "public"."users_id_seq";


CREATE SEQUENCE "public"."users_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647
START 1 CACHE 1;

-- ----------------------------
-- Table structure for chore_settings
-- ----------------------------

DROP TABLE IF EXISTS "public"."chore_settings";


CREATE TABLE "public"."chore_settings" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "chore_id" int4 NOT NULL,
                                         "times_in_a_week" int4 DEFAULT 1,
                                         "duration" int4 DEFAULT 15,
                                         "household_id" int4 NOT NULL) ;

-- ----------------------------
-- Table structure for chore_status
-- ----------------------------

DROP TABLE IF EXISTS "public"."chore_status";


CREATE TABLE "public"."chore_status" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "description" varchar COLLATE "pg_catalog"."default" NOT NULL) ;

-- ----------------------------
-- Records of chore_status
-- ----------------------------

INSERT INTO "public"."chore_status" OVERRIDING SYSTEM VALUE
VALUES (1,
        'Waiting');


INSERT INTO "public"."chore_status" OVERRIDING SYSTEM VALUE
VALUES (2,
        'Done');

-- ----------------------------
-- Table structure for chores
-- ----------------------------

DROP TABLE IF EXISTS "public"."chores";


CREATE TABLE "public"."chores" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "name" varchar COLLATE "pg_catalog"."default" NOT NULL) ;

-- ----------------------------
-- Records of chores
-- ----------------------------

INSERT INTO "public"."chores" OVERRIDING SYSTEM VALUE
VALUES (3,
        'Vacuum cleaning');


INSERT INTO "public"."chores" OVERRIDING SYSTEM VALUE
VALUES (4,
        'Mop the floor');


INSERT INTO "public"."chores" OVERRIDING SYSTEM VALUE
VALUES (5,
        'Take out the rubbish');


INSERT INTO "public"."chores" OVERRIDING SYSTEM VALUE
VALUES (6,
        'Dust the furniture');


INSERT INTO "public"."chores" OVERRIDING SYSTEM VALUE
VALUES (7,
        'Do the laundry');


INSERT INTO "public"."chores" OVERRIDING SYSTEM VALUE
VALUES (9,
        'Grocery shopping');

-- ----------------------------
-- Table structure for households
-- ----------------------------

DROP TABLE IF EXISTS "public"."households";


CREATE TABLE "public"."households" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "code" varchar COLLATE "pg_catalog"."default" NOT NULL) ;

-- ----------------------------
-- Table structure for roles
-- ----------------------------

DROP TABLE IF EXISTS "public"."roles";


CREATE TABLE "public"."roles" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "name" varchar COLLATE "pg_catalog"."default" NOT NULL) ;

-- ----------------------------
-- Records of roles
-- ----------------------------

INSERT INTO "public"."roles" OVERRIDING SYSTEM VALUE
VALUES (1,
        'Member');


INSERT INTO "public"."roles" OVERRIDING SYSTEM VALUE
VALUES (2,
        'Household Admin');

-- ----------------------------
-- Table structure for schedules
-- ----------------------------

DROP TABLE IF EXISTS "public"."schedules";


CREATE TABLE "public"."schedules" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "household_id" int4 NOT NULL,
                                    "start_date" date NOT NULL,
                                    "end_date" date NOT NULL,
                                    "created_at" timestamp(6) DEFAULT CURRENT_TIMESTAMP) ;

-- ----------------------------
-- Table structure for user_chores
-- ----------------------------

DROP TABLE IF EXISTS "public"."user_chores";


CREATE TABLE "public"."user_chores" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "userID" int4 NOT NULL DEFAULT 0,
                                      "choreID" int4 NOT NULL DEFAULT 0,
                                      "statusID" int4 NOT NULL DEFAULT 0,
                                      "dateScheduled" date, "schedule_id" int4) ;

-- ----------------------------
-- Table structure for user_household
-- ----------------------------

DROP TABLE IF EXISTS "public"."user_household";


CREATE TABLE "public"."user_household" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "userID" int4 NOT NULL DEFAULT 0,
                                         "householdID" int4 NOT NULL DEFAULT 0) ;

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------

DROP TABLE IF EXISTS "public"."user_roles";


CREATE TABLE "public"."user_roles" ( "user_id" int4 NOT NULL,
                                     "household_id" int4 NOT NULL DEFAULT 0,
                                     "role_id" int4 NOT NULL DEFAULT 0) ;

-- ----------------------------
-- Table structure for users
-- ----------------------------

DROP TABLE IF EXISTS "public"."users";


CREATE TABLE "public"."users" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "email" varchar COLLATE "pg_catalog"."default" NOT NULL,
                                "password" varchar COLLATE "pg_catalog"."default" NOT NULL,
                                "id_user_details" int4 NOT NULL DEFAULT 0) ;

-- ----------------------------
-- Table structure for users_details
-- ----------------------------

DROP TABLE IF EXISTS "public"."users_details";


CREATE TABLE "public"."users_details" ( "id" int4 NOT NULL GENERATED ALWAYS AS IDENTITY
    (INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1), "name" varchar COLLATE "pg_catalog"."default" NOT NULL,
                                        "photo" varchar COLLATE "pg_catalog"."default") ;

-- ----------------------------
-- Function structure for get_day_name
-- ----------------------------

DROP FUNCTION IF EXISTS "public"."get_day_name"("date_param" date);


CREATE OR REPLACE FUNCTION "public"."get_day_name"("date_param" date) RETURNS "pg_catalog"."text" AS $BODY$
BEGIN
RETURN to_char(date_param, 'Day');
END;$BODY$ LANGUAGE plpgsql IMMUTABLE COST 100;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."chore_settings_id_seq" OWNED BY "public"."chore_settings"."id";


SELECT setval('"public"."chore_settings_id_seq"', 12, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."chore_status_id_seq" OWNED BY "public"."chore_status"."id";


SELECT setval('"public"."chore_status_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."chores_id_seq" OWNED BY "public"."chores"."id";


SELECT setval('"public"."chores_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."households_id_seq" OWNED BY "public"."households"."id";


SELECT setval('"public"."households_id_seq"', 2, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."roles_id_seq" OWNED BY "public"."roles"."id";


SELECT setval('"public"."roles_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."schedules_id_seq" OWNED BY "public"."schedules"."id";


SELECT setval('"public"."schedules_id_seq"', 2, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."user_chores_id_seq" OWNED BY "public"."user_chores"."id";


SELECT setval('"public"."user_chores_id_seq"', 8, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."user_household_id_seq" OWNED BY "public"."user_household"."id";


SELECT setval('"public"."user_household_id_seq"', 1, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."users_details_id_seq" OWNED BY "public"."users_details"."id";


SELECT setval('"public"."users_details_id_seq"', 1, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------

ALTER SEQUENCE "public"."users_id_seq" OWNED BY "public"."users"."id";


SELECT setval('"public"."users_id_seq"', 1, true);

-- ----------------------------
-- Auto increment value for chore_settings
-- ----------------------------

SELECT setval('"public"."chore_settings_id_seq"', 12, true);

-- ----------------------------
-- Primary Key structure for table chore_settings
-- ----------------------------

ALTER TABLE "public"."chore_settings" ADD CONSTRAINT "chore_settings_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for chore_status
-- ----------------------------

SELECT setval('"public"."chore_status_id_seq"', 1, false);

-- ----------------------------
-- Primary Key structure for table chore_status
-- ----------------------------

ALTER TABLE "public"."chore_status" ADD CONSTRAINT "choreStatus_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for chores
-- ----------------------------

SELECT setval('"public"."chores_id_seq"', 1, false);

-- ----------------------------
-- Primary Key structure for table chores
-- ----------------------------

ALTER TABLE "public"."chores" ADD CONSTRAINT "chores_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for households
-- ----------------------------

SELECT setval('"public"."households_id_seq"', 2, true);

-- ----------------------------
-- Primary Key structure for table households
-- ----------------------------

ALTER TABLE "public"."households" ADD CONSTRAINT "households_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for roles
-- ----------------------------

SELECT setval('"public"."roles_id_seq"', 1, false);

-- ----------------------------
-- Primary Key structure for table roles
-- ----------------------------

ALTER TABLE "public"."roles" ADD CONSTRAINT "roles_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for schedules
-- ----------------------------

SELECT setval('"public"."schedules_id_seq"', 2, true);

-- ----------------------------
-- Primary Key structure for table schedules
-- ----------------------------

ALTER TABLE "public"."schedules" ADD CONSTRAINT "schedules_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for user_chores
-- ----------------------------

SELECT setval('"public"."user_chores_id_seq"', 8, true);

-- ----------------------------
-- Primary Key structure for table user_chores
-- ----------------------------

ALTER TABLE "public"."user_chores" ADD CONSTRAINT "userChores_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for user_household
-- ----------------------------

SELECT setval('"public"."user_household_id_seq"', 1, true);

-- ----------------------------
-- Primary Key structure for table user_household
-- ----------------------------

ALTER TABLE "public"."user_household" ADD CONSTRAINT "userHouseholdTable_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table user_roles
-- ----------------------------

ALTER TABLE "public"."user_roles" ADD CONSTRAINT "user_roles_pkey" PRIMARY KEY ("user_id",
                                                                                "household_id");

-- ----------------------------
-- Auto increment value for users
-- ----------------------------

SELECT setval('"public"."users_id_seq"', 1, true);

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------

ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Auto increment value for users_details
-- ----------------------------

SELECT setval('"public"."users_details_id_seq"', 1, true);

-- ----------------------------
-- Primary Key structure for table users_details
-- ----------------------------

ALTER TABLE "public"."users_details" ADD CONSTRAINT "users_details_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table chore_settings
-- ----------------------------

ALTER TABLE "public"."chore_settings" ADD CONSTRAINT "chore_settings_chore_id_fkey"
    FOREIGN KEY ("chore_id") REFERENCES "public"."chores" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."chore_settings" ADD CONSTRAINT "chore_settings_household_id_fkey"
    FOREIGN KEY ("household_id") REFERENCES "public"."households" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table schedules
-- ----------------------------

ALTER TABLE "public"."schedules" ADD CONSTRAINT "schedules_household_id_fkey"
    FOREIGN KEY ("household_id") REFERENCES "public"."households" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table user_chores
-- ----------------------------

ALTER TABLE "public"."user_chores" ADD CONSTRAINT "choreID"
    FOREIGN KEY ("choreID") REFERENCES "public"."chores" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."user_chores" ADD CONSTRAINT "statusID"
    FOREIGN KEY ("statusID") REFERENCES "public"."chore_status" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."user_chores" ADD CONSTRAINT "userChores_userID_fkey"
    FOREIGN KEY ("userID") REFERENCES "public"."users" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."user_chores" ADD CONSTRAINT "user_chores_schedule_id_fkey"
    FOREIGN KEY ("schedule_id") REFERENCES "public"."schedules" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table user_household
-- ----------------------------

ALTER TABLE "public"."user_household" ADD CONSTRAINT "householdID"
    FOREIGN KEY ("householdID") REFERENCES "public"."households" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."user_household" ADD CONSTRAINT "userHouseholdTable_userID_fkey"
    FOREIGN KEY ("userID") REFERENCES "public"."users" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table user_roles
-- ----------------------------

ALTER TABLE "public"."user_roles" ADD CONSTRAINT "user_roles_household_id_fkey"
    FOREIGN KEY ("household_id") REFERENCES "public"."households" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."user_roles" ADD CONSTRAINT "user_roles_role_id_fkey"
    FOREIGN KEY ("role_id") REFERENCES "public"."roles" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;


ALTER TABLE "public"."user_roles" ADD CONSTRAINT "user_roles_user_id_fkey"
    FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;

-- ----------------------------
-- Foreign Keys structure for table users
-- ----------------------------

ALTER TABLE "public"."users" ADD CONSTRAINT "users_id_user_details_fkey"
    FOREIGN KEY ("id_user_details") REFERENCES "public"."users_details" ("id") ON
        DELETE CASCADE ON
        UPDATE CASCADE;

