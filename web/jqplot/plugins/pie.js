$(document).ready(function(){ 
    var s1 = [["Cafe Long",7],["Th\u00e9 \u00e0 la menthe",1]];
    alert(tab)
    var plot8 = $.jqplot('pie8', [s1], {
        grid: {
            drawBorder: false, 
            drawGridlines: false,
            background: '#ffffff',
            shadow:false
        },
        axesDefaults: {
             
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true
            }
        },
        legend: {
            show: true,
            rendererOptions: {
                numberRows: 1
            },
            location: 's'
        }
    }); 
});