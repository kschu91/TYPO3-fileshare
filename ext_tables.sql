#
# Table structure for table 'tx_fileshare_domain_model_share'
#
CREATE TABLE tx_fileshare_domain_model_share (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  deleted tinyint(3) DEFAULT '0' NOT NULL,
  hidden tinyint(3) DEFAULT '0' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,

	label tinytext,
	token tinytext,
	contact tinytext,

	storage int(11) DEFAULT '0' NOT NULL,
	folder text NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);