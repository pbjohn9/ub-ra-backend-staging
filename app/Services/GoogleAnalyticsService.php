<?php

namespace App\Services;
use Google;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_DimensionFilter;
use Google_Service_AnalyticsReporting_DimensionFilterClause;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_GetReportsRequest;

Class GoogleAnalyticsService 
{
	public $service;

	public function init()
	{
		$this->service = Google::make('AnalyticsReporting');
	}

	public function getPageView($start_date, $end_date, $objBundle)
	{	
		// $start_date = $objBundle->start_date;
		// $end_date = $objBundle->end_date;
		$bundle_id = $objBundle->bundle_id;

		// Replace with your view ID, for example XXXX.
		$VIEW_ID = "96554947";

		// Create the DateRange object.
		$dateRange = new Google_Service_AnalyticsReporting_DateRange();
		$dateRange->setStartDate($start_date);
		$dateRange->setEndDate($end_date);

		// Create the Metrics object.
		$sessions = new Google_Service_AnalyticsReporting_Metric();
		$sessions->setExpression("ga:pageviews");
		$sessions->setAlias("pageviews");

		//filters take 2
		$dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
		$dimensionFilter->setDimensionName('ga:pagePath');
		// $dimensionFilter->setOperator('EXACT');
		$dimensionFilter->setExpressions('^.*(sale/'.$bundle_id.'-).*$');

		$dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
		$dimensionFilterClause->setFilters([$dimensionFilter]);

		// Create the ReportRequest object.
		$request = new Google_Service_AnalyticsReporting_ReportRequest();
		$request->setViewId($VIEW_ID);
		$request->setDateRanges($dateRange);
		$request->setMetrics(array($sessions));
		// $request->setFilters($filters);
		$request->setDimensionFilterClauses([$dimensionFilterClause]);

		$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
		$body->setReportRequests( array( $request) );

		$reports = $this->service->reports->batchGet( $body );
		return $this->printResults($reports);
	}

	/**
     * Parses and prints the Analytics Reporting API V4 response.
     *
     * @param An Analytics Reporting API V4 response.
     */
    public function printResults($reports) {
    	for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    		$report = $reports[ $reportIndex ];
    		$header = $report->getColumnHeader();
    		$dimensionHeaders = $header->getDimensions();
    		$metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    		$rows = $report->getData()->getRows();

    		for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
    			$row = $rows[ $rowIndex ];
    			$dimensions = $row->getDimensions();
    			$metrics = $row->getMetrics();
    			for ($j = 0; $j < count($metrics); $j++) {
    				$values = $metrics[$j]->getValues();
    				for ($k = 0; $k < count($values); $k++) {
    					$entry = $metricHeaders[$k];
    					return $values[$k];
    				}
    			}
    		}
    	}
    }

	public function getPercent($tot_bundle_traffic, $last_tot_bundle_traffic)
	{
		$per = !empty($last_tot_bundle_traffic) ? ($tot_bundle_traffic/ $last_tot_bundle_traffic)*100 : 0;
		return number_format($per,2)."%";
	}
}