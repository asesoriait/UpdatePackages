<?php
/**
 * Dav public file
 * @package YetiForce
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @copyright YetiForce Sp. z o.o.
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
chdir(__DIR__ . '/../../api/');
define('IS_PUBLIC_DIR', true);
require 'dav.php';
