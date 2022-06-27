#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	name varchar(255) DEFAULT '' NOT NULL,
	first_name varchar(255) DEFAULT '' NOT NULL,
	last_name varchar(255) DEFAULT '' NOT NULL,
	title_c_v varchar(255) DEFAULT '' NOT NULL,
	about text,
	company text,
	contact_person text,
	diploma int(11) unsigned DEFAULT '0' NOT NULL,
	experience int(11) unsigned DEFAULT '0' NOT NULL,
	location int(11) unsigned DEFAULT '0',
	position int(11) unsigned DEFAULT '0',
	offer int(11) unsigned DEFAULT '0' NOT NULL,
	#photo int(11) unsigned NOT NULL default '0',
	#cvfile int(11) unsigned NOT NULL default '0',
	photo int(11) unsigned NULL,
	cvfile int(11) unsigned NULL,
	path_segment varchar(2048),
);

#
# Table structure for table 'tx_cfajob_domain_model_diploma'
#
CREATE TABLE tx_cfajob_domain_model_diploma (

	frontenduser int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	diploma varchar(255) DEFAULT '' NOT NULL,
	start_year date DEFAULT NULL,
	end_year date DEFAULT NULL,
	description text,
    user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_cfajob_domain_model_experience'
#
CREATE TABLE tx_cfajob_domain_model_experience (

	frontenduser int(11) unsigned DEFAULT '0' NOT NULL,

	employeur varchar(255) DEFAULT '' NOT NULL,
	position varchar(255) DEFAULT '' NOT NULL,
	start_year date DEFAULT NULL,
	end_year date DEFAULT NULL,
	description text,
    user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_cfajob_domain_model_location'
#
CREATE TABLE tx_cfajob_domain_model_location (

	name varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_cfajob_domain_model_position'
#
CREATE TABLE tx_cfajob_domain_model_position (

	name varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_cfajob_domain_model_offer'
#
CREATE TABLE tx_cfajob_domain_model_offer (

	frontenduser int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	email varchar(255) DEFAULT '' NOT NULL,
    company int(11) unsigned DEFAULT '0' NOT NULL,
#	company varchar(255) DEFAULT '' NOT NULL,
	contact_person varchar(255) DEFAULT '' NOT NULL,
	site varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	type int(11) unsigned DEFAULT '0',
	city int(11) unsigned DEFAULT '0',
	zip varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_cfajob_domain_model_training'
#
CREATE TABLE tx_cfajob_domain_model_training (

	name varchar(255) DEFAULT '' NOT NULL,
	theme varchar(255) DEFAULT '' NOT NULL,
	is_dpc smallint(5) unsigned DEFAULT '0' NOT NULL,
	is_new smallint(5) unsigned DEFAULT '0' NOT NULL,
	information text,
	duration text,
	whois text,
	whoare text,
	course_file int(11) unsigned NOT NULL default '0',
	registration_file int(11) unsigned NOT NULL default '0',
	programm text,
	additional_info text,
	city int(11) unsigned DEFAULT '0',
	categories int(11) unsigned DEFAULT '0' NOT NULL,
	image int(11) unsigned NOT NULL default '0',
    path_segment varchar(2048),
);

#
# Table structure for table 'sys_category'
#
CREATE TABLE sys_category (
	title varchar(255) DEFAULT '' NOT NULL,
	description text,
	link varchar(255) DEFAULT '' NOT NULL,
    id int(11) DEFAULT '0' NOT NULL,
    type int(11) DEFAULT '0' NOT NULL,
	item int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_cfajob_training_category_mm'
#
CREATE TABLE tx_cfajob_training_category_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
