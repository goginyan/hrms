am4core.useTheme(am4themes_animated);
am4core.options.commercialLicense = true;

function getSource(category, data) {
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
    console.log(source);
    return source;
}

function createPieChartBy(category, data) {
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

    chart.data = getSource(category, data);
    return chart;
}

function initChart(data) {
    let category = $('.table').attr('data-category');
    return createPieChartBy(category, data);
}

function updateChart(chart, data) {
    let category = $('.table').attr('data-category');
    console.log(chart);
    chart.data = getSource(category, data);
}

function filterBy(filters, table, chart) {
    let url = $('#filtersForm').attr('action');
    axios.get(url, {
        params: filters
    }).then(({data}) => {
        $('#filtered').val(data.length);
        let tableData = [];
        for (e of data) {
            tableData.push(Object.values(e));
        }
        table.clear();
        table.rows.add(tableData);
        table.draw();
        if (chart) {
            updateChart(chart, data);
        }
    }).catch(e => console.log(e))
}

$(function () {
    //DataTable init
    let orderBy = 0;
    $('.employees-table th').each(function () {
        if ($(this).hasClass('order-by')) {
            orderBy = $(this).index();
        }
    });
    let table = $('.employees-table').DataTable({
        pageLength: 15,
        lengthMenu: [10, 15, 25, 50, 100],
        order: [[orderBy, $('.table.employees-table').attr('data-ordering')]],
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
        .insertBefore('#buttons');
    $('.dt-buttons').toggleClass('btn-group flex-wrap d-flex').children('button').toggleClass('btn-secondary btn-circle btn-outline-primary mr-3');
    let buttons = $(`<div class="col-12 col-md-4 no-print"></div>`);
    buttons.append($('.table-actions'));
    $('.dataTables_info').parent().toggleClass('col-md-5 col-md-4 no-print');
    $('.dataTables_paginate').parent().toggleClass('col-md-7 col-md-4 no-print').parent().append(buttons);
    $('.dataTables_length').addClass('no-print');
    $('.dataTables_filter').addClass('no-print');
    //end init

    let chart = null;
    if ($('#chartsContainer').length > 0) {
        chart = initChart(reportData);
    }

    $('#filtersForm select').on('change', function () {
        filterBy({department: $('#department').val(), role: $('#role').val(), status: $('#status').val()}, table, chart)
    });
});

