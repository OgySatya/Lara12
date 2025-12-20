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
li {
  margin-bottom: 10px;
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

.table-two {
  border-collapse: collapse;
  width: 100%;
  margin-left: 30px;
  margin-bottom: 20px;
}

.table-two td, .table-two th {
  padding: 3px;
  font-family: Arial, sans-serif;  /* Sets the font */
  font-size: 16px;                /* Sets the font size */
  line-height: 1.5; 
}


.simple-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  font-family: Arial, sans-serif;
}

.simple-table th, .simple-table td {
  padding: 10px;
  text-align: center;
  border: 1px solid #ddd;
}


</style>
<body>
<div class="container">
     <img class="kop" src="storage\main\kop seloaji.jpg" loading="lazy" alt="Image">
        <div style="text-align: center;">
            <p style="text-transform: uppercase; font-weight: bold;" >LAPORAN BUKTI DUKUNG LAPORAN E KINERJA BULAN
             <br>
             {{$date->month}} {{$date->year}}
            </p>
        </div>
        <div>
                    <table class="table-two">
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
    <p style="font-weight: bold; margin-top:4px;">A.   RENCANA HASIL KERJA :</p>
    <p style="font-weight: bold;margin-left:20px ">{{$tugas->name}}</p>
    <p style="font-weight: bold; margin-bottom:4px;">B.   RENCANA AKSI :</p>
    <ul style="margin-left:15px ; list-style-type: number; ">
              @foreach($tugas['target'] as $job)
                 <li style="margin-bottom : -10px">
                  <p>{{ $job['name'] }} </p>
              </li>
            @endforeach
            </ul>
<div class="simple-table">
    {!! $tugas->post !!}
</div>
       <ul >
              @foreach($tugas['target'] as $job)
                 @if(count($tugas->target[0]->laporan) > 4)
                 <li style="list-style-type: upper-roman;"><div style="height: 70px;margin-bottom: 10px;"><p>{{ $job['name'] }} </p></div>
                  @else
                  <li style="list-style-type: upper-roman;"><div style="margin-top: -10px;"><p>{{ $job['name'] }} </p></div>
                  @endif
                <div class="gird-container">
                  @foreach($job['laporan'] as $link)
                  <img class="grid-item" src="{{ 'storage/uploads/' . $link }}">
                  @endforeach
                </div>
              </li>
            @endforeach
            </ul>
        <img class="kop" src="images\ttd.png" style="margin-top: 20px;" loading="lazy" alt="Image">
    

    <!-- <form action="{{ route('post') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $tugas->id }}">
        <input type="hidden" name="route" value="{{ $route }}">

        <textarea id="editor" name="content">
            {{ old('content', $tugas->post) }}
        </textarea>

        <button class="bg-blue-600 text-white px-4 py-2 mt-4">Save</button>
    </form>
    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            toolbar: [
                'heading',
                'bold','italic','underline','link',
                'bulletedList','numberedList','blockQuote',
                'insertTable','undo','redo'
            ],
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells'
                ]
            }
        })
        .catch(error => console.error(error));
    </script> -->
        
</div>
</body>
</html>