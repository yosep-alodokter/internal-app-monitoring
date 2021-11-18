const token = $('input[name=_token]').val()
const routeListSummaryEmployee = $("#routeListSummaryEmployee")
const routeListSummaryInventory = $("#routeListSummaryInventory")
const routeChartPersuratan = $("#routeChartPersuratan")

const selectorForm = $("#jq-validation-form-create")
const tipeProses = $("#tipeProses")

$(function () {
    // setup ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    })

    // var options = {
    //     series: [{
    //         name: "Session Duration",
    //         data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
    //     },
    //     {
    //         name: "Page Views",
    //         data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
    //     },
    //     {
    //         name: 'Total Visits',
    //         data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
    //     },
    //     {
    //         name: 'other Visits',
    //         data: [43, 22, 12, 33, 65, 87, 43, 99, 12, 34, 65, 77]
    //     }
    //     ],
    //     chart: {
    //         height: 350,
    //         type: 'line',
    //         zoom: {
    //             enabled: true
    //         },
    //         stacked: false
    //     },
    //     dataLabels: {
    //         enabled: false
    //     },
    //     stroke: {
    //         width: 3,
    //     },
    //     title: {
    //         text: 'Dashboard Device',
    //         align: 'left'
    //     },
    //     legend: {
    //     tooltipHoverFormatter: function(val, opts) {
    //         return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
    //     }
    //     },
    //     markers: {
    //         size: 0,
    //         hover: {
    //             sizeOffset: 6
    //         }
    //     },
    //     xaxis: {
    //     categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
    //             '10 Jan', '11 Jan', '12 Jan'
    //         ],
    //     },
    //     tooltip: {
    //     y: [
    //         {
    //             title: {
    //                 formatter: function (val) {
    //                 return val;
    //                 }
    //             }
    //         }
    //        ]
    //     },
    //     grid: {
            
    //     }
    //   };

    //   var chart = new ApexCharts(document.querySelector("#value-chart"), options);
    //   chart.render();

    $('#device_id').on('select2:select', function (e) {
        let value = $(this).val()
        let dataSend = value

		if (dataSend !== "") {
			getDetailDevice(dataSend)

		} else {
			$("#value-input").empty()
			$("#value-chart").empty()
			$("#value-chart").append(`<div class="card-body"><img src="` + $('#hidden_url').val() + `" alt=""
			class="img-fluid mx-auto d-block rounded" width="700px" height="700px"></div>`)
		}
    });   
    

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('4612951c9dbd6f1f4c2d', {
    cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('realtime-chart-monitoring', function(data) {      
      
		let dataObj = JSON.parse(data.data);

        console.log(dataObj.chartAllDevice)

        ApexCharts.exec('chart_line_0', 'updateSeries', dataObj.chartAllDevice, true);

		// $.each( dataObj, function( key, value ) {
		// 	let dataArray = []
		// 	let dataValue = []
		// 	num++

		// 	$.each( value, function( keys, values ) {
		// 		dataValue = []

		// 		$.each( values, function( keyss, valuess ) {
		// 			if (keyss == 0) {
		// 				dataValue.push(valuess)
		// 			} else {
		// 				dataValue.push(valuess)            
		// 			}
		// 		})
		// 		dataArray.push(dataValue)  
		// 	})

		// 	ApexCharts.exec(key, 'updateSeries', [{
		// 		name: "Data " + key,
		// 		data: dataArray
		// 	}], true);
		// })
    });

})

function fetchChart(idSelector, dataValue = []) {
    var options = {
        series: dataValue,
        chart: {
            id: "chart_line_0",
            height: 550,
            type: 'line',
            zoom: {
                enabled: true
            },
            stacked: false
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 3,
        },
        title: {
            text: 'Dashboard Device',
            align: 'left'
        },
        legend: {
        tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
        }
        },
        markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            type: "datetime",
        },
        tooltip: {
        y: [
            {
                title: {
                    formatter: function (val) {
                    return val;
                    }
                }
            }
           ]
        },
        grid: {
            
        }
      };

      var chart = new ApexCharts(document.querySelector(idSelector), options);
      chart.render();
}

function getDetailDevice(dataSend) {

  try {
      $.ajax({
          url: '/monitoring/device/detail-all/' + dataSend,
          type: 'GET',
          success: function (response) {
			  formInputValue(response.data)
          },
          error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alertNotify(err.header.message)
        }
      })
  } catch (e) {
      console.log(e)
  }
}

function formInputValue(data) {
	$("#value-chart").empty()

	$("#value-chart").append(`<div class="card-body"><div id="chart_line_0" class="apex-charts" dir="ltr"></div></div>`)

    fetchChart("#chart_line_0", data.chartValueDevice)
}