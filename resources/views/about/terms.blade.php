@extends('layouts.depotile', ['title' => 'Syarat dan Ketentuan'])

@section('css')
@stop

@section('js')
@stop

@section('content')
    <!-- <div class="titleProfileWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="titleSubProfileWrap">
                        <h2 class="category1">Profil Saya</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="profileContent aboutContent">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('about.aboutMenu')
                </div>
                <div class="col-sm-9 leftBor">
                    <div class="profileMain aboutMain">
                        <div class="text-center">
                            <h2>Syarat dan Ketentuan</h2>
                        </div>
                        <ol>
                            <li><strong>PENDAFTARAN UNTUK LAYANAN BELANJA</strong></li>
                            <ul>
                                <li>Jika anda ingin memesan salah satu produk yang terdaftar di DEPOTILE.COM, Anda diharuskan untuk mendaftar dan mempunyai akun di DEPOTILE.COM dimana Anda dapat mengakses di dalam Situs melalui “Profil Saya”. Untuk pendaftaran Anda diharapkan memasukkan Nama, Alamat, E-mail, dan beberapa informasi pribadi lainnya. Untuk lebih jelasnya, Anda bisa melihat <a href="{{ url('privacy-policy') }}">Privacy Policy</a>.</li>
                            </ul>
                            <br>
                            <li><strong>PENGGUNAAN SITUS</strong></li>
                            <ul>
                                <li>Kami memberi Anda lisensi yang tidak dapat dipindah tangankan dan dapat dibatalkan untuk menggunakan Situs ini, di bawah Syarat dan Ketentuan dijelaskan, untuk tujuan belanja produk pribadi yang dijual di Situs. Penggunaan komersial atau penggunaan atas nama pihak ketiga dilarang, kecuali sebagaimana secara tegas diizinkan oleh kami sebelumnya. Setiap pelanggaran dari Syarat dan Ketentuan ini akan mengakibatkan pencabutan langsung dari lisensi yang diberikan dalam ayat ini tanpa pemberitahuan kepada Anda. Konten yang disediakan di Situs ini adalah semata-mata untuk tujuan informasi. Produk representasi diekspresikan pada Situs ini adalah dari vendor dan tidak dibuat oleh kami. Opini di dalam Situs ini adalah pendapat dari posting individu konten tersebut dan tidak berasal dari pendapat kami. Layanan tertentu dan fitur terkait yang mungkin tersedia pada Situs mungkin memerlukan registrasi atau berlangganan. Jika Anda memilih untuk mendaftar atau berlangganan untuk setiap layanan atau fitur terkait, Anda setuju untuk memberikan informasi akurat dan terkini tentang diri Anda, dan untuk segera memperbarui informasi tersebut apabila ada perubahan. Setiap pengguna Situs ini bertanggungjawab untuk menjaga sandi atau pengenal akun lainnya agar tetap aman dan terjaga. Pemilik akun bertanggung jawab penuh atas semua kegiatan yang dilakukan berkaitan dengan sandi atau akun. Selain itu, Anda harus memberitahu kami apabila ada penyalahgunaan terhadap sandi atau akun Anda. Situs tidak bertanggung jawab atau berkewajiban, secara langsung atau tidak langsung, dengan cara apapun atas kerugian atau kerusakan apapun yang timbul sebagai akibat dari, atau sehubungan dengan, kegagalan Anda untuk mematuhi bagian ini. Selama proses pendaftaran Anda setuju untuk menerima e-mail promosi dari Situs. Anda kemudian dapat menghentikan penerimaan seperti promosi e-mail dengan mengklik pada link di bagian bawah e-mail promosi.</li>
                            </ul>
                            <br>
                            <li><strong>KETENTUAN PENJUALAN</strong></li>
                            <ul>
                                <li>Ketika menempatkan pesanan, Anda menunjukkan keinginan untuk membeli produk dan tunduk pada Syarat dan Ketentuan yang berlaku. Semua pesanan tergantung pada ketersediaan dan konfirmasi dari harga pesanan.</li>
                                <li>Waktu pengiriman dapat bervariasi sesuai dengan ketersediaan. Kami tidak bertanggung jawab atas setiap keterlambatan akibat penundaan pengiriman yang dilakukan oleh jasa pengiriman rekanan kami atau yang disebabkan karena adanya force majeure lainnya. Silakan lihat di Pengiriman.</li>
                                <li>Dalam rangka kontrak dengan DEPOTILE.COM Anda harus dapat melakukan pembayaran yang sah dan sesuai kepada kami, melalui jalur hukum DEPOTILE.COM berhak untuk menolak permintaan yang dibuat oleh Anda. Jika pesanan Anda diterima, kami akan memberitahu Anda melalui e-mail bahwa pesanan Anda telah ditempatkan di sistem kami dan sedang menunggu pembayaran. Kami juga akan memberitahu Anda dalam e-mail yang sama mengenai rincian pembayaran dan metode seperti yang anda pilih untuk melakukan pembayaran. Ketika menempatkan pesanan Anda, anda menjamin bahwa semua informasi yang Anda berikan kepada kami adalah benar dan akurat, dan bahwa Anda adalah pengguna resmi dari kartu kredit/debit atau rekening bank yang digunakan untuk menempatkan pesanan Anda, dan bahwa ada dana yang cukup untuk menutupi biaya yang Anda order. Biaya produk dan layanan dapat berfluktuasi. Semua harga yang diiklankan di Situs tunduk pada perubahan tersebut tanpa pemberitahuan sebelumnya kepada Anda.</li>
                            </ul>
                            <br>
                            <li><strong>PEMESANAN</strong></li>
                            <ul>
                                <li>Pemesanan produk via website dilakukan akan diproses dan dikirim hingga sampai ke lokasi pengiriman dalam jangka waktu paling lambat 7 hari. Apabila Anda ingin agar proses pengiriman lebih cepat dari waktu yang telah ditentukan, maka pemesanan dapat dikonfirmasi dulu via telepon.</li>
                                <ol type="a">
                                    <li>Kontrak Penjualan</li>
                                    <ul>
                                        <li>Ketika Anda melakukan pemesanan, Anda akan menerima pengakuan e-mail konfirmasi penerimaan pesanan Anda dan bahwa pesanan Anda sedang menunggu pembayaran. Harap diperhatikan bahwa e-mail tersebut hanyalah e-mail pemberitahuan dan bukan merupakan kontrak finalisasi pesanan Anda atau bentuk kontrak penjualan. Sebuah kontrak penjualan tidak akan terbentuk sampai kami mengirimkan konfirmasi melalui e-mail bahwa pembayaran Anda telah diterima dan bahwa produk yang dipesan akan dikirim kepada Anda. Hanya produk yang tercantum dalam e-mail yang dikirim pada saat pengiriman akan dimasukkan dalam kontrak terbentuk.</li>
                                    </ul>
                                    <li>Harga dan Ketersediaan</li>
                                    <ul>
                                        <li>Sementara kami melakukan yang terbaik untuk memastikan bahwa semua detail, deskripsi, ketersediaan, dan harga dari produk yang muncul di Situs ini adalah akurat, kesalahan mungkin terjadi dari berkala. Jika kami menemukan kesalahan dalam harga atau ketersediaan produk yang Anda pesan, kami akan memberitahu Anda tentang hal ini segera dan memberi Anda pilihan untuk reconfirming pesanan Anda dengan harga yang benar atau membatalkan pesanan tersebut. Kami akan mengabarkan kepada Anda paling lambat 2 hari kerja setelah Anda melakukan pemesanan. Apabila melewati batas waktu tersebut maka DEPOTILE.COM akan memberikan kompensasi berupa penggantian produk dengan penambahan nilai 5% dari nilai produk yang bersangkutan. Jika kami tidak dapat menghubungi Anda atau menerima formulir pengakuan Anda, kami akan mengkondisikan bahwa pesanan tersebut dibatalkan. Anda dapat melihat bahwa pesanan Anda telah dibatalkan melalui halaman”Pesanan”. Jika Anda membatalkan namun Anda telah membayar untuk produk tersebut, Anda akan menerima pengembalian dana penuh. Biaya pengiriman akan dibebankan di samping semua harga yang ditampilkan, biaya tambahan tersebut akan ditampilkan dengan jelas mana yang berlaku dan termasuk dalam total biaya sebelum menempatkan pesanan Anda.</li>
                                    </ul>
                                    <li>Pembayaran</li>
                                    <ul>
                                        <li>Setelah menerima pesanan Anda, e-mail pemberitahuan akan dikirim kepada Anda untuk mengkonfirmasikan penerimaan dan rincian pembayaran. Pada tahap ini, pesanan Anda belum selesai dan masih “Pending”. Setelah kami menerima dana yang cukup dari Anda dan pembayaran Anda dikonfirmasi, kami akan mengirimkan e-mail pemberitahuan yang menunjukkan bahwa pesanan Anda akan segera dikirim.</li>
                                    </ul>
                                    <li>Kode Diskon</li>
                                    <ul>
                                        <li>Kode diskon akun - kode Diskon mungkin dari waktu ke waktu akan ditawarkan kepada pemegang akun, kode tersebut hanya dapat digunakan untuk pembelian yang dilakukan melalui akun terdaftar di mana kode diskon ditawarkan. Akun kode diskon tidak dapat dipindahtangankan.</li>
                                        <li>Kode diskon promosi – kami mungkin dari waktu ke waktu menawarkan kode diskon promosi yang berlaku untuk pembelian promo produk tertentu yang dilakukan Situs ini.</li>
                                    </ul>
                                </ol>
                            </ul>
                            <br>
                            <li><strong>PENGIRIMAN</strong></li>
                            <ul>
                                <li>DEPOTILE.COM bertujuan untuk mengirimkan produk yang telah anda beli di DEPOTILE.COM pada tanggal yang telah disepakati pada saat pembelian.</li>
                                <li>Pengiriman produk akan dilakukan oleh pihak DEPOTILE.COM atau gudang dari produk yang bersangkutan. Ketika kami sudah menyetujui pesanan Anda, kami akan menjadwalkan untuk mengirim pesanan Anda.</li>
                                <li>Kami akan memberitahu Anda melalui e-mail dan telepon apabila ada keterlambatan dalam pengiriman.</li>
                                <li>Setelah Anda menerima pesanan, Anda mungkin akan diharuskan untuk menandatangani berkas pengiriman. Setelah menerima, Anda harus segera memeriksa produk tersebut dan diharapkan untuk mengontak DEPOTILE.COM di 021- 224 55 224 atau hello@depotile.com apabila jika terjadi kesalahan pengiriman, ataupun kerusakan produk, Anda harus langsung mengkonfirmasikan kepada pihak DEPOTILE.COM.</li>
                                <li>Setelah Anda menerima produk DEPOTILE.COM, pihak supplier dan DEPOTILE.COM tidak bertanggung jawab atas kehilangan dan kerusakan produk.</li>
                                <li>Jika pengiriman Anda tertunda dikarenakan penolakan Anda yang tidak masuk akal dalam menerima produk ataupun Anda tidak menerima produk dari pengirim , atau pengirim tidak dapat menemukan lokasi pengiriman Anda maka kami mungkin melakukan beberapa hal dibawah ini:</li>
                                <ul>
                                    <li>Mengenakan biaya tambahan apabila kesalahan terletak di Anda ataupun kami akan membayar biaya tambahan apabila kesalahan terletak di kami.</li>
                                    <li>Meminta konsumen untuk mengambil produk di gudang DEPOTILE.COM.</li>
                                </ul>
                                <li>Apabila terjadi force majeur yang menyebabkan pengiriman produk tidak dapat dilakukan, DEPOTILE.COM akan mengatur kembali jadwal pengiriman dan Konsumen akan membebaskan DEPOTILE.COM dari segala jenis tuntutan.</li>
                            </ul>
                            <br>
                            <li><strong>MODIFIKASI DAN PERUBAHAN SYARAT DAN KETENTUAN</strong></li>
                            <ul>
                                <li>DEPOTILE.COM memiliki hak dalam membuat kebijaksanaan untuk memodifikasi, mengubah, menambah, atau mengganti salah satu dari Syarat dan Ketentuan setiap saat tanpa pemberitahuan terlebih dahulu. DEPOTILE.COM juga dapat menerapkan pembatasan pada fitur dan Layanan atau semua Layanan tanpa berkewajiban untuk melakukan pemberitahuan. Silahkan periksa halaman ini secara berkala untuk mengetahui setiap perubahan. Anda mengerti dan setuju bahwa saat Anda melanjutkan akses ke atau penggunaan Situs setelah setiap telah ada perubahan yang dicantumkan ke Syarat dan Ketentuan, menunjukkan Anda menerima setiap perubahan Syarat dan Ketentuan tersebut.</li>
                            </ul>
                            <br>
                            <li><strong>HAK CIPTA LISENSI</strong></li>
                            <ul>
                                <li>Semua hak kekayaan intelektual, apakah terdaftar atau tidak terdaftar, di Situs,informasi konten pada Situs dan semua desain website, termasuk, namun tidakterbatas pada, teks, grafik, perangkat lunak, foto, video, musik, suara, dan pilihan mereka dan pengaturan, dan semua kompilasi perangkat lunak, kode sumber yang mendasari dan perangkat lunak akan tetap milik kita. Seluruh isi dari Situs ini juga dilindungi oleh hak cipta sebagai karya kolektif di bawah hukum hak cipta Indonesia dan konvensi internasional. Semua hak dilindungi.</li>
                            </ul>
                            <br>
                            <li><strong>SITUS PIHAK KETIGA, SITUS <i>LINKED</i> PRODUK DAN LAYANAN</strong></li>
                            <ul>
                                <li>Situs ini mungkin berisi link ke situs web pihak ketiga (Linked Sites). Kami tidak mengontrol atau mengoperasikan salah satu Linked Sites dan Anda setuju bahwa kami tidak bertanggung jawab atas isi dan penggunaan Anda dari Linked Sites tersebut. Akses dan penggunaan Linked Sites, termasuk informasi, materi, produk, dan jasa pada atau tersedia melalui Linked Sites adalah semata-mata risiko Anda sendiri. Dalam setiap kasus di mana Anda berurusan dengan bisnis lain atau pihak ketiga ditemukan melalui Situs ini atau Linked Sites, transaksi hanya dilakukan antara Anda dan pihak lainnya. Anda setuju bahwa kami tidak akan bertanggung jawab atas kerugian atau kerusakan apapun yang timbul sebagai akibat adanya transaksi tersebut atau sebagai akibat dari kehadiran pihak ketiga tersebut pada Situs ini.</li>
                            </ul>
                            <br>
                            <li><strong>BATASAN TANGGUNG JAWAB</strong></li>
                            <ul>
                                <li>Konten yang ditampilkan pada Situs ini disediakan tanpa jaminan, kondisi, atau garansi untuk akurasinya. Dalam situasi apapun, kami tidak bertanggung jawab secara langsung, tidak langsung, insidental, konsekuensial, ganti rugi atau khusus apapun (termasuk, tanpa batasan, yang dihasilkan dari kehilangan keuntungan, kehilangan data, gangguan usaha, kerusakan goodwill, atau reputasi, atau biaya pengadaan barang dan jasa pengganti) yang timbul dari penggunaan, ketidakmampuan untuk penggunaan, atau kesalahan atau kelalaian dalam isi atau fungsi dari Situs ini, bahkan jika kami atau perwakilan resmi daripadanya telah diberitahukan mengenai kemungkinan kerusakan tersebut. Jika penggunaan bahan, informasi atau jasa dari Situs ini atau Linked Sites mengakibatkan kerusakan pada Anda atau kebutuhan untuk melayani, perbaikan atau koreksi peralatan atau data, Anda menanggung semua biaya tersebut.</li>
                            </ul>
                            <br>
                            <li><strong>HUKUM YANG BERLAKU</strong></li>
                            <ul>
                                <li>Syarat dan Ketentuan ini akan ditafsirkan dan diatur oleh hukum yang berlaku di Jakarta, Indonesia. Tunduk pada bagian Arbitrase di bawah ini, masing-masing pihak dengan ini setuju untuk tunduk kepada yurisdiksi pengadilan dari Jakarta dan untuk mengesampingkan keberatan berdasarkan tempat.</li>
                            </ul>
                            <br>
                            <li><strong>ARBITRASE</strong></li>
                            <ul>
                                <li>Kontroversi, klaim atau sengketa yang timbul dari atau berhubungan dengan Syarat dan Ketentuan ini akan disebut dan akhirnya diselesaikan oleh arbitrase mengikat pribadi dan rahasia sebelum arbiter tunggal yang diselenggarakan di Jakarta, Indonesia dalam Bahasa dan diatur oleh hukum Indonesia berdasarkan Peraturan komersial Konsiliasi dan Arbitrasi, sebagaimana telah diubah, diganti atau kembali diberlakukan dari waktu ke waktu. Arbiter harus menjadi orang yang dilatih secara hukum dan yang memiliki pengalaman di bidang teknologi informasi di Jakarta dan tidak tergantung pada salah satu pihak. Sekalipun demikian, Situs berhak untuk mengejar perlindungan hak kekayaan intelektual dan informasi rahasia melalui bantuan yang berkeadilan injunctive atau melalui pengadilan.</li>
                            </ul>
                            <br>
                            <li><strong>PEMUTUSAN</strong></li>
                            <ul>
                                <li>Selain setiap bantuan hukum atau sebanding lain nya, kita dapat, tanpa pemberitahuan sebelumnya kepada Anda, segera mengakhiri Syarat dan Ketentuan atau mencabut salah satu atau semua hak Anda sesuai dengan Syarat dan Kondisi. Setelah pemutusan Perjanjian ini, Anda harus segera menghentikan semua akses ke penggunaan Situs dan kami harus, di samping setiap pemulihan hukum yang adil atau lainnya, segera mencabut semua sandi dan identifikasi akun dikeluarkan untuk Anda dan menolak akses Anda dan penggunaan Situs ini secara keseluruhan atau sebagian. Pemutusan perjanjian ini tidak akan mempengaruhi hak dan kewajiban masing-masing (termasuk tanpa batasan, kewajiban pembayaran) dari pihak yang timbul sebelum tanggal pengakhiran. Anda selanjutnya setuju bahwa Situs tidak bertanggung jawab kepada Anda atau kepada orang lain sebagai akibat dari penangguhan atau pengakhiran tersebut. Jika Anda tidak puas dengan Situs atau dengan syarat, kondisi, aturan, kebijakan, pedoman, atau praktik DEPOTILE.COM dalam mengoperasikan Situs, upaya hukum Anda tunggal dan eksklusif untuk menghentikan penggunaan Situs.</li>
                            </ul>
                            <br>
                            <li><strong>PENGGANTIAN RUGI</strong></li>
                            <ul>
                                <li>Anda mengerti dan setuju bahwa Anda secara pribadi bertanggung jawab atas perilaku Anda di Situs. Anda setuju untuk menanggung (mengganti rugi), membebaskan, dan mengambil alih segala kerugian DEPOTILE.COM, perusahaan payungnya (perusahaan diatas DEPOTILE.COM), perusahaan cabangnya (perusahaan lain dibawah DEPOTILE.COM), perusahaan yang menggabungkan diri, perusahaan baru yang berdiri dari hasil kerjasama antara perusahaan lain dengan DEPOTILE.COM, business partners, licensors (perusahaan yang memberi license kepada DEPOTILE.COM), karyawan, agen-agen dan pemberi informasi pihak ketiga yang berhubungan pada jasa tersebut dengan semua tuntutan, kehilangan, biaya, kerusakan, sebagai akibat dan menjadi peringatan dan kerusakan tidak langsung dan biaya pengacara yang masuk akal, yang disebabkan dari penggunaan Anda, kesalahgunaan, atau ketidakmampuan dalam menggunakan Situs, jasa atau isi, atau penyalahgunaan apapun yg Anda lakukan dari ketentuan pengunaan ini.</li>
                            </ul>
                            <br>
                            <li><strong>MENGHUBUNGKAN KE HALAMAN UTAMA KAMI</strong></li>
                            <ul>
                                <li><i>Link</i> ke halaman utama kami (http://www.depotile.com) diperbolehkan, asalkan hubungan dilakukan dengan cara yang adil dan legal dan, sehingga tidak merusak reputasi kami atau mengambil keuntungan dari itu, tetapi Anda tidak dapat membentuk <i>link</i> dalam cara yang menunjukkan segala bentuk hubungan, persetujuan, atau dukungan pada bagian kami bila belum ada ijin tertulis secara tertulis resmi. Anda tidak mungkin membangun <i>link</i> dari Situs yang Anda tidak memiliki kepemilikan. Situs ini dan layanan mungkin tidak dibingkai pada setiap situs lain, atau mungkin Anda membuat <i>link</i> ke bagian manapun dari Situs ini selain halaman rumah. Kami berhak untuk menarik kembali ijin menghubungkan tanpa pemberitahuan sebelumnya kepada Anda.</li>
                            </ul>
                            <br>
                            <li><strong>KEPEMILIKAN MEREK DAGANG, NAMA DAN GAMBAR ORANG, HAK CIPTA PIHAK KETIGA</strong></li>
                            <ul>
                                <li>Semua orang (termasuk nama mereka dan gambar), merek dagang pihak ketiga dan gambar produk pihak ketiga, jasa, atau lokasi ditampilkan di Situs ini sama sekali tidak berkaitan atau berafiliasi dengan DEPOTILE.COM, kecuali sebaliknya secara tegas dinyatakan. Setiap merek dagang/nama ditampilkan pada Situs ini dimiliki oleh pemilik merek dagang masing-masing. Apabila suatu merek dagang atau merek disebut, itu hanya digunakan untuk menggambarkan atau mengidentifikasi produk dan jasa dan tidak dalam cara suatu pernyataan bahwa produk atau jasa yang didukung oleh atau terhubung ke DEPOTILE.COM.</li>
                            </ul>
                            <br>
                            <li><strong>KETIDAKABSAHAN</strong></li>
                            <ul>
                                <li>Jika ada bagian dari Syarat dan Ketentuan ini tidak dapat dilaksanakan (termasuk ketentuan di mana kita mengesampingkan tanggung jawab kami), keberlakuan dari setiap bagian lain dari Syarat dan Ketentuan ini tidak akan terpengaruh dengan semua kondisi lain yang tersisa dalam kekuatan penuh dan efek. Jadi sejauh mungkin di mana kondisi atau bagian dari kondisi dapat dilepaskan untuk membuat sisanya berlaku, kondisi tersebut harus ditafsirkan sesuai. Atau, Anda setuju bahwa kondisi tersebut harus diperbaiki dan diinterpretasikan dengan cara yang mirip dengan makna asli dari kondisi yang diizinkan oleh hukum.</li>
                            </ul>
                        </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop