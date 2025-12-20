<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
</head>
<style>
ul {
  list-style-type: number;  
  padding-left: 25px; 
}
.container {
      align-items: center;      
      width: 210mm;        
    }

    .container .kop {
      width: 100%;        /* Makes the image take up the full width of the container */
      height: 100%;       /* Makes the image take up the full height of the container */
      object-fit: contain; /* Ensures the image maintains aspect ratio while fitting the container */
    }
    .box {
      width: 80mm;
      margin-top: 30px         /* Set the box width to 50mm */
    }

    /* Align the box to the right side */
    .container .box {
      margin-left: auto;  /* Pushes the box to the right side */
    }
    .grid-container {
      display: grid;          /* Enables CSS Grid */
      grid-template-columns: repeat(2, 1fr); /* Creates 2 equal columns */ 
      align-items: center;     
      gap: 20px;   /* Adds space between grid items */
    }

    /* Grid items */
    .grid-item {
      width: 88mm; 
      height: 200mm; 
      object-fit: fill; /* Ensures it fills the space */
      border: 2px solid #000; /* Adds a border around the image */
    }
</style>
<body>
  <div class="container">
    <img class="kop" src="{{ asset('images/kop seloaji.jpg') }}"loading="lazy" alt="Image">
        <div style="text-align: center;">
            <h4 style="text-transform: uppercase;" >Rekap Absen Skemaraja
             <br>
             {{$date->month}} {{$date->year}}
            </h4>
        </div>
        
                <div class="gird-container">
                  @foreach($data as $link)
                  <img class="grid-item" src="{{ 'storage/absen/'. $link }}">
                  @endforeach
                </div>
        
    </div>
</body>
</html>