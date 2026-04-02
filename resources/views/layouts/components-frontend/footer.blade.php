    <footer class="footer-area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100 d-flex flex-wrap align-items-center justify-content-between">
                    <!-- Footer Social Info -->
                    <!-- Footer Logo -->
                    <div class="footer-logo">
                        <a href="#"><img src="{{asset('assets/frontend/img/core-img/logo.png')}}" alt=""></a>
                    </div>
                    <!-- Copywrite -->
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>
    <style>
    /* Mengatur ukuran logo di footer agar lebih kecil dan proporsional */
    .footer-logo img {
        max-height: 40px; /* Atur tinggi sesuai selera, 40px biasanya sudah pas */
        width: auto;
        display: block;
        transition: all 0.3s ease;
    }

    /* Merapikan susunan footer agar benar-benar di tengah secara vertikal */
    .footer-area {
        padding: 20px 0; /* Memberi ruang napas atas bawah */
        background-color: #f8f9fa; /* Opsional: warna background footer */
    }

    .footer-area p {
        margin-bottom: 0; /* Menghilangkan margin bawah pada teks copyright */
        font-size: 13px;
    }

    /* Responsif untuk tampilan HP */
    @media only screen and (max-width: 767px) {
        .footer-area .d-flex {
            flex-direction: column; /* Logo dan teks jadi tumpuk di HP */
            text-align: center;
        }
        .footer-logo {
            margin-bottom: 15px;
        }
    }
</style>