function makeGraph(config){

			var obj = config;
	  		
			var renderingPanel="graph"+obj.admin.panel;
			console.log("renderingPanel: ",renderingPanel);
			
			x = [];
			for( var i in obj.chart.series ) {
    			x[i] = obj.chart.series[i];
    			console.log(obj.chart.series[i]);
			}
			console.log("x= "+ x+ "leng="+(obj.chart.series).length);
			obj.chart.series = x;	

			var chartdata = obj.chart;
			console.log("chartdata: ", chartdata);	
			$("#"+renderingPanel).highcharts(chartdata);
}
