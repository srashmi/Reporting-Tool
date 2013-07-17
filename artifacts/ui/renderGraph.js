function makeGraph(config){

			var obj = config;
			var renderingPanel="graph"+obj.admin.panel;
			var chartdata = obj.chart;
			$("#"+renderingPanel).highcharts(chartdata);

			// For debugging only
			
			// console.log("renderingPanel: ",renderingPanel);
			//console.log("chartdata: ", chartdata);	
			// x = [];
			// console.log("Test!!! ");//obj.chart.series");
			// for( var i in obj.chart.series ) {
   //  			x[i] = obj.chart.series[i];
   //  			console.log(obj.chart.series[i]);
			// }
			// console.log("x= "+ x+ "leng="+(obj.chart.series).length);
			//obj.chart.series = x;	
}
