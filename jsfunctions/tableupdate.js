
              $(document).ready(function() {                     
                              
                       function tablestat(){
                          $.ajax({
                            url: '../tabletest.php',
                            type: 'GET',
                            
                            complete: function(response, textStatus) {
                            return alert("Hey: " + textStatus);
                            },
                            success: function(resp) {
                              alert("Form submitted successfully");   
                              resp = resp.replace(/^"(.*)"$/, '$1');
                              //document.write(resp);
                              document.getElementById("tableholder").innerHTML=$(resp);
                              //console.log(resp);                             
                            },
                            error: function () {
                            alert("error");
                          }
                          });
                          }      
                          tablestat();      
                       
                        });
                        
                           
                        
                       