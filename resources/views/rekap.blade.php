<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
</head>
<style>
ul { 
  padding-left: 25px; 
}
li{
  margin-bottom: 10px;
  font-family: Arial, sans-serif;  /* Sets the font */
  font-size: 16px; 
}
h4{
  font-family: Arial, sans-serif;  /* Sets the font */
  line-height: 1.5; 
}
p{
  font-family: Arial, sans-serif;  /* Sets the font */
  font-size: 16px;                /* Sets the font size */
  line-height: 1.5;  
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

.table-top {
  border-collapse: collapse;
  width: 100%;
  margin-left: 30px;
  margin-bottom: 20px;
}

.table-top td, .table-top th {
  padding: 3px;
  font-family: Arial, sans-serif;  /* Sets the font */
  font-size: 16px;                /* Sets the font size */
  line-height: 1.5; 
}


.simple-table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin: 0 auto;
}
.simple-table table{
  border: 0.1px solid #6c6c6c;
}
.simple-table p{
  margin-left: 25px;
}
.simple-table th, .simple-table td {
  padding: 5px;
  border: 0.1px solid #6c6c6c;
}
.btn {
  padding: 8px 16px;
  background-color: #2563eb; /* blue */
  color: #ffffff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  margin: 15px;
}

.btn:hover {
  background-color: #1d4ed8;
}


</style>
<body>
<div class="container">
  <img class="kop" src="storage\main\kop.jpg" loading="lazy" alt="Image">
  @if(empty($pdf))
     <button onclick="window.location.href='/job?job={{ $route }}'" class="btn" style="float: right; font-weight:bold"> << Balik</button>
@endif
        <div style="text-align: center;">
            <h4 style="text-transform: uppercase; font-weight: bold;" >LAPORAN BUKTI DUKUNG LAPORAN E KINERJA BULAN
             <br>
             {{$date->month}} {{$date->year}}
</h4>
        </div>
        <div>
                    <table class="table-top">
            <tr>
              <td>Nama</td>
              <td>: {{$user->name}}</td>
            </tr>
            <tr>
              <td>NIP</td>
              <td>: {{$user->NIP}}</td>

            </tr>
            <tr>
              <td>Jabatan</td>
              <td>: {{$tugas->Jabatan->name}}</td>

            </tr>
            <tr>
              <td>Unit Kerja </td>
              <td>: Satuan Pelayanan Terminal Tipe A Seloaji Ponorogo</td>

            </tr>
           
          </table>
        </div>
    <h4>A. Rencan Hasil Kerja</h4>
    <p style="font-weight: bold;margin-left:20px ">{{$tugas->name}}</p>
    <h4>B. Rencana Aksi</h4>
    <ul style="margin-left:15px ; list-style-type: number; margin-bottom: -10px;">
              @foreach($tugas['target'] as $job)
                 <li>
                 {{ $job['name'] }}
              </li>
            @endforeach
            </ul>
    @if($pdf)
        <div class="simple-table">
            {!! $tugas->post !!}
        </div>
@endif
         @if(empty($pdf))
     <div>
    <form action="{{ route('post') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $tugas->id }}">
        <input type="hidden" name="route" value="{{ $route }}">

        <textarea id="editor" name="content">
            {{ old('content', $tugas->post) }}
        </textarea>

        <button class="btn">Save</button>
    </form>
    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            toolbar: [
                'heading',
                'alignment',
                'bold','italic','underline','link',
                'bulletedList','numberedList','blockQuote',
                'insertTable','undo','redo'
            ],
               alignment: {
            options: [ 'left', 'center', 'right', 'justify' ]
        },
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells'
                ]
            }
        })
        .catch(error => console.error(error));
    </script>

     </div>
@endif
       <ul style="margin-top: -10px;">
              @foreach($tugas['target'] as $job)
                  <li style="list-style-type: upper-roman;"><p>{{ $job['name'] }} </p>
                  <div class="gird-container">
                  @foreach($job['image'] as $link)
                  <img class="grid-item" src="{{ 'storage/uploads/' . $link }}">
                  @endforeach
                </div>
              </li>
            @endforeach
            </ul>
        <img class="kop" src="images\ttd.png" style="margin-top: 20px;" loading="lazy" alt="Image">
    

    
</div>
</body>
</html>