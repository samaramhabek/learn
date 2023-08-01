<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body> 

    <div id="pdf-content">
     
        <!-- Add the rest of your HTML content here -->

        <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <img src="{{ asset('image001.png') }}">

                    <tr>
                        <th colspan="8" scope="col">MULTIDISCIPLINARY CARE PLAN</th>
                        <th colspan="4" scope="col">Addressograph</th>
                        

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"colspan="4" style="background-color: rgb(103, 226, 103)">PLAN OF CARE</th>

                    </tr>
                    <tr>
                        <th style="background-color: rgb(103, 226, 103)">RN:<input id="inputField1"></th>
                        <th style="background-color: rgb(103, 226, 103)">RT:<input id="inputField2"></th>
                        <th style="background-color: rgb(103, 226, 103)">SW:<input id="inputField3"></th>
                        <th style="background-color: rgb(103, 226, 103)">OT:<input></th>
                        <th style="background-color: rgb(103, 226, 103)">DIETARY:<input></th>
                        <th style="background-color: rgb(103, 226, 103)">PT:<input></th>
                        <th style="background-color: rgb(103, 226, 103)">Others:<input></th>
                        <th style="background-color: rgb(103, 226, 103)">Identified/ Achieved:<input></th>
                   
                    </tr>
                    <tr>
                        <th scope="row">problem disgonted:<input></th>

                    </tr>
                    <tr>
                        <th scope="row">1:<input></th>
                    </tr>
                    <tr>
                        <th scope="row">2:<input></th>
                    </tr>

                    <tr>
                        <th scope="row">3:<input></th>
                    </tr>

                    <tr>
                        <th scope="row">4:<input></th>
                    </tr>


                    <tr>
                        <th scope="row">5:<input></th>
                    </tr>
                    <tr>
                        <th scope="row">goals</th>
                    </tr>
                    <tr>
                        <th scope="row"><input></th>
                    </tr>
                    <tr>
                        <th scope="row"><input></th>
                    </tr>

                    <tr>
                        <th scope="row"><input></th>
                    </tr>

                    <tr>
                        
                        <th scope="row"><input></th>
                      </tr>
      
      
                      <tr>
                          <th scope="row"><input></th>
                      </tr>
                      <tr>
                          <th scope="row" style="background-color: rgb(103, 226, 103)">Interventions:<input></th>
                      </tr>
                      <th scope="row"><input  min="1" max="100"></th>
                      </tr>
                      <tr>
                          <th scope="row"><input  min="1" max="100"></th>
                      </tr>
      
                      <tr>
                          <th scope="row"><input></th>
                      </tr>
      
                      <tr>
                          <th scope="row"><input></th>
                      </tr>
      
      
                      <tr>
                          <th scope="row"><input></th>
                      </tr>
                      <tr>
      
                      <tr>
                          <th scope="row" style="background-color: rgb(103, 226, 103)">Discharge Plan:<input></th>
                      </tr>
      
                      <tr>
                          <th scope="row" style="background-color: rgb(103, 226, 103)">Visit Schedule
                              :<input></th>
                          <th scope="row" style="background-color: rgb(103, 226, 103)">Visit Schedule
                              :<input></th>
                          <th scope="row" style="background-color: rgb(103, 226, 103)">date
                              :<input></th>
      
                      </tr>
                      <tr>
                          <th scope="row" style="background-color: rgb(61, 150, 61)">Caregiver Signature:
      
                              :<input></th>
                          <th scope="row" style="background-color: rgb(103, 226, 103)"> Badge Number
      
                              :<input></th>
                          <th scope="row" style="background-color: rgb(103, 226, 103)">date
                              :<input></th>
      
                      </tr>
                      <tr>
                          <th scope="row" style="background-color: rgb(61, 150, 61)">Date Reviewed/Updated
                             
                          
      
                              :<input></th>
      
      
                      </tr>
      
      
                  </tbody>
              </table>
          </div>
          <div id="editor"></div>
          <button id="generate-pdf" class="btn btn-dark">Generate PDF</button>
          </div>
          <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
          {{-- <script>
      
             var doc = new jsPDF();
              var specialElementHandlers = {
                  '#editor': function (element, renderer) {
                      return true;
                  }
              };
             
              $('#generate-pdf').click(function () {
                var input1Value = document.getElementById('inputField1').value;
                  doc.fromHTML($('#pdf-content').html(), 15, 15, {
                      'width': 170,
                      'elementHandlers': specialElementHandlers
                  });
                  doc.save('sample-file.pdf');
              });
          </script> --}}
          <script>
            var doc = new jsPDF();
            var specialElementHandlers = {
              '#editor': function (element, renderer) {
                return true;
              }
            };
          
            $('#generate-pdf').click(function () {
              var input1Value = $('#inputField1').val(); // Get the value of inputField1
          
              // Modify the content before converting to PDF
              $('#pdf-content input').each(function () {
                var value = $(this).val();
                $(this).replaceWith(value); // Replace the input with its value
              });
          
              doc.fromHTML($('#pdf-content').html(), 15, 15, {
                'width': 170,
                'elementHandlers': specialElementHandlers
              });
          
              doc.save('sample-file.pdf');

            //   i need when type in input  print them in file pdf

            });
          </script>
          
      </body>
      
      </html>
      

