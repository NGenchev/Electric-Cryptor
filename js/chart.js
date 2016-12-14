google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart1);
function drawChart1() {
  var data = google.visualization.arrayToDataTable([
    ['Дата', 'Брой'],
    ['Днес',  1000],
    ['Този Месец',  1170],
    ['Тази Година',  660],
    ['Общо',  1030]
  ]);

  var options = {
    title: '',
 };

var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
  chart.draw(data, options);
}
$(window).resize(function(){
  drawChart1();
});
