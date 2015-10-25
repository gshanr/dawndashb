              var chart;
              $(document).ready(function() {                     
                              
                       function repeatAjax(){
                          $.ajax({
                            url: '../load.php',
                            type: 'GET',
                            
                            
                            success: function(resp) {
                              //alert("Form submitted successfully");
                             
                              var rel = $.parseJSON(resp);
                              var series=chart.series[0];
                              console.log(resp);
                              series.addPoint([rel[0],rel[2]]);
                              document.getElementById('tx').innerHTML=rel[0];
                              document.getElementById('rx').innerHTML=rel[1];
                              document.getElementById('active').innerHTML=rel[3];
                              document.getElementById('bw').innerHTML=rel[4];
                              act=rel[0];
                              console.log(rel[3],rel[4]);
                              setTimeout(repeatAjax,5000); //After completion of request, time to redo it after a second
                            },
                            error: function () {
                            alert("error");
                          },
                          });
                          }      
                              
                          chart = new Highcharts.Chart({
                            chart: {
                              renderTo: 'container',
                              defaultSeriesType: 'line',
                              events:{
                                load: repeatAjax
                                }
                            },

                            title: {
                              text: 'Reliability'
                            },

                            yAxis: {
                              minPadding: 0.2,
                              maxPadding: 0.2,
                              min:-.1,
                              startOnTick:false,
                              title: {
                                text: 'Reliability %',
                                margin: 80
                              }
                            },
                            series: [{
                              name: 'Reliability',
                              rel: []
                            }]
                          });
                        });
                        
                           
                        
                       