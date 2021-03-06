<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * *********************************************************************************************************************************** */
require_once 'modules/com_vtiger_workflow/include.inc';
require_once 'modules/com_vtiger_workflow/tasks/VTEntityMethodTask.inc';
require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
require_once('include/events/include.inc');
include_once('vtlib/Vtiger/Module.php');

class YetiForceUpdate
{

	var $package;
	var $modulenode;
	var $return = true;
	var $filesToDelete = ['api\customerportal.php',
		'api\firefoxtoolbar.php',
		'api\thunderbirdplugin.php',
		'api\wordplugin.php',
		'layouts\vlayout\modules\OSSMail\resources\mailtemplate.js',
		'layouts\vlayout\modules\OSSMailTemplates\Config.tpl',
		'layouts\vlayout\skins\images\btnAdd.png',
		'libraries\adodb',
		'libraries\chartjs\Chartmin.js',
		'libraries\guidersjs',
		'libraries\jquery\datatables\bower.json',
		'libraries\jquery\datatables\composer.json',
		'libraries\jquery\datatables\dataTables.jquery.json',
		'libraries\jquery\datatables\extensions\ColReorder\Readme.txt',
		'libraries\jquery\datatables\extensions\ColVis\Readme.txt',
		'libraries\jquery\datatables\extensions\FixedColumns\Readme.txt',
		'libraries\jquery\datatables\media\images\back_disabled.png',
		'libraries\jquery\datatables\media\images\back_enabled.png',
		'libraries\jquery\datatables\media\images\back_enabled_hover.png',
		'libraries\jquery\datatables\media\images\forward_disabled.png',
		'libraries\jquery\datatables\media\images\forward_enabled.png',
		'libraries\jquery\datatables\media\images\forward_enabled_hover.png',
		'libraries\jquery\datatables\package.json',
		'libraries\jquery\jqplot\excanvas.js',
		'libraries\jquery\jqplot\jquery.jqplot.css',
		'libraries\jquery\jqplot\jquery.jqplot.js',
		'libraries\jquery\jquery-ui\css',
		'libraries\jquery\jquery-ui\js',
		'libraries\jquery\jquery-ui\README.md',
		'libraries\jquery\jquery-ui\third-party',
		'libraries\jquery\pnotify\jquery.pnotify.default.css',
		'libraries\jquery\pnotify\jquery.pnotify.js',
		'libraries\jquery\pnotify\jquery.pnotify.min.js',
		'libraries\jquery\pnotify\use for pines style icons\jquery.pnotify.default.icons.css',
		'libraries\jquery\select2\component.json',
		'libraries\jquery\select2\LICENSE',
		'libraries\jquery\select2\release.sh',
		'libraries\jquery\select2\select2.png',
		'libraries\jquery\select2\select2x2.png',
		'libraries\jquery\select2\spinner.gif',
		'modules\Accounts\actions',
		'modules\Contacts\actions\TransferOwnership.php',
		'modules\ModComments\actions\Delete.php',
		'modules\OSSMailTemplates\actions\GetListModule.php',
		'modules\OSSMailTemplates\actions\GetListTpl.php',
		'modules\RequirementCards\models\Module.php',
		'modules\Settings\BackUp\actions\CreateBackUp.php',
		'modules\Settings\BackUp\actions\CreateFileBackUp.php',
		'modules\Settings\BackUp\actions\SaveFTPConfig.php',
		'modules\Vtiger\resources\validator\EmailValidator.js',
		'layouts\vlayout\modules\OSSMailTemplates\Config.tpl',
		'layouts\vlayout\skins\images\btnAdd.png',
		'languages\de_de\Install.php',
		'languages\en_us\Install.php',
		'languages\pl_pl\Install.php',
		'languages\pt_br\Install.php',
		'languages\ru_ru\Install.php',
		'layouts/vlayout/modules/Accounts/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Calculations/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Contacts/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/HelpDesk/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/HolidaysEntitlement/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Ideas/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Leads/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/LettersIn/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/LettersOut/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/NewOrders/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/OSSEmployees/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/OSSMailView/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/OSSTimeControl/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Potentials/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Project/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/ProjectTask/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/QuotesEnquires/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/RequirementCards/DetailViewSummaryContents.tpl',
		'layouts/vlayout/modules/Reservations/DetailViewSummaryContents.tpl',
		'config/config.template.php',
		'config.csrf-secret.php',
		'modules/OSSMail/roundcube/plugins/oss_addressbook',
		'languages/de_de/Password.php',
		'languages/en_us/Password.php',
		'languages/nl_nl/Password.php',
		'languages/pl_pl/Password.php',
		'languages/pt_br/Password.php',
		'languages/ru_ru/Password.php',
		'vtlib/ModuleDir/BaseModule/languages/en_us/ModuleName.php',
		'vtlib/ModuleDir/BaseModule/ModuleName.php',
		'api/webservice/modules/Users.php',
	];

	function YetiForceUpdate($modulenode)
	{
		$this->modulenode = $modulenode;
	}

	function preupdate()
	{
		//$this->package->_errorText = 'Errot';

		return true;
	}

	function update()
	{
		$this->updateFiles();
		$this->roundcubeConfig();
		$this->databaseSchema();
		$this->databaseData();
	}

	function postupdate()
	{
		global $log, $adb;
		$dirName = 'cache/updates';
		$result = true;
		Vtiger_Deprecated::createModuleMetaFile();
		Vtiger_Access::syncSharingAccess();
		$adb->query('SET FOREIGN_KEY_CHECKS = 1;');
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$adb->query("INSERT INTO `yetiforce_updates` (`user`, `name`, `from_version`, `to_version`, `result`) VALUES ('" . $currentUser->get('user_name') . "', '" . $this->modulenode->label . "', '" . $this->modulenode->from_version . "', '" . $this->modulenode->to_version . "','" . $result . "');", true);
		$adb->query("UPDATE vtiger_version SET `current_version` = '" . $this->modulenode->to_version . "';");
		Vtiger_Functions::recurseDelete($dirName . '/files');
		Vtiger_Functions::recurseDelete($dirName . '/init.php');
		Vtiger_Functions::recurseDelete('cache/templates_c');
		header('Location: ' . vglobal('site_URL'));
		exit;
		return true;
	}

	function updateFiles()
	{
		global $log, $root_directory;
		$log->debug("Entering YetiForceUpdate::updateFiles() method ...");
		if (!$root_directory)
			$root_directory = getcwd();
		$config = $root_directory . '/config/config.inc.php';
		if (file_exists($config)) {
			$configContent = file($config);
			$emptyLine = false;
			$backupVariable = true;
			$gsAutocomplete = true;
			foreach ($configContent as $key => $line) {
				if ($emptyLine && strlen($line) == 1) {
					unset($configContent[$key]);
					$emptyLine = false;
				}
				if (strpos($line, 'log_sql default value') !== FALSE ||
					strpos($line, "log_sql") !== FALSE ||
					strpos($line, 'persistent default value') !== FALSE ||
					strpos($line, "dbconfigoption['persistent']") !== FALSE ||
					strpos($line, "autofree default value") !== FALSE ||
					strpos($line, "dbconfigoption['autofree']") !== FALSE ||
					strpos($line, "debug default value") !== FALSE ||
					strpos($line, "dbconfigoption['debug']") !== FALSE ||
					strpos($line, "seqname_format default value") !== FALSE ||
					strpos($line, "dbconfigoption['seqname_format']") !== FALSE ||
					strpos($line, "portability default value") !== FALSE ||
					strpos($line, "dbconfigoption['portability']") !== FALSE ||
					strpos($line, "ssl default value") !== FALSE ||
					strpos($line, "dbconfigoption['ssl']") !== FALSE
				) {
					unset($configContent[$key]);
					$emptyLine = true;
				}
				if (strpos($line, 'session.gc_maxlifetime') !== FALSE) {
					$configContent[$key] = str_replace("'1800'); //30 min", "'21600');", $configContent[$key]);
				}
				if (strpos($line, "dbconfig['db_port'] =") !== FALSE) {
					$number = strpos($line, ':');
					if ($number !== FALSE) {
						$port = substr($line, $number + 1);
						$configContent[$key] = '$dbconfig[\'db_port\'] = \'' . $port;
					}
				}
				if (strpos($line, "dbconfig['db_hostname'] =") !== FALSE) {
					$number = strpos($line, ':');
					if ($number === FALSE) {
						$configContent[$key] = str_replace("\$dbconfig['db_port']", "':'.\$dbconfig['db_port']", $configContent[$key]);
					}
				}
				if (strpos($line, "encryptBackup") !== FALSE) {
					$backupVariable = false;
				}
				if (strpos($line, "gsAutocomplete") !== FALSE) {
					$gsAutocomplete = false;
				}
			}
			$content = implode("", $configContent);
			if ($backupVariable) {
				$content .= '
// Enable encrypt backup, Support from PHP 5.6.x
$encryptBackup = false;
';
			}
			if ($gsAutocomplete) {
				$content .= '
// autocomplete global search - Whether or not automated search should be turned on"
$gsAutocomplete = 1; // 0 or 1

// autocomplete global search - The minimum number of characters a user must type before a search is performed. 
$gsMinLength = 3;

// autocomplete global search - Amount of returned results.
$gsAmountResponse = 10;
';
			}
			$file = fopen($config, "w+");
			fwrite($file, $content);
			fclose($file);
		}
		$log->debug("Exiting YetiForceUpdate::updateFiles() method ... ");
	}

