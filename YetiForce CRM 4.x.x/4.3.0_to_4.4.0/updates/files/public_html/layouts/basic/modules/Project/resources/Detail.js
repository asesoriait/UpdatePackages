/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Detail_Js("Project_Detail_Js", {}, {
	/**
	 * Function to register event for create related record
	 * in summary view widgets
	 */
	registerSummaryViewContainerEvents: function (summaryViewContainer) {
		this._super(summaryViewContainer);
	},
	/**
	 * Function to load module summary of Projects
	 */
	loadModuleSummary: function () {
		var summaryParams = {};
		summaryParams['module'] = app.getModuleName();
		summaryParams['view'] = "Detail";
		summaryParams['mode'] = "showModuleSummaryView";
		summaryParams['record'] = jQuery('#recordId').val();
		AppConnector.request(summaryParams).then(
			function (data) {
				jQuery('.js-widget-general-info').html(data);
			}
		);
	},
	/**
	 * Load gantt component
	 */
	loadGantt() {
		let ganttContainer = $('.c-gantt', this.detailViewContentHolder);
		if (ganttContainer.length) {
			let gantt = new Project_Gantt_Js(this.detailViewContentHolder);
			gantt.registerEvents();
		}
	},
	/**
	 * Load gantt component when needed
	 */
	registerGantt() {
		this.loadGantt();
		app.event.on('DetailView.Tab.AfterLoad', (e, data, instance) => {
			instance.detailViewContentHolder.ready(() => {
				this.loadGantt();
			})
		});
	},
	/**
	 * Register events
	 */
	registerEvents: function () {
		var detailContentsHolder = this.getContentHolder();
		var thisInstance = this;
		this._super();
		detailContentsHolder.on('click', '.moreRecentTickets', function () {
			var recentTicketsTab = thisInstance.getTabByLabel(thisInstance.detailViewRecentTicketsTabLabel);
			recentTicketsTab.trigger('click');
		});
		this.registerGantt();
	}
});
