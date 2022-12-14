<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class UsersExport implements WithCharts
{

    /**
     * @return Chart|Chart[]
     */
    public function charts()
    {
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->fromArray(
            [
                ['', 2010, 2011, 2012],
                ['Q1', 12, 10, 21],
                ['Q2', 56, 73, 86],
                ['Q3', 52, 61, 69],
                ['Q4', 30, 32, 0],
            ]
        );

        $dataSeriesLabels1 = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), // 2011
        ];
        //     Data Marker
        $xAxisTickValues1 = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$2:$A$5', null, 4), // Q1 to Q4
        ];
        $dataSeriesValues1 = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$C$2:$C$5', null, 4),
        ];

        // Build the dataseries
        $series1 = new DataSeries(
            DataSeries::TYPE_PIECHART, // plotType
            null, // plotGrouping (Pie charts don't have any grouping)
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataSeriesLabels1, // plotLabel
            $xAxisTickValues1, // plotCategory
            $dataSeriesValues1          // plotValues
        );

        // Set up a layout object for the Pie chart
        $layout1 = new Layout();
        $layout1->setShowVal(true);
        $layout1->setShowPercent(true);

        // Set the series in the plot area
        $plotArea1 = new PlotArea($layout1, [$series1]);
        // Set the chart legend
        $legend1 = new Legend(Legend::POSITION_RIGHT, null, false);

        $title1 = new Title('Test Pie Chart');

        // Create the chart
        $chart1 = new Chart(
            'chart1', // name
            $title1, // title
            $legend1, // legend
            $plotArea1, // plotArea
            true, // plotVisibleOnly
            DataSeries::EMPTY_AS_GAP, // displayBlanksAs
            null, // xAxisLabel
            null   // yAxisLabel - Pie charts don't have a Y-Axis
        );

        // Set the position where the chart should appear in the worksheet
        $chart1->setTopLeftPosition('A7');
        $chart1->setBottomRightPosition('H20');

        // Add the chart to the worksheet
        $worksheet->addChart($chart1);

      
        $dataSeriesLabels2 = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), // 2011
        ];
       
        $xAxisTickValues2 = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$2:$A$5', null, 4), // Q1 to Q4
        ];
       
        $dataSeriesValues2 = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$C$2:$C$5', null, 4),
        ];

        // Build the dataseries
        $series2 = new DataSeries(
            DataSeries::TYPE_DONUTCHART, // plotType
            null, // plotGrouping (Donut charts don't have any grouping)
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataSeriesLabels2, // plotLabel
            $xAxisTickValues2, // plotCategory
            $dataSeriesValues2        // plotValues
        );

        // Set up a layout object for the Pie chart
        $layout2 = new Layout();
        $layout2->setShowVal(true);
        $layout2->setShowCatName(true);

        // Set the series in the plot area
        $plotArea2 = new PlotArea($layout2, [$series2]);

        $title2 = new Title('Test Donut Chart');

        // Create the chart
        $chart2 = new Chart(
            'chart2', // name
            $title2, // title
            null, // legend
            $plotArea2, // plotArea
            true, // plotVisibleOnly
            DataSeries::EMPTY_AS_GAP, // displayBlanksAs
            null, // xAxisLabel
            null   // yAxisLabel - Like Pie charts, Donut charts don't have a Y-Axis
        );

        // Set the position where the chart should appear in the worksheet
        $chart2->setTopLeftPosition('I7');
        $chart2->setBottomRightPosition('P20');

        $worksheet->addChart($chart2);
        // return [];
        // Save Excel 2007 file
        $filename ='excel-pie-chart.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setIncludeCharts(true);
        $writer->save($filename);
        return [$chart1, $chart2];
    }
}