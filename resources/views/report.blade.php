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
   
    .grid-container {
      display: grid;          /* Enables CSS Grid */
      grid-template-columns: repeat(2, 1fr); /* Creates 2 equal columns */ 
      align-items: center;        /* Adds space between grid items */
      margin-bottom: 25px;
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
    <img class="kop" src="storage\main\kop.jpg" loading="lazy" alt="Image">
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
            <h3 style="text-align: center; margin-top: -3px">{{$tugas->name}}</h3>
            <ul >
              @foreach($tugas['target'] as $job)
                 @if(count($tugas->target[0]->image) > 4)
                 <li><div style="height: 70px;margin-bottom: 10px;"><p>{{ $job['name'] }} </p></div>
                  @else
                  <li><div style="margin-top: -10px;"><p>{{ $job['name'] }} </p></div>
                  @endif
                <div class="gird-container">
                  @foreach($job['image'] as $link)
                  <img class="grid-item" src="{{ 'storage/uploads/' . $link }}">
                  @endforeach
                </div>
              </li>
            @endforeach
            </ul>
        <img class="kop" src="storage\main\ttd.png" style="margin-top: 20px;" loading="lazy" alt="Image">
    </div>
</body>
</html>