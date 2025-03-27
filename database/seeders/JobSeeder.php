<?php

namespace Database\Seeders;

use App\Models\Tugas;
use App\Models\Target;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;


class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penguji = Jabatan::create(['name' => 'Penguji Kendaraan Bermotor Terampil']);

        $uji1 = Tugas::create(['name' => 'Terlaksananya Pemeriksaan Unsur Administarsi Kendaraan Bermotor di Terminal', 'jabatan_id' => $penguji->id]);

        Target::create(['name' => 'Melakukan pemeriksaan dokumen bukti lulus uji berkala dan kartu pengawasan kendaraan', 'slug' => 'pengujia1', 'tugas_id' => $uji1->id]);
        Target::create(['name' => 'Melakukan validasi dokumen administrasi kendaraan', 'slug' => 'pengujia2', 'tugas_id' => $uji1->id]);

        $uji2 = Tugas::create(['name' => 'Terlaksananya Pemeriksaan Unsur Teknis Utama Kendaraan Bermotor di Terminal', 'jabatan_id' => $penguji->id]);

        Target::create(['name' => 'Melakukan Pengujian Sistem Penerangan dan Pengujian Sistem Pengereman Kendaraan Bermotor', 'slug' => 'pengujib1', 'tugas_id' => $uji2->id]);
        Target::create(['name' => 'Melakukan Pemeriksaan Kondisi Fisik Body Kendaraan dan Pemeriksaan Kondisi Ban Kendaraan', 'slug' => 'pengujib2', 'tugas_id' => $uji2->id]);

        $uji3 = Tugas::create(['name' => 'Terlaksananya Pemeriksaan Unsur Teknis Penunjang Kendaraan Bermotor di Terminal', 'jabatan_id' => $penguji->id]);

        Target::create(['name' => 'Melakukan Pengujian Fungsi Klakson, Speedometer dan Penghapus Kaca Kendaraan ', 'slug' => 'pengujic1', 'tugas_id' => $uji3->id]);
        Target::create(['name' => 'Melakukan Pemeriksaan Kondisi Fasilitas Tanggap Darurat Kendaraan serta Melakukan Pemeriksaan Kondisi dan Keberadaan Perlengkapan Kendaraan', 'slug' => 'pengujic2', 'tugas_id' => $uji3->id]);

        $uji4 = Tugas::create(['name' => 'Terlaksananya pemberian surat peringatan kepada armada Bus yang Melakukan Pelanggaran', 'jabatan_id' => $penguji->id]);

        Target::create(['name' => 'Mempersiapkan surat peringatan bagi kendaraan yang melanggar', 'slug' => 'pengujid1', 'tugas_id' => $uji4->id]);
        Target::create(['name' => 'Mengisi surat peringatan dengan pelanggaran yang telah di lakukan oleh armada yang melanggar', 'slug' => 'pengujid2', 'tugas_id' => $uji4->id]);
        Target::create(['name' => 'Melakukan dokumentasi guna Menberikan laporan kepada pimpinan', 'slug' => 'pengujid3', 'tugas_id' => $uji4->id]);

        $lalin = Jabatan::create(['name' => 'Petugas Lalu Lintas dan Angkutan Transportasi']);

        $lalin1 = Tugas::create(['name' => 'Terlaksananya pengaturan dan pengarahan angkutan dan penumpang di zona kedatangan, pengendapan dan keberangkatan', 'jabatan_id' => $lalin->id]);

        Target::create(['name' => 'Melakukan koordinasi dengan rekan satu regu untuk melakukan giat pengaturan Lalu Lintas dan pengawasan armada bus', 'slug' => 'lalina1', 'tugas_id' => $lalin1->id]);
        Target::create(['name' => 'Mengarahkan Bus untuk parkir sesuai dengan antrian jam keberangkatan', 'slug' => 'lalina2', 'tugas_id' => $lalin1->id]);
        Target::create(['name' => 'Memeriksa time table keberangkatan dan trayek bus sesuai dengan Kartu pengawasan', 'slug' => 'lalina3', 'tugas_id' => $lalin1->id]);

        $lalin2 = Tugas::create(['name' => 'Terlaksananya pencatatan jumlah kendaraan dan penumpang yang datang dan berangkat di terminal', 'jabatan_id' => $lalin->id]);

        Target::create(['name' => 'Melaksanakan pencatatan jumlah kendaraan yang masuk dan keluar pada Terminal tipe A', 'slug' => 'lalinb1', 'tugas_id' => $lalin2->id]);
        Target::create(['name' => 'Melaksanakan pencatatan jumlah penumpang yang masuk dan keluar pada Terminal tipe A', 'slug' => 'lalinb2', 'tugas_id' => $lalin2->id]);
        Target::create(['name' => 'Melakukan penginputan data produksi angkutan', 'slug' => 'lalinb3', 'tugas_id' => $lalin2->id]);

        $lalin3 = Tugas::create(['name' => 'Terlaksananya kegiatan rampcheck armada bus di dalam terminal', 'jabatan_id' => $lalin->id]);

        Target::create(['name' => 'Melakukan koordinasi dengan rekan satu regu untuk melakukan giat rampcheck', 'slug' => 'lalinc1', 'tugas_id' => $lalin3->id]);
        Target::create(['name' => 'Melakukan pengecekan ke armada baik dalam segi administrasi maupun teknis', 'slug' => 'lalinc2', 'tugas_id' => $lalin3->id]);
        Target::create(['name' => 'Melaksanakan pelaporan kegiatan dalam bentuk dokumentasi kepada pimpinan', 'slug' => 'lalinc3', 'tugas_id' => $lalin3->id]);

        $lalin4 = Tugas::create(['name' => 'Terlaksananya pemberian surat peringatan kepada armada yang melakukan pelanggaran bidang LLAJ', 'jabatan_id' => $lalin->id]);

        Target::create(['name' => 'Mempersiapkan surat peringatan bagi kendaraan yang melanggar', 'slug' => 'lalind1', 'tugas_id' => $lalin4->id]);
        Target::create(['name' => 'Mengisi surat peringatan dengan pelanggaran yang telah di lakukan oleh armada yang melanggar', 'slug' => 'lalind2', 'tugas_id' => $lalin4->id]);
        Target::create(['name' => 'Melakukan dokumentasi guna Menberikan laporan kepada pimpinan', 'slug' => 'lalind3', 'tugas_id' => $lalin4->id]);

        $transportasi = Jabatan::create(['name' => 'Petugas Transportasi Darat']);

        $transportasi1 = Tugas::create(['name' => 'Mengkoordinasikan penyelenggaraan kegiatan keamanan, kebersihan dan kesehatan kerja lingkungan di Terminal', 'jabatan_id' => $transportasi->id]);

        Target::create(['name' => 'Melakukan koordinasi dengan petugas keamanan dan kebersihan', 'slug' => 'transportasia1', 'tugas_id' => $transportasi1->id]);
        Target::create(['name' => 'Mengawasi pemenuhan standar keamanan dan kebersihan', 'slug' => 'transportasia2', 'tugas_id' => $transportasi1->id]);
        Target::create(['name' => 'Melaksanakan pelaporan kegiatan kepada pimpinan', 'slug' => 'transportasia3', 'tugas_id' => $transportasi1->id]);

        $transportasi2 = Tugas::create(['name' => 'Mengawasi dan menetapkan atau mengatur jalur keberangkatan dan kedatangan penumpang atau ruang tunggu penumpang', 'jabatan_id' => $transportasi->id]);

        Target::create(['name' => 'Mengarahkan penumpang ke ruang tunggu bagi yang akan melanjutkan perjalanan', 'slug' => 'transportasib1', 'tugas_id' => $transportasi2->id]);
        Target::create(['name' => 'Mengarahkan penumpang ke bus, sesuai dengan tujuan perjalanannya', 'slug' => 'transportasib2', 'tugas_id' => $transportasi2->id]);
        Target::create(['name' => 'Melaksanakan pengaturan di jalur keberangkatan dan kedatangan', 'slug' => 'transportasib3', 'tugas_id' => $transportasi2->id]);

        $transportasi3 = Tugas::create(['name' => 'Melaksanakan pengaturan parkir kendaraan bermotor di Terminal penumpang tipe A', 'jabatan_id' => $transportasi->id]);

        Target::create(['name' => 'Mengarahkan Armada yg masuk ke Terminal', 'slug' => 'transportasic1', 'tugas_id' => $transportasi3->id]);
        Target::create(['name' => 'Melaksanakan pengaturan parkir bus di Terminal ', 'slug' => 'transportasic2', 'tugas_id' => $transportasi3->id]);

        $transportasi4 = Tugas::create(['name' => 'Memberikan informasi kepada penumpang di Terminal', 'jabatan_id' => $transportasi->id]);

        Target::create(['name' => 'Melaksanakan pemberian informasi waktu keberangkatan bus kepada penumpang', 'slug' => 'transportasid1', 'tugas_id' => $transportasi4->id]);
        Target::create(['name' => 'Memberikan informasi kepada pengemudi Armada bus, apabila sudah waktunya pemberangkatan bus', 'slug' => 'transportasid2', 'tugas_id' => $transportasi4->id]);

        $pengolah = Jabatan::create(['name' => 'Pengolah Data dan Informasi']);

        $pengolah1 = Tugas::create(['name' => 'Mengumpulkan dan memeriksa data terkait pengelolaan terminal penumpang tipe A', 'jabatan_id' => $pengolah->id]);

        Target::create(['name' => 'Mengumpulkan data kendaraan yang datang dan berangkat di terminal', 'slug' => 'pengolaha1', 'tugas_id' => $pengolah1->id]);
        Target::create(['name' => 'mengumpulkan data penumpang yang datang dan berangkat di terminal', 'slug' => 'pengolaha2', 'tugas_id' => $pengolah1->id]);
        Target::create(['name' => 'Mencatat waktu kedatangan dan Keberangkatan Bus di Terminal', 'slug' => 'pengolaha3', 'tugas_id' => $pengolah1->id]);

        $pengolah2 = Tugas::create(['name' => 'Menganalisis data terkait pengelolaan terminal penumpang tipe A', 'jabatan_id' => $pengolah->id]);

        Target::create(['name' => 'Mengumpulkan dan Menganalisis data produksi perkembangan Terminal', 'slug' => 'pengolahb1', 'tugas_id' => $pengolah2->id]);
        Target::create(['name' => 'Mengolah data yang sudah Terkumpul', 'slug' => 'pengolahb2', 'tugas_id' => $pengolah2->id]);
        Target::create(['name' => 'Menginput data keberangkatan dan kedatangan ke aplikasi strategi hub', 'slug' => 'pengolahb3', 'tugas_id' => $pengolah2->id]);

        $pengolah3 = Tugas::create(['name' => 'Tersusunya laporan hasil rekapitulasi data kedatangan dan keberangkatan armada Bus di Terminal tipe A', 'jabatan_id' => $pengolah->id]);

        Target::create(['name' => 'Melakukan koordinasi dengan rekan satu Tim untuk merekapitulasi data di Terminal', 'slug' => 'pengolahc1', 'tugas_id' => $pengolah3->id]);
        Target::create(['name' => 'Merekap hasil kegiatan berdasarkan data yang sudah di kumpulkan', 'slug' => 'pengolahc2', 'tugas_id' => $pengolah3->id]);

        $pengolah4 = Tugas::create(['name' => 'Melaporkan pelaksanaan dan hasil kegiatan kepada atasan sebagai bahan evaluasi dan pertanggungjawaban', 'jabatan_id' => $pengolah->id]);

        Target::create(['name' => 'Mengumpulkan data Hasil Rekapitulasi', 'slug' => 'pengolahd1', 'tugas_id' => $pengolah4->id]);
        Target::create(['name' => 'Melaporkan Data Hasil pelaksanaan dan kegiatan kepada pimpinan', 'slug' => 'pengolahd2', 'tugas_id' => $pengolah4->id]);
    }
}
