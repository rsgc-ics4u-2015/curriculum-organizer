-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ct
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `ct` ;

-- -----------------------------------------------------
-- Schema ct
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ct` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ct` ;

-- -----------------------------------------------------
-- Table `ct`.`author_or_editor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`author_or_editor` ;

CREATE TABLE IF NOT EXISTS `ct`.`author_or_editor` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `username` VARCHAR(45) NOT NULL COMMENT '',
  `firstname` VARCHAR(45) NULL COMMENT '',
  `lastname` VARCHAR(45) NOT NULL COMMENT '',
  `password` VARCHAR(255) NOT NULL COMMENT '',
  `approved` TINYINT(1) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `username_UNIQUE` (`username` ASC)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`type` ;

CREATE TABLE IF NOT EXISTS `ct`.`type` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `description` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`evaluation_category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`evaluation_category` ;

CREATE TABLE IF NOT EXISTS `ct`.`evaluation_category` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`question` ;

CREATE TABLE IF NOT EXISTS `ct`.`question` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `shortlabel` VARCHAR(10) NOT NULL COMMENT '',
  `position` INT NOT NULL COMMENT '',
  `title` VARCHAR(45) NOT NULL COMMENT '',
  `url` VARCHAR(2000) NOT NULL COMMENT '',
  `type_id` INT NOT NULL COMMENT '',
  `evaluation_category_id` INT NOT NULL COMMENT '',
  `author_or_editor_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`, `author_or_editor_id`)  COMMENT '',
  INDEX `fk_question_type1_idx` (`type_id` ASC)  COMMENT '',
  INDEX `fk_question_evaluation_category1_idx` (`evaluation_category_id` ASC)  COMMENT '',
  INDEX `fk_question_author_or_editor1_idx` (`author_or_editor_id` ASC)  COMMENT '',
  CONSTRAINT `fk_question_type1`
    FOREIGN KEY (`type_id`)
    REFERENCES `ct`.`type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_evaluation_category1`
    FOREIGN KEY (`evaluation_category_id`)
    REFERENCES `ct`.`evaluation_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_author_or_editor1`
    FOREIGN KEY (`author_or_editor_id`)
    REFERENCES `ct`.`author_or_editor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`citation_or_source`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`citation_or_source` ;

CREATE TABLE IF NOT EXISTS `ct`.`citation_or_source` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `description` VARCHAR(1000) NOT NULL COMMENT '',
  `shortname` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`course` ;

CREATE TABLE IF NOT EXISTS `ct`.`course` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(45) NOT NULL COMMENT '',
  `description` VARCHAR(1024) NOT NULL COMMENT '',
  `code` VARCHAR(8) NOT NULL COMMENT '',
  `url` VARCHAR(2000) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`strand`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`strand` ;

CREATE TABLE IF NOT EXISTS `ct`.`strand` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `code` VARCHAR(2) NOT NULL COMMENT '',
  `title` VARCHAR(255) NOT NULL COMMENT '',
  `course_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`, `course_id`)  COMMENT '',
  INDEX `fk_strand_course1_idx` (`course_id` ASC)  COMMENT '',
  CONSTRAINT `fk_strand_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `ct`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`overall_expectation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`overall_expectation` ;

CREATE TABLE IF NOT EXISTS `ct`.`overall_expectation` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `code` VARCHAR(2) NOT NULL COMMENT '',
  `title` VARCHAR(255) NOT NULL COMMENT '',
  `description` VARCHAR(500) NOT NULL COMMENT '',
  `strand_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`, `strand_id`)  COMMENT '',
  INDEX `fk_overall_expectation_strand1_idx` (`strand_id` ASC)  COMMENT '',
  CONSTRAINT `fk_overall_expectation_strand1`
    FOREIGN KEY (`strand_id`)
    REFERENCES `ct`.`strand` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`minor_expectation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`minor_expectation` ;

CREATE TABLE IF NOT EXISTS `ct`.`minor_expectation` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `code` VARCHAR(2) NOT NULL COMMENT '',
  `description` VARCHAR(1000) NULL COMMENT '',
  `overall_expectation_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`, `overall_expectation_id`)  COMMENT '',
  INDEX `fk_minor_expectation_overall_expectation1_idx` (`overall_expectation_id` ASC)  COMMENT '',
  CONSTRAINT `fk_minor_expectation_overall_expectation1`
    FOREIGN KEY (`overall_expectation_id`)
    REFERENCES `ct`.`overall_expectation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`question_has_citation_or_source`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`question_has_citation_or_source` ;

CREATE TABLE IF NOT EXISTS `ct`.`question_has_citation_or_source` (
  `question_id` INT NOT NULL COMMENT '',
  `citation_or_source_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`question_id`, `citation_or_source_id`)  COMMENT '',
  INDEX `fk_question_has_citation_or_source_citation_or_source1_idx` (`citation_or_source_id` ASC)  COMMENT '',
  INDEX `fk_question_has_citation_or_source_question1_idx` (`question_id` ASC)  COMMENT '',
  CONSTRAINT `fk_question_has_citation_or_source_question1`
    FOREIGN KEY (`question_id`)
    REFERENCES `ct`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_has_citation_or_source_citation_or_source1`
    FOREIGN KEY (`citation_or_source_id`)
    REFERENCES `ct`.`citation_or_source` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ct`.`question_has_minor_expectation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ct`.`question_has_minor_expectation` ;

CREATE TABLE IF NOT EXISTS `ct`.`question_has_minor_expectation` (
  `question_id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `minor_expectation_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`question_id`, `minor_expectation_id`)  COMMENT '',
  INDEX `fk_question_has_minor_expectation_minor_expectation1_idx` (`minor_expectation_id` ASC)  COMMENT '',
  INDEX `fk_question_has_minor_expectation_question1_idx` (`question_id` ASC)  COMMENT '',
  CONSTRAINT `fk_question_has_minor_expectation_question1`
    FOREIGN KEY (`question_id`)
    REFERENCES `ct`.`question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_has_minor_expectation_minor_expectation1`
    FOREIGN KEY (`minor_expectation_id`)
    REFERENCES `ct`.`minor_expectation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
