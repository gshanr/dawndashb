
              $(document).ready(function() {                     
                              
                       function tablestat(){
                          $.ajax({
                            url: '../arrayfetch.php',
                            type: 'GET',                           
                            
                            success: function(resp) {
                              //alert("Form submitted successfully");   
                              //var tempArray = $.parseJSON('<?php echo json_encode(resp); ?>');
                              var rel = $.parseJSON(resp);
                              //document.write(resp);
                              //document.getElementById("tableholder").innerHTML=resp;
                              console.log(rel[0]['address']);                             
                            },
                            error: function () {
                            alert("error");
                          }
                          });
                          }      
                          tablestat();      
                       
                        });
                        
                           
                        
                       