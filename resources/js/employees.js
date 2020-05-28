am4core.useTheme(am4themes_animated);
am4core.options.commercialLicense = true;

let data = employeesData;

function getSource(category) {
    let categories = {};
    for (const emp of data) {
        let property = emp[category] != null ? emp[category] : 'No Data';
        if (categories[property]) {
            categories[property]++;
        } else {
            categories[property] = 1
        }
    }
    let source = [];
    for (const c in categories) {
        if (categories.hasOwnProperty(c))
            source.push({
                [category]: c,
                employees: categories[c]
            })
    }
    return source;
}

function createPieChartBy(category) {
    let chart = am4core.create('chartsContainer', am4charts.PieChart);
// Adding a legend to a Pie chart
    chart.legend = new am4charts.Legend();
// Adding a series to a Pie chart
// The following will automatically create an instance of `PieSeries`,
// attach it to `PieChart` and return the reference, so that we can
// configure it
    let series = chart.series.create();

// Setting up data fields in Pie series
    series.dataFields.value = "employees";
    series.dataFields.category = category;

    chart.data = getSource(category);
}

function createXYChartBy(category, type = new am4charts.ColumnSeries()) {
    let chart = am4core.create('chartsContainer', am4charts.XYChart);
    chart.data = getSource(category);
    chart.legend = new am4charts.Legend();
    let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = category;
    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    let series = chart.series.push(type);
    series.dataFields.valueY = "employees";
    series.dataFields.categoryX = category;
}

function createBulletChartBy(category) {
    let chart = am4core.create('chartsContainer', am4charts.XYChart);
    chart.data = getSource(category);
    let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = category;
    categoryAxis.renderer.grid.template.location = 0;
    let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
    let series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueX = "employees";
    series.dataFields.categoryY = category;
}

$(function () {
    //DataTable init
    let table = $('.employees-table').DataTable({
        pageLength: 15,
        lengthMenu: [10, 15, 25, 50, 100],
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i>',
                titleAttr: 'Export to PDF'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Export to Excel'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i>',
                titleAttr: 'Print Table'
            },
        ],
    });
    table.buttons().container()
        .insertBefore('#pieChart');
    $('.dt-buttons').toggleClass('btn-group flex-wrap d-flex').children('button').toggleClass('btn-secondary btn-circle btn-outline-primary mr-3');
    let buttons = $(`<div class="col-12 col-md-4 no-print"></div>`);
    buttons.append($('.table-actions'));
    $('.dataTables_info').parent().toggleClass('col-md-5 col-md-4 no-print');
    $('.dataTables_paginate').parent().toggleClass('col-md-7 col-md-4 no-print').parent().append(buttons);
    $('.dataTables_length').addClass('no-print');
    $('.dataTables_filter').addClass('no-print');
    //end init

    $(document).on('click', '#pieChart', function () {
        $('.table-actions .btn-primary').toggleClass('btn-primary btn-outline-primary');
        $(this).toggleClass('btn-primary btn-outline-primary');
        let category = $('.chartable.active').attr('data-category');
        createPieChartBy(category);
    });

    $(document).on('click', '#lineChart', function () {
        $('.table-actions .btn-primary').toggleClass('btn-primary btn-outline-primary');
        $(this).toggleClass('btn-primary btn-outline-primary');
        let category = $('.chartable.active').attr('data-category');
        createXYChartBy(category, new am4charts.LineSeries());
    });

    $(document).on('click', '#barChart', function () {
        $('.table-actions .btn-primary').toggleClass('btn-primary btn-outline-primary');
        $(this).toggleClass('btn-primary btn-outline-primary');
        let category = $('.chartable.active').attr('data-category');
        createXYChartBy(category);
    });

    $(document).on('click', '#bulletChart', function () {
        $('.table-actions .btn-primary').toggleClass('btn-primary btn-outline-primary');
        $(this).toggleClass('btn-primary btn-outline-primary');
        let category = $('.chartable.active').attr('data-category');
        createBulletChartBy(category);
    });

    $(document).on('click', '.chartable:not(.active)', function () {
        $('.chartable').removeClass('active');
        $(this).addClass('active');
        let category = $(this).attr('data-category');
        let activeChart = $('.table-actions .btn-primary').attr('id');
        switch (activeChart) {
            case 'pieChart':
                createPieChartBy(category);
                break;
            case 'barChart':
                createXYChartBy(category);
                break;
            case 'lineChart':
                createXYChartBy(category, new am4charts.LineSeries());
                break;
            case 'bulletChart':
                createBulletChartBy(category);
                break;
            default:
                return true;
        }
    });
});

