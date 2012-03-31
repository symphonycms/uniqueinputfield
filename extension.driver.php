<?php

	Class extension_uniqueinputfield extends Extension{

		public function about(){
			return array(
				'name' => 'Field: Unique Text Input',
				'version' => '1.4',
				'release-date' => '2011-12-17',
				'author' => array(
					'name' => 'Symphony Team',
					'website' => 'http://www.symphony21.com',
					'email' => 'team@symphony21.com'
				)
			);
		}

		/**
		 * Added initFollow callback. 
		 */
		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'InitaliseAdminPageHead',
					'callback'	=> 'initFollow'
				)
			);
		}

		/**
		 * Added follow.js script.
		 */
		public function initFollow($context) {
			$page = $context['parent']->Page;
			
            $page->addScriptToHead(URL . '/extensions/uniqueinputfield/js/follow.js', 3466702);
		}

		public function uninstall(){
			Symphony::Database()->query("DROP TABLE `tbl_fields_uniqueinput`");
		}

		public function install() {
			/** Added follow field. */
			return (bool)Symphony::Database()->query("
				CREATE TABLE `tbl_fields_uniqueinput` (
				  `id` int(11) unsigned NOT NULL auto_increment,
				  `field_id` int(11) unsigned NOT NULL,
				  `validator` varchar(100) default NULL,
				  `follow` varchar(100) default NULL,
				  `auto_unique` enum('yes','no') NOT NULL default 'no',
				  PRIMARY KEY  (`id`),
				  KEY `field_id` (`field_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
			");
		}

	}