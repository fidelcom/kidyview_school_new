var chart = new Chartist.Line('.line-chart2', {
	labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
	series: [
	  [
			{meta: 'Ads', value: 25 },
			{meta: 'Ads', value: 30},
			{meta: 'Ads', value: 10},
			{meta: 'Ads', value: 22},
			{meta: 'Ads', value: 50},
			{meta: 'Ads', value: 10},
			{meta: 'Ads', value: 12},
			{meta: 'Ads', value: 5},
			{meta: 'Ads', value: 7},
			{meta: 'Ads', value: 11},
			{meta: 'Ads', value: 10},
			{meta: 'Ads', value: 15},
	  ]
	]
}, {
	// Remove this configuration to see that chart rendered with cardinal spline interpolation
	// Sometimes, on large jumps in data values, it's better to use simple smoothing.
	lineSmooth: Chartist.Interpolation.simple({
		divisor: 2
	}),
	height: "190px",
	fullWidth: true,
	chartPadding: {
		right: 20,
		left: 10,
		top: 10,
		bottom: 0,
	},
	axisX: {
		offset: 0,
		showGrid: false,
		showLabel: false,
	}, 
	axisY: {
		offset: 0,
		showLabel: false,
	},
	plugins: [
		Chartist.plugins.tooltip()
	],
	low: 0
});

chart.on('draw', function(data) {
  if(data.type === 'line' || data.type === 'area') {
    data.element.animate({
      d: {
        begin: 2000 * data.index,
        dur: 2000,
        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
        to: data.path.clone().stringify(),
        easing: Chartist.Svg.Easing.easeOutQuint
      }
    });
  }
});



var chart = new Chartist.Line('.line-chartnew', {
	labels: [1, 2, 3, 4, 5],
	series: [
	  [
			{meta: 'Earnings', value: 800 },
			{meta: 'Earnings', value: 1250},
			{meta: 'Earnings', value: 2100},
			{meta: 'Earnings', value: 800},
			{meta: 'Earnings', value: 3700},
	  ]
	]
}, {
	// Remove this configuration to see that chart rendered with cardinal spline interpolation
	// Sometimes, on large jumps in data values, it's better to use simple smoothing.
	lineSmooth: Chartist.Interpolation.simple({
		divisor: 2
	}),
	height: "190px",
	fullWidth: true,
	chartPadding: {
		right: 20,
		left: 10,
		top: 10,
		bottom: 0,
	},
	axisX: {
		offset: 0,
		showGrid: false,
		showLabel: false,
	}, 
	axisY: {
		offset: 0,
		showLabel: false,
	},
	plugins: [
		Chartist.plugins.tooltip()
	],
	low: 0
});

chart.on('draw', function(data) {
  if(data.type === 'line' || data.type === 'area') {
    data.element.animate({
      d: {
        begin: 2000 * data.index,
        dur: 2000,
        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
        to: data.path.clone().stringify(),
        easing: Chartist.Svg.Easing.easeOutQuint
      }
    });
  }
});