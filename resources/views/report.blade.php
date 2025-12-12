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

.table-two {
  border-collapse: collapse;
  width: 100%;
  margin-left: 30px;
  margin-bottom: 20px;
}

.table-two td, .table-two th {
  padding: 3px;
}

.table-one {
  border-collapse: collapse;
  width: 100%;

}

.table-one td, .table-one th {
  border: 1px solid #000; 
  padding: 6px;
  text-align: center;
}

.table-one tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
<body>
<div class="container">
    <img class="kop" src="{{ asset('images/kop seloaji.jpg') }}" loading="lazy" alt="Image">
        <div style="text-align: center;">
            <h4 style="text-transform: uppercase;" >LAPORAN BUKTI DUKUNG LAPORAN E KINERJA BULAN
             <br>
             {{$date->month}} {{$date->year}}
            </h4>
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
    <h3 style="text-align: center; margin-top: -3px">{{$tugas->name}}</h3>
    <p style="font-weight: bold; margin-bottom:4px;">A. RENCANA AKSI :</p>
    <ul >
              @foreach($tugas['target'] as $job)
                 <li><p>{{ $job['name'] }} </p>
              </li>
            @endforeach
            </ul>

      
 <!-- <form action="{{ route('post') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $tugas->id }}">
    <input type="hidden" name="route" value="{{ $route }}">

    <textarea id="editor" name="content">
        {{ old('content', $tugas->post) }}
    </textarea>

    <button class="bg-blue-600 text-white px-4 py-2 mt-4">Save</button>
</form> -->
<div class="table-one">
    {!! $tugas->post !!}
</div>

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
</script>
            <ul >
              @foreach($tugas['target'] as $job)
                 @if(count($tugas->target[0]->laporan) > 4)
                 <li><div style="height: 70px;margin-bottom: 10px;"><p>{{ $job['name'] }} </p></div>
                  @else
                  <li><div style="margin-top: -10px;"><p>{{ $job['name'] }} </p></div>
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
    </div>
</body>
</html>