	function roundcubeConfig()
	{
		global $log, $adb, $root_directory;
		$log->debug("Entering YetiForceUpdate::roundcubeConfig() method ...");
		if (!$root_directory)
			$root_directory = getcwd();
		$fileName = $root_directory . '/modules/OSSMail/roundcube/config/config.inc.php';
		if (file_exists($fileName)) {
			$configContent = file($fileName);
			foreach ($configContent as $key => $line) {
				if (strpos($line, "config['db_dsnw']") !== FALSE) {
					$configContent[$key] = str_replace("\$dbconfig['db_port']", "':'.\$dbconfig['db_port']", $configContent[$key]);
				}
				if (strpos($line, "config['plugins']") !== FALSE) {
					$configContent[$key] = str_replace("'yetiforce'", "'yetiforce','thunderbird_labels'", $configContent[$key]);
				}
			}
			$content = implode("", $configContent);
			$file = fopen($fileName, "w+");
			fwrite($file, $content);
			fclose($file);
		}
		$log->debug("Exiting YetiForceUpdate::roundcubeConfig() method ... ");
	}

	function databaseSchema()
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::databaseSchema() method ...");

		$result = $adb->query("SHOW TABLES LIKE 'vtiger_backup_db_tmp';");
		if ($adb->num_rows($result)) {
			$adb->query("RENAME TABLE vtiger_backup_db_tmp TO `vtiger_backup_db`;");
			$adb->query("ALTER TABLE `vtiger_backup_db` 
				CHANGE `tmpbackupid` `id` int(19) unsigned   NOT NULL auto_increment first , 
				CHANGE `table_name` `tablename` varchar(50)  COLLATE utf8_general_ci NOT NULL after `id` ,  
				CHANGE `status` `status` tinyint(1) unsigned   NOT NULL DEFAULT 0 after `tablename` , 
				ADD COLUMN `offset` int(19) unsigned   NOT NULL DEFAULT 0 after `status` , 
				ADD COLUMN `count` int(19) unsigned   NOT NULL after `offset` ,  
				DROP KEY `PRIMARY`, ADD PRIMARY KEY(`id`) , 
				ADD KEY `status`(`status`) , 
				ADD KEY `tablename`(`tablename`) ;");
		}
		$result = $adb->query("DROP TABLE IF EXISTS vtiger_backup_db_tmp_info;");
		$result = $adb->query("DROP TABLE IF EXISTS vtiger_backup_ftp;");
		$result = $adb->query("DROP TABLE IF EXISTS vtiger_backup_users;");

		$result = $adb->query("SHOW TABLES LIKE 'vtiger_backup_dir';");
		if ($adb->num_rows($result)) {
			$adb->query("RENAME TABLE vtiger_backup_dir TO `vtiger_backup_files`;");
			$adb->query("ALTER TABLE `vtiger_backup_files` 
				ADD COLUMN `id` int(19) unsigned   NOT NULL auto_increment first , 
				CHANGE `name` `name` text NOT NULL after `id` , 
				CHANGE `backup` `backup` tinyint(1) NOT NULL DEFAULT 0 after `name` , 
				ADD KEY `backup`(`backup`) , 
				ADD PRIMARY KEY(`id`) ;");
		}
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_backup` LIKE 'id';");
		if (!$adb->num_rows($result)) {
			$adb->query("ALTER TABLE `vtiger_backup` 
				CHANGE `backupid` `id` int(19) unsigned   NOT NULL auto_increment first , 
				CHANGE `file_name` `filename` varchar(20) NOT NULL after `id` , 
				CHANGE `created_at` `starttime` datetime   NOT NULL after `filename` , 
				ADD COLUMN `endtime` datetime   NULL after `starttime` , 
				ADD COLUMN `status` tinyint(1) unsigned   NOT NULL DEFAULT 0 after `endtime` , 
				ADD COLUMN `backuptime` decimal(8,3) unsigned   NOT NULL DEFAULT 0.000 after `status` , 
				CHANGE `how_many` `backupcount` tinyint(1) unsigned   NOT NULL DEFAULT 0 after `backuptime` , 
				DROP COLUMN `create_time` ,
				DROP KEY `PRIMARY`, ADD PRIMARY KEY(`id`) ;");
		}
		$result = $adb->query("SHOW KEYS FROM `vtiger_backup_settings` WHERE Key_name='param';");
		if (!$adb->num_rows($result)) {
			$adb->query("ALTER TABLE `vtiger_backup_settings` 
				CHANGE `type` `type` varchar(20)  NOT NULL first , 
				CHANGE `param` `param` varchar(20) NOT NULL after `type` , 
				CHANGE `value` `value` varchar(255) NOT NULL after `param` , 
				ADD KEY `param`(`param`) ;");
		}
		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_backup_tmp`(
			`id` int(19) unsigned NOT NULL  , 
			`status` tinyint(1) unsigned NOT NULL  DEFAULT 0 , 
			`allfiles` int(19) unsigned NOT NULL  DEFAULT 0 , 
			`b1` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b2` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b3` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b4` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b5` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b6` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b7` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b8` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`b9` decimal(5,2) NOT NULL  DEFAULT 0.00 , 
			`t1` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t2` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t3` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t4` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t5` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t6` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t7` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t8` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			`t9` decimal(8,3) NOT NULL  DEFAULT 0.000 , 
			PRIMARY KEY (`id`) , 
			KEY `status`(`status`) , 
			CONSTRAINT `vtiger_backup_tmp_ibfk_1` 
			FOREIGN KEY (`id`) REFERENCES `vtiger_backup` (`id`) ON DELETE CASCADE 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8' ;");
		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_accountbookmails`(
			`id` int(19) NULL  , 
			`email` varchar(100) NOT NULL  , 
			`name` varchar(100) NOT NULL  , 
			`users` text NOT NULL  , 
			KEY `email`(`email`,`name`) , 
			KEY `id`(`id`) , 
			CONSTRAINT `vtiger_accountbookmails_ibfk_1` 
			FOREIGN KEY (`id`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8' ;");
		$result = $adb->query("SHOW COLUMNS FROM `vtiger_contactsbookmails` LIKE 'id';");
		if (!$adb->num_rows($result)) {
			$adb->query("ALTER TABLE `vtiger_contactsbookmails` 
			CHANGE `contactid` `id` int(19)   NULL first , 
			CHANGE `email` `email` varchar(100)  COLLATE utf8_general_ci NOT NULL after `id` , 
			CHANGE `name` `name` varchar(100)  COLLATE utf8_general_ci NOT NULL after `email` , 
			CHANGE `users` `users` text  COLLATE utf8_general_ci NOT NULL after `name` , 
			DROP KEY `contactid`, ADD KEY `contactid`(`id`) , 
			DROP FOREIGN KEY `vtiger_contactsbookmails_ibfk_1`  ;");
			$adb->query("ALTER TABLE `vtiger_contactsbookmails`	ADD CONSTRAINT `vtiger_contactsbookmails_ibfk_1` FOREIGN KEY (`id`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE ;");
		}
		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_leadbookmails`(
			`id` int(19) NULL  , 
			`email` varchar(100) NOT NULL  , 
			`name` varchar(100) NOT NULL  , 
			`users` text NOT NULL  , 
			KEY `email`(`email`,`name`) , 
			KEY `id`(`id`) , 
			CONSTRAINT `vtiger_leadbookmails_ibfk_1` 
			FOREIGN KEY (`id`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_ossemployeesbookmails`(
			`id` int(19) NULL  , 
			`email` varchar(100) NOT NULL  , 
			`name` varchar(100) NOT NULL  , 
			`users` text NOT NULL  , 
			KEY `email`(`email`,`name`) , 
			KEY `id`(`id`) , 
			CONSTRAINT `vtiger_ossemployeesbookmails_ibfk_1` 
			FOREIGN KEY (`id`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");
		$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_vendorbookmails`(
			`id` int(19) NULL  , 
			`email` varchar(100) NOT NULL  , 
			`name` varchar(100) NOT NULL  , 
			`users` text NOT NULL  , 
			KEY `email`(`email`,`name`) , 
			KEY `id`(`id`) , 
			CONSTRAINT `vtiger_vendorbookmails_ibfk_1` 
			FOREIGN KEY (`id`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE 
		) ENGINE=InnoDB DEFAULT CHARSET='utf8';");

		$result = $adb->pquery("SHOW COLUMNS FROM `vtiger_module_dashboard`;");
		while ($row = $adb->fetch_array($result)) {
			$type = '';
			if ($row['Type']) {
				$type = $row['Type'];
			} else {
				$type = $row['type'];
			}
			if (($row['Field'] == 'filterid' || $row['field'] == 'filterid') && (strpos($type, 'varchar') === FALSE )) {
				$adb->query("ALTER TABLE `vtiger_module_dashboard` 
					CHANGE `id` `id` int(19)   NOT NULL auto_increment first , 
					CHANGE `blockid` `blockid` int(19)   NOT NULL after `id` , 
					CHANGE `filterid` `filterid` varchar(100)  COLLATE utf8_general_ci NULL after `linkid` , 
					CHANGE `limit` `limit` tinyint(2)   NULL after `size` , 
					CHANGE `isdefault` `isdefault` tinyint(1)   NOT NULL DEFAULT 0 after `limit`,
					DROP FOREIGN KEY `vtiger_module_dashboard_ibfk_1` ;");
				$adb->query("ALTER TABLE `vtiger_module_dashboard_widgets` 
					CHANGE `filterid` `filterid` varchar(100)  COLLATE utf8_general_ci NULL after `templateid` , 
					CHANGE `limit` `limit` tinyint(2)   NULL after `size` , 
					CHANGE `isdefault` `isdefault` tinyint(1)   NULL DEFAULT 0 after `position` , 
					CHANGE `active` `active` tinyint(1)   NULL DEFAULT 0 after `isdefault`;");
				break;
			}
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_module_dashboard_widgets` LIKE 'module';");
		if (!$adb->num_rows($result)) {
			$adb->query("ALTER TABLE `vtiger_module_dashboard_widgets` ADD COLUMN `module` int(10)   NULL DEFAULT 0 after `owners`;");
		}

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_role` LIKE 'changeowner';");
		if (!$adb->num_rows($result)) {
			$adb->query("ALTER TABLE `vtiger_role` 
					CHANGE `allowassignedrecordsto` `allowassignedrecordsto` tinyint(1)   NOT NULL DEFAULT 1 after `depth` , 
					ADD COLUMN `changeowner` tinyint(1) unsigned   NOT NULL DEFAULT 1 after `allowassignedrecordsto` , 
					ADD COLUMN `searchunpriv` text NULL after `changeowner` ;");
		}
		$adb->query("CREATE TABLE IF NOT EXISTS `yetiforce_proc_tc` (
				`type` varchar(30) DEFAULT NULL,
				`param` varchar(30) DEFAULT NULL,
				`value` varchar(200) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

		$result = $adb->query("SHOW COLUMNS FROM `vtiger_role` LIKE 'clendarallorecords';");
		if (!$adb->num_rows($result)) {
			$adb->query("ALTER TABLE `vtiger_role` ADD COLUMN `clendarallorecords` tinyint(1) unsigned NOT NULL DEFAULT 1 after `searchunpriv`;");
		}
		$log->debug("Exiting YetiForceUpdate::databaseSchema() method ...");
	}

	function databaseData()
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::databaseData() method ...");

		$adb->pquery("UPDATE `vtiger_eventhandlers` SET `event_name` = ? WHERE `event_name` = ?", ['vtiger.entity.unlink.before', 'vtiger.entity.beforeunlink']);
		$adb->pquery("UPDATE `vtiger_eventhandlers` SET `event_name` = ? WHERE `event_name` = ?", ['vtiger.entity.unlink.after', 'vtiger.entity.afterunlink']);

		$addHandler[] = ['vtiger.entity.link.after', 'modules/ModTracker/handlers/ModTrackerHandler.php', 'ModTrackerHandler', '', 1, '[]'];
		$addHandler[] = ['vtiger.entity.unlink.after', 'modules/ModTracker/handlers/ModTrackerHandler.php', 'ModTrackerHandler', '', 1, '[]'];
		$addHandler[] = ['user.logout.before', 'modules/Users/handlers/LogoutHandler.php', 'LogoutHandler', '', 1, '[]'];
		foreach ($addHandler as $handler) {
			if (!$em) {
				$em = new VTEventsManager($adb);
			}
			$result = $adb->pquery("SELECT * FROM `vtiger_eventhandlers` WHERE event_name = ? AND handler_class = ?;", [$handler[0], $handler[3]]);
			if ($adb->num_rows($result) == 0) {
				$em->registerHandler($handler[0], $handler[1], $handler[2], $handler[3], $handler[5]);
			}
		}
		$updateColumList = [];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_leaddetails:email:email:Leads_Email:E', 'after' => 'vtiger_leaddetails:email:email:Leads_Email:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_contactdetails:email:email:Contacts_Email:E', 'after' => 'vtiger_contactdetails:email:email:Contacts_Email:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_troubletickets:parent_id:parent_id:HelpDesk_Related_To:I', 'after' => 'vtiger_troubletickets:parent_id:parent_id:HelpDesk_Related_To:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_quotes:accountid:account_id:Quotes_Account_Name:I', 'after' => 'vtiger_quotes:accountid:account_id:Quotes_Account_Name:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_quotes:potentialid:potential_id:Quotes_Potential_Name:I', 'after' => 'vtiger_quotes:potentialid:potential_id:Quotes_Potential_Name:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_quotes:total:hdnGrandTotal:Quotes_Total:I', 'after' => 'vtiger_quotes:total:hdnGrandTotal:Quotes_Total:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_invoice:salesorderid:salesorder_id:Invoice_Sales_Order:I', 'after' => 'vtiger_invoice:salesorderid:salesorder_id:Invoice_Sales_Order:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_invoice:total:hdnGrandTotal:Invoice_Total:I', 'after' => 'vtiger_invoice:total:hdnGrandTotal:Invoice_Total:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_pricebook:currency_id:currency_id:PriceBooks_Currency:I', 'after' => 'vtiger_pricebook:currency_id:currency_id:PriceBooks_Currency:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_purchaseorder:vendorid:vendor_id:PurchaseOrder_Vendor_Name:I', 'after' => 'vtiger_purchaseorder:vendorid:vendor_id:PurchaseOrder_Vendor_Name:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_salesorder:accountid:account_id:SalesOrder_Account_Name:I', 'after' => 'vtiger_salesorder:accountid:account_id:SalesOrder_Account_Name:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_salesorder:quoteid:quote_id:SalesOrder_Quote_Name:I', 'after' => 'vtiger_salesorder:quoteid:quote_id:SalesOrder_Quote_Name:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_vendor:email:email:Vendors_Email:E', 'after' => 'vtiger_vendor:email:email:Vendors_Email:V'];
		$updateColumList[] = ['columnname' => '', 'before' => 'vtiger_faq:product_id:product_id:Faq_Product_Name:I', 'after' => 'vtiger_faq:product_id:product_id:Faq_Product_Name:V'];
		foreach ($updateColumList as $column) {
			$result = $adb->pquery("SELECT * FROM `vtiger_cvcolumnlist` WHERE columnname = ?;", [$column['before']]);
			if ($adb->num_rows($result) > 0) {
				$adb->pquery("UPDATE `vtiger_cvcolumnlist` SET `columnname` = ? WHERE `columnname` = ? ;", [$column['after'], $column['before']]);
			}
		}
		$result = $adb->pquery("SELECT * FROM `vtiger_backup_settings` WHERE `type` = ? AND `param` = ?;", ['folder', 'storage_folder']);
		if ($adb->num_rows($result) == 2) {
			$adb->pquery("UPDATE `vtiger_backup_settings` SET `param` = ? WHERE `type` = ? AND `param` = ? LIMIT 1 ;", ['backup_folder', 'folder', 'storage_folder']);
		}
		$result = $adb->pquery("SELECT * FROM `vtiger_backup_settings` WHERE `type` = ? AND `param` = ?;", ['notifications', 'users']);
		if ($adb->num_rows($result) == 0) {
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['notifications', 'users', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['main', 'type', 'false']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'host', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'login', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'password', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'port', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'path', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'active', '']);
			$adb->pquery("insert  into `vtiger_backup_settings`(`type`,`param`,`value`) values (?,?,?);", ['ftp', 'status', '']);
		}

		$sql = "SELECT tabid  FROM `vtiger_tab` WHERE `name` = 'PriceBooks';";
		$result = $adb->query($sql);
		$id = $adb->query_result($result, 0, 'actionid');
		$sql = "SELECT * FROM `vtiger_actionmapping` WHERE `actionname` IN ('Export','Import','DuplicatesHandling');";
		$result = $adb->query($sql);
		$num = $adb->num_rows($result);
		for ($k = 0; $k < $num; $k++) {
			$key = $adb->query_result_raw($result, $k, 'actionid');
			$action = $adb->query_result_raw($result, $k, 'actionname');
			$permission = 1;
			if ($action == 'DuplicatesHandling') {
				$permission = 0;
			}
			$resultP = $adb->query("SELECT profileid FROM vtiger_profile;");
			$numP = $adb->num_rows($resultP);
			for ($i = 0; $i < $numP; $i++) {
				$profileId = $adb->query_result_raw($resultP, $i, 'profileid');
				$resultQ = $adb->pquery("SELECT * FROM vtiger_profile2utility WHERE profileid = ? AND tabid = ? AND activityid = ?;", [$profileId, $id, $key]);
				if ($adb->num_rows($resultQ)) {
					$adb->pquery("INSERT INTO vtiger_profile2utility (profileid, tabid, activityid, permission) VALUES  (?, ?, ?, ?)", [$profileId, $id, $key, $permission]);
				}
			}
		}
		$result = $adb->pquery("SELECT * FROM `vtiger_no_of_currency_decimals` WHERE `no_of_currency_decimals` = 0;");
		if (!$adb->num_rows($result)) {
			$adb->query("insert  into `vtiger_no_of_currency_decimals`(`no_of_currency_decimalsid`,`no_of_currency_decimals`,`sortorderid`,`presence`) values (0,'0',0,1)");
			$adb->query("insert  into `vtiger_no_of_currency_decimals`(`no_of_currency_decimalsid`,`no_of_currency_decimals`,`sortorderid`,`presence`) values (1,'1',1,1)");
		}
		$this->picklists();

		$adb->pquery("UPDATE `vtiger_field` SET `generatedtype` = ?, `presence` = ?, `typeofdata` = ?, `quickcreate` = ? WHERE `columnname` = ? AND `tablename` = ?;", [1, 2, 'V~M', 2, 'related_to', 'vtiger_potential']);

		$adb->pquery("UPDATE `vtiger_ossmailtemplates_type` SET `presence` = 0 WHERE `ossmailtemplates_type` IN (?,?) ;", ['PLL_RECORD', 'PLL_MAIL']);

		$adb->pquery("UPDATE `vtiger_relatedlists` SET actions = '' WHERE tabid = ? AND related_tabid = ? AND name = ?;", [getTabid('Quotes'), getTabid('Calculations'), 'get_related_list']);
		$adb->pquery("UPDATE `com_vtiger_workflow_tasktypes` SET modules = ? WHERE tasktypename = ?;", ['{"include":["Contacts","OSSEmployees","Accounts","Leads","Vendors"],"exclude":[]}', 'VTAddressBookTask']);
		$adb->pquery("UPDATE `vtiger_links` 
			SET
			  linkicon = (
				CASE
				  WHEN linkicon = 'icon-file' 
				  THEN 'glyphicon glyphicon-file' 
				  WHEN linkicon = 'icon-align-justify' 
				  THEN 'glyphicon glyphicon-align-justify'
				  WHEN linkicon = 'icon-tasks' 
				  THEN 'glyphicon glyphicon-tasks'
				  WHEN linkicon = 'icon-user' 
				  THEN 'glyphicon glyphicon-user'
				  ELSE linkicon 
				END
			  ) 
			WHERE linkicon IN ('icon-file','icon-align-justify','icon-tasks','icon-user');");
		$result = $adb->pquery("SELECT * FROM `vtiger_osspdf` WHERE `title` = 'Calculation PDF' AND `content` = '';");
		if ($adb->num_rows($result)) {
			$adb->pquery("UPDATE `vtiger_osspdf` SET `content` = ? WHERE `title` = ?;", ['<title></title>
<table width="537px">
	<tbody>
		<tr>
			<td colspan="6" rowspan="2"><img src="#special_function#siteUrl#end_special_function#storage/Logo/logo_yetiforce.png" style="width: 200px;" width="200" /></td>
			<td colspan="4"><span style="font-size:6px;">#company_organizationname# #company_address# #company_code# #company_city#. VAT:#company_vatid#</span></td>
		</tr>
		<tr>
			<td colspan="5">
			<table border="1">
				<tbody>
					<tr>
						<td>
						<table cellpadding="1">
							<tbody>
								<tr>
									<td style="text-align: center;"><span style="font-size:9px;">Calculation confirmation: <strong>#calculations_no#</strong></span></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td>
						<table cellpadding="1">
							<tbody>
								<tr>
									<td style="text-align: center;"><span style="font-size:9px;">Date: #special_function#CreatedDateTime#end_special_function#</span></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">&nbsp;</td>
			<td colspan="5" rowspan="2">
			<table border="1">
				<tbody>
					<tr>
						<td>
						<table cellpadding="5">
							<tbody>
								<tr>
									<td>
									<table cellpadding="0" style="font-size:8px;">
										<tbody>
											<tr>
												<td colspan="2">Issued by:</td>
												<td colspan="3">#Users_first_name# #Users_last_name#</td>
											</tr>
											<tr>
												<td colspan="2">Email:</td>
												<td colspan="3">#Users_email1#</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<table>
				<tbody>
					<tr>
						<td><span style="font-size:10px;">&nbsp;<span style="font-size:8px;">#Accounts_account_no#</span></span></td>
					</tr>
					<tr>
						<td>
						<table>
							<tbody>
								<tr>
									<td>
									<p><span style="font-size:10px;">#Accounts_accountname#<br />
									<span style="font-size:8px;">#Accounts_addresslevel8b# #Accounts_buildingnumberb# #Accounts_localnumberb#<br />
									#Accounts_addresslevel7b#, #Accounts_addresslevel5b#<br />
									<span style="font-size:10px;">#Accounts_addresslevel1b#</span><br />
									#Accounts_vat_id#</span></span></p>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
			<td colspan="3">&nbsp;</td>
		</tr>
	</tbody>
</table>
&nbsp;

<table>
	<tbody>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>#special_function#replaceProductTable#end_special_function#</td>
		</tr>
	</tbody>
</table>', 'Calculation PDF']);
			$adb->pquery("UPDATE `vtiger_osspdf` SET `footer_content` = '' WHERE `title` = ?;", ['Calculation PDF']);
		}
		$result = $adb->pquery("SELECT * FROM `yetiforce_proc_marketing` WHERE `param` = 'create_always';");
		if (!$adb->num_rows($result)) {
			$adb->query("insert  into `yetiforce_proc_marketing`(`type`,`param`,`value`) values ('conversion','create_always','false')");
		}

		$adb->pquery("UPDATE `vtiger_field` SET `fieldlabel` = ? WHERE `columnname` = ? AND `tablename` = ?;", ['Id', 'id', 'vtiger_ossmailview']);
		$adb->pquery("UPDATE `vtiger_def_org_share` SET `editstatus` = ? WHERE `ruleid` = ? AND `tabid` = ?;", [0, 5, getTabid('Calendar')]);

		$actions = [26 => 'Dashboard', 27 => 'CreateDashboardFilter', 28 => 'QuickExportToExcel'];
		foreach ($actions as $key => $action) {
			$result = $adb->pquery('SELECT actionid FROM vtiger_actionmapping WHERE actionname=?;', [$action]);
			if ($adb->num_rows($result) == 0) {
				$adb->pquery("INSERT INTO `vtiger_actionmapping` (`actionid`, `actionname`, `securitycheck`) VALUES (?, ?,'0');", [$key, $action]);
			}
			$sql = "SELECT tabid, `name`  FROM `vtiger_tab` WHERE `isentitytype` = '1' AND `name` not in ('SMSNotifier','ModComments','PBXManager','Events','Emails','CallHistory','OSSMailView','');";
			$result = $adb->query($sql);

			$resultP = $adb->query("SELECT profileid FROM vtiger_profile;");
			for ($i = 0; $i < $adb->num_rows($resultP); $i++) {
				$profileId = $adb->query_result_raw($resultP, $i, 'profileid');
				for ($k = 0; $k < $adb->num_rows($result); $k++) {
					$row = $adb->query_result_rowdata($result, $k);
					$tabid = $row['tabid'];
					$resultC = $adb->pquery("SELECT activityid FROM vtiger_profile2utility WHERE profileid=? AND tabid=? AND activityid=? ;", [$profileId, $tabid, $key]);
					if ($adb->num_rows($resultC) == 0) {
						$adb->pquery("INSERT INTO vtiger_profile2utility (profileid, tabid, activityid, permission) VALUES  (?, ?, ?, ?)", array($profileId, $tabid, $key, 0));
					}
				}
			}
		}

		$result = $adb->pquery("SELECT * FROM `vtiger_osspdf`");
		$pdfContent = $this->pdfContent();
		while ($row = $adb->fetch_array($result)) {
			if (array_key_exists($row['title'], $pdfContent) && strpos($row['content'], '#Contacts_lastname#') !== FALSE) {
				$adb->pquery("UPDATE `vtiger_osspdf` SET `content` = ? WHERE `title` = ? ;", [$pdfContent[$row['title']], $row['title']]);
			}
		}
		$result = $adb->pquery("SELECT * FROM `vtiger_calendar_config` WHERE `type` = ? AND `name` = ? ", ['colors', 'Call']);
		if (!$adb->num_rows($result)) {
			$adb->query("insert  into `vtiger_calendar_config`(`type`,`name`,`label`,`value`) values ('colors','Call','Call','#80B584');");
		}
		$result = $adb->query('SELECT MAX(linkid) AS max_linkId FROM `vtiger_links`;');
		$maxLink = $adb->query_result_rowdata($result, 0);
		if ($maxLink[0]) {
			$maxLink = $maxLink[0];
		} else {
			$maxLink = $maxLink['max_linkId'];
		}
		$adb->pquery("UPDATE `vtiger_links_seq` SET `id` = " . $maxLink . ";");

		//sequance
		$adb->pquery("UPDATE `vtiger_field` SET `quickcreatesequence` = ? WHERE `tabid` = ? AND `columnname` = ?;", [7, getTabid('HelpDesk'), 'smownerid']);
		$adb->pquery("UPDATE `vtiger_field` SET `quickcreatesequence` = ? WHERE `tabid` = ? AND `columnname` = ?;", [2, getTabid('HelpDesk'), 'parent_id']);
		$adb->pquery("UPDATE `vtiger_field` SET `quickcreatesequence` = ? WHERE `tabid` = ? AND `columnname` = ?;", [5, getTabid('HelpDesk'), 'priority']);
		$adb->pquery("UPDATE `vtiger_field` SET `quickcreatesequence` = ? WHERE `tabid` = ? AND `columnname` = ?;", [4, getTabid('HelpDesk'), 'status']);
		$adb->pquery("UPDATE `vtiger_field` SET `quickcreatesequence` = ? WHERE `tabid` = ? AND `columnname` = ?;", [6, getTabid('HelpDesk'), 'description']);
		$adb->pquery("UPDATE `vtiger_field` SET `quickcreatesequence` = ? WHERE `tabid` = ? AND `columnname` = ?;", [3, getTabid('HelpDesk'), 'projectid']);

		$adb->pquery("UPDATE `vtiger_field` SET `typeofdata` = ? WHERE `tabid` = ? AND `columnname` = ?;", ['V~M', getTabid('SalesOrder'), 'recurring_frequency']);
		$adb->pquery("UPDATE `vtiger_field` SET `typeofdata` = ? WHERE `tabid` = ? AND `columnname` = ?;", ['D~M', getTabid('SalesOrder'), 'start_period']);
		$adb->pquery("UPDATE `vtiger_field` SET `typeofdata` = ? WHERE `tabid` = ? AND `columnname` = ?;", ['D~M~OTH~G~start_period~Start Period', getTabid('SalesOrder'), 'end_period']);
		$adb->pquery("UPDATE `vtiger_field` SET `typeofdata` = ? WHERE `tabid` = ? AND `columnname` = ?;", ['V~M', getTabid('SalesOrder'), 'payment_duration']);

		$adb->pquery("UPDATE `vtiger_field` SET `summaryfield` = ? WHERE `tabid` = ? AND `columnname` = ?;", [0, getTabid('OSSPasswords'), 'link_adres']);

		$adb->pquery("UPDATE `vtiger_field` SET `generatedtype` = ? WHERE `tabid` = ? AND `columnname` = ?;", [1, getTabid('Contacts'), 'smownerid']);

		$adb->pquery("UPDATE `vtiger_field` 
					SET	fieldlabel = (
						CASE
						  WHEN columnname = 'name' 
						  THEN 'LBL_ATTACHMENT' 
						  WHEN columnname = 'from_email' 
						  THEN 'LBL_FROM' 
						  WHEN columnname = 'to_email' 
						  THEN 'LBL_TO' 
						  WHEN columnname = 'cc_email' 
						  THEN 'LBL_CC' 
						  WHEN columnname = 'bcc_email' 
						  THEN 'LBL_BCC' 
						  ELSE fieldlabel 
						END
					  ) 
					WHERE tabid = ? AND columnname IN ('name','from_email','to_email','cc_email','bcc_email');", [getTabid('Emails')]);

		$adb->pquery("UPDATE `com_vtiger_workflows` SET `test` = ? WHERE `module_name` = ? AND `summary` = ?;", ['[{"fieldname":"(related_to : (HelpDesk) from_portal)","operation":"is","value":"1","valuetype":"rawtext","joincondition":"","groupjoin":"and","groupid":"0"}]', 'ModComments', 'New comment added to ticket from portal']);

		$adb->pquery("UPDATE `vtiger_field` SET `fieldlabel` = ? WHERE `fieldlabel` = ?;", ['Verification data', 'Werification data']);

		$result = $adb->pquery("SELECT * FROM `vtiger_settings_field` WHERE `name` = ? ", ['LBL_TIMECONTROL_PROCESSES']);
		if (!$adb->num_rows($result)) {
			$blockid = $adb->query_result(
				$adb->pquery("SELECT blockid FROM vtiger_settings_blocks WHERE label='LBL_PROCESSES'", array()), 0, 'blockid');
			$sequence = (int) $adb->query_result($adb->pquery("SELECT max(sequence) as sequence FROM vtiger_settings_field WHERE blockid=?", array($blockid)), 0, 'sequence') + 1;
			$fieldid = $adb->getUniqueId('vtiger_settings_field');
			$adb->pquery("INSERT INTO vtiger_settings_field (fieldid,blockid,sequence,name,iconpath,description,linkto)
			VALUES (?,?,?,?,?,?,?)", array($fieldid, $blockid, $sequence, 'LBL_TIMECONTROL_PROCESSES', '', 'LBL_TIMECONTROL_PROCESSES_DESCRIPTION', 'index.php?module=TimeControlProcesses&parent=Settings&view=Index'));

			$adb->pquery("insert  into `yetiforce_proc_tc`(`type`,`param`,`value`) values ('general','oneDay','false');");
			$adb->pquery("insert  into `yetiforce_proc_tc`(`type`,`param`,`value`) values ('general','timeOverlap','false')");
		}

		$result = $adb->pquery("SELECT * FROM `yetiforce_proc_marketing` WHERE `type` = ? AND `param` =? ;", ['conversion', 'mapping']);
		if (!$adb->num_rows($result)) {
			$adb->pquery("insert  into `yetiforce_proc_marketing`(`type`,`param`,`value`) values (?,?,?);", ['conversion', 'mapping', '[{"company":"accountname"}]']);
		}

		$adb->pquery("UPDATE `vtiger_currencies` SET `currency_symbol` = ? WHERE `currency_name` = ?;", ['₽', 'Russia, Rubles']);

		$adb->query('delete from vtiger_def_org_share where tabid NOT IN (SELECT tabid FROM `vtiger_field`)');

		$result = $adb->pquery("SELECT * FROM `vtiger_def_org_share` WHERE `tabid` IN (?,?) ", [getTabid('Faq'), getTabid('PriceBooks')]);
		if (!$adb->num_rows($result)) {
			$moduleInstance = Vtiger_Module::getInstance('Faq');
			Vtiger_Access::setDefaultSharing($moduleInstance, 'public_readwritedelete');
			Vtiger_Access::initSharing($moduleInstance);
			$moduleInstance = Vtiger_Module::getInstance('PriceBooks');
			Vtiger_Access::setDefaultSharing($moduleInstance, 'public_readwritedelete');
			Vtiger_Access::initSharing($moduleInstance);
		}

		$this->rebootSeq();

		$languageInformation = ['prefix' => 'nl_nl', 'label' => 'Dutch'];
		$result = $adb->pquery('SELECT * FROM `vtiger_language` WHERE `prefix` = ?;', ['nl_nl']);
		if (!$adb->num_rows($result)) {
			$adb->pquery('INSERT INTO vtiger_language (id,name,prefix,label,lastupdated,isdefault,active) VALUES(?,?,?,?,?,?,?)', [$adb->getUniqueId('vtiger_language'), $languageInformation['label'], $languageInformation['prefix'],
				$languageInformation['label'], date('Y-m-d H:i:s'), 0, 1]);
		}

		$actions = ['Import', 'Export', 'DuplicatesHandling', 'Dashboard', 'CreateDashboardFilter'];
		foreach ($actions as $action) {
			$result = $adb->pquery('SELECT actionid FROM vtiger_actionmapping WHERE actionname=?;', [$action]);
			if ($adb->num_rows($result) == 0) {
				continue;
			} else {
				$actionId = $adb->query_result_raw($result, 0, 'actionid');
			}
			$tabids = [];
			if (in_array($action, ['Import', 'Export', 'DuplicatesHandling'])) {
				$tabids[] = getTabid('PriceBooks');
			} else {
				$tabids[] = getTabid('OSSMailView');
				$tabids[] = getTabid('CallHistory');
			}
			$permission = 0;
			if (in_array($action, ['Import', 'Export'])) {
				$permission = 1;
			}
			$resultP = $adb->query("SELECT profileid FROM vtiger_profile;");
			for ($i = 0; $i < $adb->num_rows($resultP); $i++) {
				$profileId = $adb->query_result_raw($resultP, $i, 'profileid');
				foreach ($tabids as $tabid) {
					$resultC = $adb->pquery("SELECT activityid FROM vtiger_profile2utility WHERE profileid=? AND tabid=? AND activityid=? ;", [$profileId, $tabid, $actionId]);
					if ($adb->num_rows($resultC) == 0) {
						$adb->pquery("INSERT INTO vtiger_profile2utility (profileid, tabid, activityid, permission) VALUES  (?, ?, ?, ?)", array($profileId, $tabid, $actionId, $permission));
					}
				}
			}
		}

		$adb->query("UPDATE `yetiforce_menu` SET `label` = 'MEN_COMPANIES_CONTACTS' WHERE `label` = 'MEN_LEADS' AND `role` = 0;");
		$adb->pquery("UPDATE `yetiforce_menu` SET `sequence` = '24' WHERE `module` = ? AND `role` = 0 AND `type` = 0;", [getTabid('NewOrders')]);
		$adb->pquery("UPDATE `yetiforce_menu` SET `sequence` = '23' WHERE `module` = ? AND `role` = 0 AND `type` = 0;", [getTabid('Reports')]);

		$modules = [getTabid('Rss') => [0, 84, 0, 20, getTabid('Rss'), NULL, 0, NULL, 0, NULL, NULL, ''], getTabid('Portal') => [0, 84, 0, 21, getTabid('Portal'), NULL, 0, NULL, 0, NULL, NULL, ''], 'isNull' => [0, 84, 3, 22, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL]];
		$result2 = $adb->pquery('SELECT * FROM yetiforce_menu WHERE role = ? AND `label` = ? AND parentid = ?;', [0, 'MEN_DATABESES', 0]);
		$parent = (int) $adb->query_result_raw($result2, 0, 'id');
		foreach ($modules as $tabid => $params) {
			if ($tabid != 'isNull') {
				$result = $adb->pquery("SELECT * FROM `yetiforce_menu` WHERE `type` = ? AND `role` =? AND `module` = ? AND parentid = ?;", [0, 0, $tabid, $parent]);
			} else {
				$result = $adb->pquery("SELECT * FROM `yetiforce_menu` WHERE `type` = ? AND `role` =? AND parentid = ? AND `module` IS NULL ;", [3, 0, $parent]);
			}
			if (!$adb->num_rows($result) || $adb->num_rows($result) == 3) {
				$params[1] = $parent;
				$adb->pquery("insert  into `yetiforce_menu`(`role`,`parentid`,`type`,`sequence`,`module`,`label`,`newwindow`,`dataurl`,`showicon`,`icon`,`sizeicon`,`hotkey`) values (" . generateQuestionMarks($params) . ");", $params);
			}
		}

		$adb->query('delete from vtiger_def_org_share where tabid NOT IN (SELECT tabid FROM `vtiger_field`)');

		$adb->query('delete from vtiger_backup;');
		$adb->query('delete from vtiger_backup_db;');
		$adb->query('delete from vtiger_backup_files;');
		$adb->query('delete from vtiger_backup_tmp;');

		$adb->query("ALTER TABLE `vtiger_contactdetails` 
					CHANGE `contactstatus` `contactstatus` varchar(255) NULL DEFAULT '' after `notifilanguage` , 
					CHANGE `jobtitle` `jobtitle` varchar(100) NULL DEFAULT '' after `dav_status`;");

		$adb->query("UPDATE `vtiger_users` SET `theme` = 'twilight';");

		$result1 = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ? AND tabid = ? ;", ['process', 'vtiger_activity', getTabid('Calendar')]);
		$fieldId = $adb->query_result($result1, 0, 'fieldid');
		if ($fieldId) {
			$rel = ['HelpDesk', 'Campaigns', 'Potentials'];
			$adb->pquery('delete from vtiger_fieldmodulerel WHERE fieldid = ?;', [$fieldId]);
			foreach ($rel as $relmodule) {
				$adb->pquery("insert  into `vtiger_fieldmodulerel`(`fieldid`,`module`,`relmodule`) values (?,?,?);", [$fieldId, 'Calendar', $relmodule]);
			}
		}
		$result1 = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ? AND tabid = ? ;", ['link', 'vtiger_activity', getTabid('Calendar')]);
		$fieldId = $adb->query_result($result1, 0, 'fieldid');
		if ($fieldId) {
			$rel = ['Contacts', 'Leads', 'OSSEmployees', 'Vendors', 'Accounts'];
			$adb->pquery('delete from vtiger_fieldmodulerel WHERE fieldid = ?;', [$fieldId]);
			foreach ($rel as $relmodule) {
				$adb->pquery("insert  into `vtiger_fieldmodulerel`(`fieldid`,`module`,`relmodule`) values (?,?,?);", [$fieldId, 'Calendar', $relmodule]);
			}
		}
		// add new field
		$result = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ? AND tabid = ? ;", ['sum_time', 'vtiger_account', getTabid('Accounts')]);
		if (!$adb->num_rows($result)) {
			$moduleInstance = Vtiger_Module::getInstance('Accounts');
			$blockInstance = Vtiger_Block::getInstance('LBL_FINANSIAL_SUMMARY', $moduleInstance);
			$fieldInstance = new Vtiger_Field();
			$fieldInstance->name = 'sum_time';
			$fieldInstance->table = 'vtiger_account';
			$fieldInstance->label = 'Total time [h]';
			$fieldInstance->column = 'sum_time';
			$fieldInstance->columntype = 'decimal(10,2)';
			$fieldInstance->uitype = 7;
			$fieldInstance->displaytype = 10;
			$fieldInstance->typeofdata = 'NN~O';
			$blockInstance->addField($fieldInstance);
		}

		$adb->pquery('delete from vtiger_ws_referencetype WHERE `fieldtypeid` = ? AND `type` = ?;', [31, 'Campaigns']);

		$result = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ? AND tabid = ? ;", ['legal_form', 'vtiger_leaddetails', getTabid('Leads')]);
		$leadfid = $adb->query_result($result, 0, 'fieldid');
		if ($leadfid) {
			$result = $adb->pquery("SELECT * FROM `vtiger_convertleadmapping` WHERE leadfid = ?;", [$leadfid]);
			if (!$adb->num_rows($result)) {
				$result = $adb->pquery("SELECT fieldid FROM `vtiger_field` WHERE columnname = ? AND tablename = ? AND tabid = ? ;", ['legal_form', 'vtiger_account', getTabid('Accounts')]);
				$accountfid = $adb->query_result($result, 0, 'fieldid');
				$query = "INSERT INTO vtiger_convertleadmapping (leadfid, accountfid, contactfid, potentialfid, editable) values (?,?,?,?,?);";
				$adb->pquery($query, array($leadfid, $accountfid, 0, 0, 1));
			}
		}

		$result = $adb->query('SELECT accountid FROM `vtiger_account` INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_account.accountid WHERE vtiger_crmentity.deleted=0;');
		$num = $adb->num_rows($result);
		for ($i = 0; $i < $num; $i++) {
			$accountId = $adb->query_result($result, $i, 'accountid');
			$adb->query("UPDATE `vtiger_account` SET `sum_time` = (SELECT SUM(sum_time) FROM vtiger_osstimecontrol
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_osstimecontrol.osstimecontrolid
				WHERE vtiger_crmentity.deleted=0 AND  vtiger_osstimecontrol.accountid = " . $accountId . " AND osstimecontrol_status = '" . 'Accepted' . "') WHERE vtiger_account.accountid = " . $accountId . " ;");
		}

		$result = $adb->query("SELECT * FROM `vtiger_crmentity` WHERE `label` = 'Send Notification Email to Record Owner' AND `searchlabel` = 'Send Notification Email to Record Owner';");
		$num = $adb->num_rows($result);
		if ($num > 1) {
			$result = $adb->query("SELECT ossmailtemplatesid FROM `vtiger_ossmailtemplates` WHERE `name` = 'Send invitations';");
			$ossmailtemplatesid = $adb->query_result($result, 0, 'ossmailtemplatesid');
			$adb->pquery("UPDATE `vtiger_crmentity` SET `label` = ?, `searchlabel` = ? WHERE `crmid` = ? ;", ['Send invitations', 'Send invitations', $ossmailtemplatesid]);
		}
		$result = $adb->query('SELECT * FROM `vtiger_module_dashboard_widgets` WHERE `module` NOT IN (0)');
		if (!$adb->num_rows($result)) {
			$adb->query("UPDATE `vtiger_module_dashboard_widgets` w, `vtiger_links` l SET `module` = l.tabid WHERE w.linkid = l.linkid;");
		}
		$this->addFields();
		$log->debug("Exiting YetiForceUpdate::databaseData() method ...");
	}

	public function addFields(){
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::addFields() method ...");
		include_once('vtlib/Vtiger/Module.php'); 
		
		$columnName = array("tabid","id","column","table","generatedtype","uitype","name","label","readonly","presence","defaultvalue","maximumlength","sequence","block","displaytype","typeofdata","quickcreate","quicksequence","info_type","masseditable","helpinfo","summaryfield","fieldparams","columntype","blocklabel","setpicklistvalues","setrelatedmodules");

		$Calculations = array(
		array('70','1748','productid','vtiger_calculationsproductrel','1','10','productid','Item Name','0','2','','100','1','113','5','V~M','1',NULL,'BAS','0','','0','',"int(19)","LBL_ITEM_DETAILS",[],['Products','Services']),
		array('70','1749','quantity','vtiger_calculationsproductrel','1','7','quantity','Quantity','0','2','','100','2','113','5','N~O','1',NULL,'BAS','0','','0','',"decimal(25,3)","LBL_ITEM_DETAILS",[],[]),
		array('70','1750','listprice','vtiger_calculationsproductrel','1','71','listprice','List Price','0','2','','100','3','113','5','N~O','1',NULL,'BAS','0','','0','',"decimal(27,8)","LBL_ITEM_DETAILS",[],[]),
		array('70','1751','subtotal','vtiger_calculations','1','72','hdnSubTotal','Sub Total','1','2','','100','14','190','3','N~O','3','0','BAS','1','','0','',"decimal(25,8)","",[],[]),
		array('70','1752','pre_tax_total','vtiger_calculations','1','72','pre_tax_total','Pre Tax Total','1','2','','100','23','185','3','N~O','1',NULL,'BAS','1','','0','',"decimal(25,8)","LBL_PRODUCT_INFORMATION",[],[])
		);
		$OSSCosts = array(
		array('71','1753','productid','vtiger_inventoryproductrel','1','10','productid','Item Name','0','2','','100','1','188','5','V~M','1',NULL,'BAS','0','','0','',"int(19)","LBL_CUSTOM_INFORMATION",[],['Products','Services']),
		array('71','1754','quantity','vtiger_inventoryproductrel','1','7','quantity','Quantity','0','2','','100','2','188','5','N~O','1',NULL,'BAS','0','','0','',"decimal(25,3)","LBL_CUSTOM_INFORMATION",[],[]),
		array('71','1755','listprice','vtiger_inventoryproductrel','1','71','listprice','List Price','0','2','','100','3','188','5','N~O','1',NULL,'BAS','0','','0','',"decimal(27,8)","LBL_CUSTOM_INFORMATION",[],[]),
		);
		
		$setToCRM = array('Calculations'=>$Calculations,'OSSCosts'=>$OSSCosts);

		$setToCRMAfter = array();
		foreach($setToCRM as $nameModule=>$module){
			if(!$module)
				continue;
			foreach($module as $key=>$fieldValues){
				for($i=0;$i<count($fieldValues);$i++){
					$setToCRMAfter[$nameModule][$key][$columnName[$i]] = $fieldValues[$i];
				}
			}
		}
		foreach($setToCRMAfter as $moduleName=>$fields){
			foreach($fields as $field){
				if(self::checkFieldExists($field, $moduleName)){
					continue;
				}
				$moduleInstance = Vtiger_Module::getInstance($moduleName);
				$blockInstance = Vtiger_Block::getInstance($field['blocklabel'],$moduleInstance);
				$id = $adb->getUniqueID('vtiger_field');
				if($blockInstance){
					$blockId = $blockInstance->id;
				}else{
					$blockId = $field['block'];
				}
				$adb->pquery("INSERT INTO vtiger_field (tabid, fieldid, columnname, tablename, generatedtype,
				uitype, fieldname, fieldlabel, readonly, presence, defaultvalue, maximumlength, sequence,
				block, displaytype, typeofdata, quickcreate, quickcreatesequence, info_type, helpinfo, summaryfield, fieldparams,masseditable) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [getTabid($moduleName), $id, $field['column'], $field['table'], $field['generatedtype'],
							$field['uitype'], $field['name'], $field['label'], $field['readonly'], $field['presence'], $field['defaultvalue'],
							$field['maximumlength'],$field['sequence'], $blockId, $field['displaytype'], $field['typeofdata'],
							$field['quickcreate'], $field['quicksequence'],$field['info_type'], $field['helpinfo'], $field['summaryfield'], $field['fieldparams'], $field['masseditable']]);
				if (!empty($field['columntype']) && in_array($field['column'],['subtotal','pre_tax_total'])) {
					$columntype = $field['columntype'];
					if ($field['uitype'] == 10)
						$columntype .= ', ADD INDEX (`' . $field['column'] . '`)';
					Vtiger_Utils::AddColumn($field['table'], $field['column'], $columntype);
				}
				if($field['setrelatedmodules'] && $field['uitype'] == 10){
					$this->setRelatedModules($field['setrelatedmodules'],$id,$moduleName);
				}
			}
		}
		$log->debug("Exiting YetiForceUpdate::addFields() method ...");
	}
	function setRelatedModules($moduleNames,$id,$moduleName)
	{
		global $log, $adb;
		if (count($moduleNames) == 0) {
			$log->debug("Setting (setRelatedModules) relation ERROR: No module names");
			return false;
		}
		// We need to create core table to capture the relation between the field and modules.
		if (!Vtiger_Utils::CheckTable('vtiger_fieldmodulerel')) {
			Vtiger_Utils::CreateTable(
				'vtiger_fieldmodulerel', '(fieldid INT NOT NULL, module VARCHAR(100) NOT NULL, relmodule VARCHAR(100) NOT NULL, status VARCHAR(10), sequence INT)', true
			);
		}
		// END
		foreach ($moduleNames as $relmodule) {
			$checkres = $adb->pquery('SELECT * FROM vtiger_fieldmodulerel WHERE fieldid=? AND module=? AND relmodule=?', [$id, $moduleName, $relmodule]);
			// If relation already exist continue
			if ($adb->num_rows($checkres))
				continue;
			$adb->pquery('INSERT INTO vtiger_fieldmodulerel(fieldid, module, relmodule) VALUES(?,?,?)', [$id, $moduleName, $relmodule]);
			$log->debug("Setting $moduleName relation with $relmodule ... DONE");
		}
		return true;
	}
	public function checkFieldExists($field, $moduleName){
		global $adb;
		if($moduleName == 'Settings')
			$result = $adb->pquery("SELECT * FROM vtiger_settings_field WHERE name = ? AND linkto = ? ;", array($field[1],$field[4]));
		else
			$result = $adb->pquery("SELECT * FROM vtiger_field WHERE columnname = ? AND tablename = ? AND tabid = ?;", array($field['column'],$field['table'], getTabid($moduleName)));
		if(!$adb->num_rows($result)) {
			return false;
		}
		return true;
	}
	
	public function rebootSeq()
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::rebootSeq() method ...");
		$rebootSeq['osscosts_no'] = 3;
		$rebootSeq['smownerid'] = 2;
		$rebootSeq['name'] = 1;
		$rebootSeq['parentid'] = 4;
		$rebootSeq['potentialid'] = 5;
		$rebootSeq['projectid'] = 6;
		$rebootSeq['ticketid'] = 7;
		$rebootSeq['relategid'] = 8;
		$rebootSeq['street'] = 1;
		$rebootSeq['code'] = 3;
		$rebootSeq['city'] = 4;
		$rebootSeq['country'] = 5;
		$rebootSeq['state'] = 6;
		$rebootSeq['createdtime'] = 1;
		$rebootSeq['modifiedtime'] = 2;
		$rebootSeq['modifiedby'] = 3;
		$rebootSeq['description'] = 1;
		$rebootSeq['total'] = 13;
		$rebootSeq['subtotal'] = 14;
		$rebootSeq['taxtype'] = 14;
		$rebootSeq['discount_percent'] = 14;
		$rebootSeq['discount_amount'] = 14;
		$rebootSeq['currency_id'] = 20;
		$rebootSeq['conversion_rate'] = 21;
		$rebootSeq['pre_tax_total'] = 23;
		$rebootSeq['attention'] = 2;
		$rebootSeq['total_purchase'] = 4;
		$rebootSeq['total_margin'] = 5;
		$rebootSeq['total_marginp'] = 6;
		$rebootSeq['inheritsharing'] = 1;
		$rebootSeq['shownerid'] = 2;
		$rebootSeq['closedtime'] = 7;
		$rebootSeq['was_read'] = 9;

		$query = 'UPDATE vtiger_field SET ';
		$query .=' sequence = CASE ';
		foreach ($rebootSeq as $field => $sequence) {
			$query .= ' WHEN columnname="' . $field . '" THEN ' . $sequence;
		}
		$query .=' ELSE sequence END ';
		$query .= ' WHERE tabid = ?';
		$adb->pquery($query, [getTabid('OSSCosts')]);
		$log->debug("Exiting YetiForceUpdate::rebootSeq() method ...");
	}

	function picklists()
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::picklists() method ...");

		$addPicklists = [];
		$addPicklists['OSSMailTemplates'][] = ['name' => 'ossmailtemplates_type', 'uitype' => '16', 'add_values' => ['PLL_MAIL', 'PLL_LIST'], 'remove_values' => []];
		$addPicklists['Calculations'][] = ['name' => 'calculations_cons', 'uitype' => '33', 'add_values' => ['PLL_LONGTERM_REALIZATION'], 'remove_values' => []];
		$addPicklists['Calculations'][] = ['name' => 'calculations_pros', 'uitype' => '33', 'add_values' => [], 'remove_values' => ['PLL_LONGTERM_REALIZATION']];

		$roleRecordList = Settings_Roles_Record_Model::getAll();
		$rolesSelected = array();
		foreach ($roleRecordList as $roleRecord) {
			$rolesSelected[] = $roleRecord->getId();
		}
		foreach ($addPicklists as $moduleName => $piscklists) {
			$moduleModel = Settings_Picklist_Module_Model::getInstance($moduleName);
			if (!$moduleModel)
				continue;
			foreach ($piscklists as $piscklist) {
				$fieldModel = Settings_Picklist_Field_Model::getInstance($piscklist['name'], $moduleModel);
				if (!$fieldModel)
					continue;
				$pickListValues = Vtiger_Util_Helper::getPickListValues($piscklist['name']);
				foreach ($piscklist['add_values'] as $newValue) {
					if (!in_array($newValue, $pickListValues)) {
						$moduleModel->addPickListValues($fieldModel, $newValue, $rolesSelected);
					}
				}
				foreach ($piscklist['remove_values'] as $newValue) {
					if (!in_array($newValue, $pickListValues))
						continue;
					if ($piscklist['uitype'] != '16') {
						$deletePicklistValueId = self::getPicklistId($piscklist['name'], $newValue);
						if ($deletePicklistValueId)
							$adb->pquery("DELETE FROM `vtiger_role2picklist` WHERE picklistvalueid = ? ", array($deletePicklistValueId));
					}
					$adb->pquery("DELETE FROM `vtiger_" . $piscklist['name'] . "` WHERE " . $piscklist['name'] . " = ? ", array($newValue));
				}
			}
		}
		$log->debug("Exiting YetiForceUpdate::picklists() method ...");
	}

	function getPicklistId($fieldName, $value)
	{
		global $log, $adb;
		$log->debug("Entering YetiForceUpdate::getPicklistId(" . $fieldName . ',' . $value . ") method ...");
		if (Vtiger_Utils::CheckTable('vtiger_' . $fieldName)) {
			$sql = 'SELECT * FROM vtiger_' . $fieldName . ' WHERE ' . $fieldName . ' = ? ;';
			$result = $adb->pquery($sql, array($value));
			if ($adb->num_rows($result) > 0) {
				$log->debug("Exiting YetiForceUpdate::getPicklistId() method ...");
				return $adb->query_result($result, 0, 'picklist_valueid');
			}
		}
		$log->debug("Exiting YetiForceUpdate::getPicklistId() method ...");
		return false;
	}

	function pdfContent()
	{
		$pdfContent = [];
		$pdfContent['Quotes PDF'] = '<title></title>
<title></title>
<table align="left" border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
	<tbody>
		<tr>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#company_organizationname#</strong><br />
			#company_address#<br />
			#company_code# #company_city#<br />
			#company_country#<br />
			tel.: #company_phone#<br />
			fax: #company_fax#<br />
			WWW: <a href="#company_website#"> #company_website#</a><br />
			VAT: #company_vatid#</span></span></td>
			<td>&nbsp;</td>
			<td>
			<div style="text-align: right;"><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#company_city#, #special_function#CurrentDate#end_special_function#</span></span></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#Accounts_accountname#</strong><br />
			#addresslevel8a# #buildingnumbera# #localnumbera#<br />
			#addresslevel7a# #addresslevel5a#<br />
			#Accounts_label_vat_id#: #Accounts_vat_id#</span></span></td>
		</tr>
	</tbody>
</table>

<p style="text-align: center;"><br />
<span style="font-size:14px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>Offer #quote_no#</strong></span></span></p>
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#description#</span></span><br />
<span>#special_function#replaceProductTable#end_special_function#</span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#label_attention#: </strong>#attention#<br />
<strong>#label_currency_id#: </strong>#currency_id#<br />
<strong>#label_validtill#: </strong>#validtill#<br />
<strong>#label_shipping#: </strong>#shipping#<br />
<strong>#label_form_payment#: </strong>#form_payment#<br />
<strong>#label_terms_conditions#:</strong>#terms_conditions#</span></span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#Users_first_name# #Users_last_name#<br />
email: <a href="mailto:#Users_email1#">#Users_email1#</a><br />
<br />
<strong>#company_organizationname#</strong><br />
tel.: #company_phone#<br />
fax: #company_fax#<br />
WWW: <a href="#company_website#"> #company_website#</a></span></span>';
		$pdfContent['Sales Order PDF'] = '<title></title>
<title></title>
<table align="left" border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
	<tbody>
		<tr>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#company_organizationname#</strong><br />
			#company_address#<br />
			#company_code# #company_city#<br />
			#company_country#<br />
			tel.: #company_phone#<br />
			fax: #company_fax#<br />
			WWW: <a href="#company_website#"> #company_website#</a><br />
			VAT: #company_vatid#</span></span></td>
			<td>&nbsp;</td>
			<td>
			<div style="text-align: right;"><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#company_city#, #special_function#CurrentDate#end_special_function# </span></span></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#Accounts_accountname#</strong><br />
			#addresslevel8a# #buildingnumbera# #localnumbera#<br />
			#addresslevel7a# #addresslevel5a#<br />
			#Accounts_label_vat_id#: #Accounts_vat_id#</span></span></td>
		</tr>
	</tbody>
</table>

<p style="text-align: center;"><br />
<span style="font-size:14px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>Sales Order #salesorder_no#</strong></span></span></p>
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#description#</span></span><br />
<span>#special_function#replaceProductTable#end_special_function#</span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#label_attention#: </strong>#attention#<br />
<strong>#label_currency_id#: </strong>#currency_id#<br />
<strong>#label_duedate#: </strong>#duedate#<br />
<strong>#label_form_payment#: </strong>#form_payment#<br />
<strong>#Quotes_label_quote_no#: </strong>#Quotes_quote_no#<br />
<strong>#label_terms_conditions#:</strong>#terms_conditions#</span></span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#Users_first_name# #Users_last_name#<br />
email: <a href="mailto:#Users_email1#">#Users_email1#</a><br />
<br />
<strong>#company_organizationname#</strong><br />
tel.: #company_phone#<br />
fax: #company_fax#<br />
WWW: <a href="#company_website#"> #company_website#</a></span></span>';
		$pdfContent['Invoice PDF'] = '<title></title>
<title></title>
<table align="left" border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
	<tbody>
		<tr>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#company_organizationname#</strong><br />
			#company_address#<br />
			#company_code# #company_city#<br />
			#company_country#<br />
			tel.: #company_phone#<br />
			fax: #company_fax#<br />
			WWW: <a href="#company_website#"> #company_website#</a><br />
			VAT: #company_vatid#</span></span></td>
			<td>&nbsp;</td>
			<td>
			<div style="text-align: right;"><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#label_invoicedate#: #invoicedate# </span></span></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#Accounts_accountname#</strong><br />
			#addresslevel8a# #buildingnumbera# #localnumbera#<br />
			#addresslevel7a# #addresslevel5a#<br />
			#Accounts_label_vat_id#: #Accounts_vat_id#</span></span></td>
		</tr>
	</tbody>
</table>

<p style="text-align: center;"><br />
<span style="font-size:14px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>Invoice #invoice_no#</strong></span></span></p>
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#description#</span></span><br />
<span>#special_function#replaceProductTable#end_special_function#</span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#label_attention#: </strong>#attention#<br />
<strong>#label_currency_id#: </strong>#currency_id#<br />
<strong>#label_invoicedate#: </strong>#invoicedate#<br />
<strong>#label_duedate#: </strong>#duedate#<br />
<strong>#label_form_payment#: </strong>#form_payment#<br />
<strong>Sales Order: </strong>#SalesOrder_salesorder_no#<br />
<strong>#label_terms_conditions#:</strong>#terms_conditions#</span></span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#Users_first_name# #Users_last_name#<br />
email: <a href="mailto:#Users_email1#">#Users_email1#</a><br />
<br />
<strong>#company_organizationname#</strong><br />
tel.: #company_phone#<br />
fax: #company_fax#<br />
WWW: <a href="#company_website#"> #company_website#</a></span></span>';
		$pdfContent['Purchase Order PDF'] = '<title></title>
<title></title>
<table align="left" border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
	<tbody>
		<tr>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#company_organizationname#</strong><br />
			#company_address#<br />
			#company_code# #company_city#<br />
			#company_country#<br />
			tel.: #company_phone#<br />
			fax: #company_fax#<br />
			WWW: <a href="#company_website#"> #company_website#</a><br />
			VAT: #company_vatid#</span></span></td>
			<td>&nbsp;</td>
			<td>
			<div style="text-align: right;"><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#company_city#, #special_function#CurrentDate#end_special_function# </span></span></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#Vendors_vendorname#</strong><br />
			#addresslevel8a# #buildingnumbera# #localnumbera#<br />
			#addresslevel7a# #addresslevel5a#<br />
			#Vendors_label_vat_id#: #Vendors_vat_id#</span></span></td>
		</tr>
	</tbody>
</table>

<p style="text-align: center;"><br />
<span style="font-size:14px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>Order confirmation #purchaseorder_no#</strong></span></span></p>
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">Thank you for your order. Herewith we are pleased to confirm it as follows.<br />
#description#</span></span><br />
<span>#special_function#replaceProductTable#end_special_function#</span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;"><strong>#label_attention#: </strong>#attention#<br />
<strong>#label_currency_id#: </strong>#currency_id#<br />
<strong>#label_duedate#: </strong>#duedate#<br />
<strong>#label_terms_conditions#:</strong>#terms_conditions#</span></span><br />
<br />
<span style="font-size:9px;"><span style="font-family: tahoma,geneva,sans-serif;">#Users_first_name# #Users_last_name#<br />
email: <a href="mailto:#Users_email1#">#Users_email1#</a><br />
<br />
<strong>#company_organizationname#</strong><br />
tel.: #company_phone#<br />
fax: #company_fax#<br />
WWW: <a href="#company_website#"> #company_website#</a></span></span>';
		$pdfContent['Calculation PDF'] = '<title></title>
<table width="537px">
	<tbody>
		<tr>
			<td colspan="6" rowspan="2"><img src="#special_function#siteUrl#end_special_function#storage/Logo/logo_yetiforce.png" style="width: 200px;" width="200" /></td>
			<td colspan="4"><span style="font-size:6px;">#company_organizationname# #company_address# #company_code# #company_city#. VAT:#company_vatid#</span></td>
		</tr>
		<tr>
			<td colspan="5">
			<table border="1">
				<tbody>
					<tr>
						<td>
						<table cellpadding="1">
							<tbody>
								<tr>
									<td style="text-align: center;"><span style="font-size:9px;">Calculation confirmation: <strong>#calculations_no#</strong></span></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td>
						<table cellpadding="1">
							<tbody>
								<tr>
									<td style="text-align: center;"><span style="font-size:9px;">Date: #special_function#CreatedDateTime#end_special_function#</span></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="7">&nbsp;</td>
			<td colspan="5" rowspan="2">
			<table border="1">
				<tbody>
					<tr>
						<td>
						<table cellpadding="5">
							<tbody>
								<tr>
									<td>
									<table cellpadding="0" style="font-size:8px;">
										<tbody>
											<tr>
												<td colspan="2">Issued by:</td>
												<td colspan="3">#Users_first_name# #Users_last_name#</td>
											</tr>
											<tr>
												<td colspan="2">Email:</td>
												<td colspan="3">#Users_email1#</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<table>
				<tbody>
					<tr>
						<td><span style="font-size:10px;">&nbsp;<span style="font-size:8px;">#Accounts_account_no#</span></span></td>
					</tr>
					<tr>
						<td>
						<table>
							<tbody>
								<tr>
									<td>
									<p><span style="font-size:10px;">#Accounts_accountname#<br />
									<span style="font-size:8px;">#Accounts_addresslevel8b# #Accounts_buildingnumberb# #Accounts_localnumberb#<br />
									#Accounts_addresslevel7b#, #Accounts_addresslevel5b#<br />
									<span style="font-size:10px;">#Accounts_addresslevel1b#</span><br />
									#Accounts_vat_id#</span></span></p>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
			<td colspan="3">&nbsp;</td>
		</tr>
	</tbody>
</table>
&nbsp;

<table>
	<tbody>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>#special_function#replaceProductTable#end_special_function#</td>
		</tr>
	</tbody>
</table>';
		return $pdfContent;
	}
}
