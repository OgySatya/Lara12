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
      align-items: center;      /* Centers the image vertically */
      width: 210mm;         /* Set the container width to 210mm */         /* Set the container height to 297mm (A4 paper height) */
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
      gap: 50px;      
      align-items: center;        /* Adds space between grid items */
    }

    /* Grid items */
    .grid-item {
      width: 85mm; 
      height: 50mm; 
      object-fit: cover; /* Ensures it fills the space */
      border: 2px solid #000; /* Adds a border around the image */
    }
</style>
<body>
<div class="container">
    <img class="kop" src="https://raw.githubusercontent.com/OgySatya/Lara12/refs/heads/main/storage/app/public/kop%20seloaji.jpg" loading="lazy" alt="Image">
        <div style="text-align: center;">
            <h4 style="text-transform: uppercase;" >LAPORAN BUKTI DUKUNG LAPORAN E KINERJA BULAN
             <br>
             {{$date->month}} {{$date->year}}
            </h4>
        </div>
        <div >
            <pre style="font-family: Arial, sans-serif;">Nama       : {{$user->name}}
                <br>NIP           : {{$user->NIP}}
                <br>Jabatan    : {{$tugas->Jabatan->name}}
            </pre>
     
        </div>
            <h4 style="text-align: center;">{{$tugas->name}}</h4>
            <ul >
              @foreach($tugas['target'] as $job)
              <li><p style="margin-block-end: 20px;">{{ $job['name'] }} </p>
                <div class="gird-container">
                  @foreach($job['laporan'] as $link)
                  <img class="grid-item" src="{{$link}}" alt="" height="300px">
                  @endforeach
                </div>
              </li>
            @endforeach
            </ul>
        <div class="box">
        <p >Mengetahui :</p>
        <p >PENGAWAS SATUAN PELAYANAN TERMINAL TIPE A SELOAJI</p>
        <img src="https://raw.githubusercontent.com/OgySatya/Lara12/refs/heads/main/storage/app/public/ttd.jpg" loading="lazy" height="80px" alt="Image">
        <p><strong><u>PURWANTO</u></strong> <br>NIP. 19670610 199203 1 008 </p>
      </div>
    </div>
</body>
</html>