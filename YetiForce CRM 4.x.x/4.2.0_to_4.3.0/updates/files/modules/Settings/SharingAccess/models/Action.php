<?php
/**
 * Settings SharingAccess action model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 */

/**
 * Sharing Access Action Model Class
 */
class Settings_SharingAccess_Action_Model extends \App\Base
{

	public static $nonConfigurableActions = ['Hide Details', 'Hide Details and Add Events', 'Show Details', 'Show Details and Add Events'];

	public function getId()
	{
		return $this->get('share_action_id');
	}

	public function getName()
	{
		return $this->get('share_action_name');
	}

	public function isUtilityTool()
	{
		return false;
	}

	public function isModuleEnabled($module)
	{
		return (new \App\Db\Query())->from('vtiger_org_share_action2tab')
				->where(['tabid' => $module->getId(), 'share_action_id' => $this->getId()])
				->exists();
	}

	/**
	 * Function to get instance of class
	 * @param integer|string $value
	 * @return \self
	 */
	public static function getInstance($value)
	{
		$query = (new App\Db\Query())->from('vtiger_org_share_action_mapping');
		if (vtlib\Utils::isNumber($value)) {
			$query->where(['share_action_id' => $value]);
		} else {
			$query->where(['share_action_name' => $value]);
		}
		$result = $query->one();
		if ($result) {
			return (new self())->setData($result);
		}
		return null;
	}

	/**
	 * Function to get all action
	 * @param boolean $configurable
	 * @return \self[]
	 */
	public static function getAll($configurable = true)
	{
		$query = (new App\Db\Query())->from('vtiger_org_share_action_mapping');
		if ($configurable) {
			$query->where(['NOT IN', 'share_action_name', self::$nonConfigurableActions]);
		}
		$dataReader = $query->createCommand()->query();
		$actionModels = [];
		while ($row = $dataReader->read()) {
			$actionModel = new self();
			$actionModel->setData($row);
			$actionModels[] = $actionModel;
		}
		return $actionModels;
	}
}
