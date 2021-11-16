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
		let num = 0

		$.each( dataObj, function( key, value ) {
			let dataArray = []
			let dataValue = []
			num++

			$.each( value, function( keys, values ) {
				dataValue = []

				$.each( values, function( keyss, valuess ) {
					if (keyss == 0) {
						dataValue.push(valuess)
					} else {
						dataValue.push(valuess)            
					}
				})
				dataArray.push(dataValue)  
			})

			ApexCharts.exec(key, 'updateSeries', [{
				name: "Data " + key,
				data: dataArray
			}], true);
		})
    });

})

function fetchChart(idSelector, name, dataValue = [], counter) {
	var options = {
		series: [{
		  name: "Data " + name,
		  data: dataValue
		}],
		chart: {
		  id: counter,
		  height: 350,
		  type: 'line',
		  zoom: {
			enabled: false
		  }
		},
		dataLabels: {
		  enabled: false
		},
		stroke: {
		  curve: 'straight'
		},
		title: {
		  text: 'Data ' + name,
		  align: 'left'
		},
		grid: {
		  row: {
			colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
			opacity: 0.5
		  },
		},
		xaxis: {
		  type: "datetime",
		},
		tooltip: {
			custom: function({series, seriesIndex, dataPointIndex, w}) {
				var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex]
				
				return '<ul>' +
				'<li><b>Datetime</b>: ' + data[0] + '</li>' +
				'<li><b>Value</b>: ' + data[1] + '</li>' +
				'</ul>';
			}
		}
	  };
  
	  var chart = new ApexCharts(document.querySelector(idSelector), options);
	  chart.render();
}

function getDetailDevice(dataSend) {

  try {
      $.ajax({
          url: '/monitoring/device/detail/' + dataSend,
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
	let appendData = ''
	let appendDataChartDiv = ''
	let num = 0
	let counter = 0
	let arrayChartName = []

	$("#value-input").empty()
	$("#value-chart").empty()

	$.each(data.detailDevice, function(index, val) {

		appendData += `<div class="form-group" style="padding-top: 10px;" class="mb-3">
						<label for="formrow-firstname-input" class="form-label">${val} Value</label>
						<div class="col-md-12">
							<input type="text" class="form-control" id="input_${index}" name="input_${index}" class="form-control" required>
						</div>
					</div>`

		appendDataChartDiv += `<div class="card-body"><div id="chart_line_${index}" class="apex-charts" dir="ltr"></div></div>`

		arrayChartName.push(`chart_line_${index}`)
	})

	$("#value-input").append(appendData)
	$("#value-chart").append(appendDataChartDiv)
	
	
	$.each(data.chartValueDevice, function(index, val) {
		num++

		fetchChart("#" + arrayChartName[counter], index, val, arrayChartName[counter])

		counter++
	})
}