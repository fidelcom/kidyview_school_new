// Morris Bar Colors
Morris.Bar({
	element: 'barColors',
	data: [
		{x: 'Jan', Clicks: 300},
		{x: 'Feb', Clicks: 150},
		{x: 'Mar', Clicks: 50},
		{x: 'Apr', Clicks: 280},
		{x: 'May', Clicks: 15},
		{x: 'Jun', Clicks: 100},
		{x: 'Jul', Clicks: 50},
		{x: 'Aug', Clicks: 85},
		{x: 'Sep', Clicks: 275},
		{x: 'Oct', Clicks: 145},
		{x: 'Nov', Clicks: 120},
		{x: 'Dec', Clicks: 10},	],
	xkey: 'x',
	ykeys: ['Clicks'],
	labels: ['Total Revinue'],
	resize: true,
	gridLineColor: "#c1f8ff",
	hideHover: "auto",
	barColors:['#00bed5', '#CAB48F', '#00bed5'],
});