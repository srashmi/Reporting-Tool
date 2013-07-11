function makeGraph(config){

	var vars_obj;//="graph1";
	var obj;
	console.log(config);
	console.log("----makeGraph----panelno="+config.panel);
	vars_obj="graph"+config.panel;
	
	($.ajax({
	  url: "../data/data1.txt",
	  success: function (data) {
	  		
	  		console.log(data);
			obj = eval ("(" + data + ")");
			//var myLine = new Chart(document.getElementById(vars_obj).getContext("2d")).Bar(obj);
			console.log(obj);
			$("#"+vars_obj).highcharts(obj);
	  }
}));
		
	  

}
