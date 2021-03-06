<?php

/**
 * Detail View for KnowledgeBase
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Krzysztof Gastołek <krzysztof.gastolek@wars.pl>
 */
class KnowledgeBase_Detail_View extends Vtiger_Detail_View
{

	function __construct()
	{
		parent::__construct();
		$this->exposeMethod('showPreview');
	}

	function showPreview($request)
	{
		$previewContent = new KnowledgeBase_PreviewContent_View();
		$previewContent->process($request);
	}
}
