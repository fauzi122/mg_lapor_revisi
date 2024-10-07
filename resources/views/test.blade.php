<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body class="d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="dropdown">
        <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" id="data" onclick="test()">
          Dropdown button
        </button>
        <div class="dropdown-menu">
            <form action="/test" id="formkonc" method="post">
            @csrf
            <div class="dropdown-item">
              <input type="checkbox" name="pili[]" id="vehicle1" value="motor" class="pilih">
              <label for="vehicle1">motor</label>
            </div>
            <div class="dropdown-item">
              <input type="checkbox" class="pilih" name="pili[]" id="vehicle2" value="mobil">
              <label for="vehicle2">mobil</label>
            </div>
            <div class="dropdown-item">
              <input type="checkbox" class="pilih" name="pili[]" id="vehicle3" value="pesawat">
              <label for="vehicle3">pesawar</label>
            </div>
            <div class="dropdown-item">
              <input type="checkbox" class="pilih" name="pili[]" id="vehicle4" value="perahu">
              <label for="vehicle4">perahu</label>
            </div>
            </form>
        </div>
      </div>

      <button type="submit" form="formkonc"> submit</button>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


    <script>
        const pilih = document.querySelectorAll('.pilih');
        let data = [];

        function test() {

            pilih.forEach((e, i) => {
                if (e.checked) {
                    data.push(e.value);
                    document.querySelector('#data').innerHTML = data[i];
                }
            });
    
            
        }
        
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>
