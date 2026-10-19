-- Adds the course "stage" and "subjects" columns that courses.php and
-- AdminCP > Courses use. Without them the Courses page shows PHP warnings
-- and saving a course fails.
--
-- Run once in phpMyAdmin (select the site's database > SQL tab > Go).
-- Safe to run again: existing columns are left alone.

ALTER TABLE `courses`
    ADD COLUMN IF NOT EXISTS `level` VARCHAR(20) NOT NULL DEFAULT '' AFTER `duration`,
    ADD COLUMN IF NOT EXISTS `subjects` TEXT NULL AFTER `level`;
