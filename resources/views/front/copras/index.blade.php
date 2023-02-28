@extends('front.layout')

@section('content')

<nav class="site-nav">
  <div class="container">
    <div class="site-navigation">
      <span class="logo m-0">SPK Skincare <span class="text-primary">.</span></span>
      <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('produk') }}">Produk</a></li>
        @auth
        <li><a href="{{ url('profile') }}">Profile</a></li>
				<li class="has-children active">
					<a><b>Perhitungan</b></a>
					<ul class="dropdown">
						<li class="active"><a href="{{ url('copras') }}"><b>Metode COPRAS</b></a></li>
						<li><a href="{{ url('moora') }}">Metode MOORA</a></li>
						<li><a href="{{ url('perbandingan') }}">Perbandingan COPRAS & MOORA</a></li>
					</ul>
				</li>
        <li>&nbsp;&nbsp;&nbsp;</li>
        <li>
          <form action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-block" style="color:#fff;"><b>Logout</b></button>
          </form>
        </li>
        @else
        <li>&nbsp;&nbsp;&nbsp;</li>
        <li><a href="{{ url('login') }}" class="btn btn-primary btn-block" style="color:#fff;"><b>Login</b></a></li>
        @endauth
      </ul>
      <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </div>
</nav>

<div class="hero">
  <div class="container">
    <div class="row">
      <h1 class="text-primary" style="text-align:center"><b>Metode COPRAS</b></h1>
      <a href="#" class="btn btn-info col-sm-3" style="color:#fff;margin:auto;" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Lihat Proses Perhitungan</a>
      <div class="row">
        <div class="col-sm-2" style="margin:10vh 0px 7vh 0;">
          <form method="POST" action="{{ url('copras') }}" enctype="multipart/form-data">
          @csrf
            <div class="row mt-3">
              <div class="col-sm">
                <label class="col-form-label"><b>Filter Merk Produk</b></label>
                @foreach($brands as $brand)
                <br><input class="" type="checkbox" value="{{ $brand->merk }}" name="reqbrand[]" id="reqbrand" <?php if(str_contains($reqbrand, $brand->merk)) { ?> checked="" <?php } ?>><label>&nbsp; {{ $brand->merk }}</label>
                @endforeach
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-sm">
                <label class="col-form-label"><b>Filter Harga Produk</b></label>
                <input class="col-sm" type="number" value="{{ $reqmin }}" min=0 placeholder="Harga Minimal" id="reqmin" name="reqmin" /><br>
                <input class="col-sm mt-1" type="number" value="{{ $reqmax }}" min=0 placeholder="Harga Maksimal" id="reqmax" name="reqmax" />
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-sm">
                <button type="submit" class="btn btn-primary" style="padding:5px 20px;border-radius:5px;">Cari</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-sm-10">
          <?php if(isset($data->jeniskelamin) && isset($data->tipekulit) && isset($data->usia)) { ?>
          <div class="col-sm">
            @foreach($kategoriproduks as $kategoriproduk)
            <div class="row" style="margin:10vh 0px 7vh 0;text-align:center;">
              <h2 style="color:#fff;"><b>{{ $kategoriproduk->nama }}</b></h2>
              <?php
                $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                if($countproductbykategori > 0) {
              ?>
                <div class="perhitungan-hidden" style="display:none;">
                  <div class="perhitungan-hidden-satu">
                    <?php
                      // START Sigma 1/S-i
                        $sigma_satupersmini_hidden = 0;
                        $sigma_satupersmini_tipekulit_hidden = 0;
                        $sigma_satupersmini_jeniskelamin_hidden = 0;
                        $sigma_satupersmini_kemudahanpencarian_hidden = 0;
                        $sigma_satupersmini_komposisiberbahaya_hidden = 0;
                        $array_sigma_satupersmini_hidden = array();
                      // ENS Sigma 1/S-i
                      // START Sigma S-i
                        $sigma_smini_tipekulit_hidden = 0;
                        $sigma_smini_jeniskelamin_hidden = 0;
                        $sigma_smini_kemudahanpencarian_hidden = 0;
                        $sigma_smini_komposisiberbahaya_hidden = 0;
                        $sigma_smini_hidden = 0;
                        $array_sigma_smini_hidden = array();
                      // END Sigma S-i
                      // START S+i
                        $terbobotbenefit_tipekulit = 0;
                        $terbobotbenefit_jeniskelamin = 0;
                        $terbobotbenefit_kemudahanpencarian = 0;
                        $terbobotbenefit_komposisiberbahaya = 0;
                        $terbobotbenefit = 0;
                      // END S+i

                      foreach($produks as $produk) {
                        if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                        // START Sigma 1/S-i
                          // Data berdasarkan tipe kulit yang sama seperti user
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_satupersmini_tipekulit_hidden = 1/(($bytipekulit->nilai/$pembagi)*$bobot);
                              }
                            }
                          }
                          // Data berdasarkan jenis kelamin yang sama seperti user
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_satupersmini_jeniskelamin_hidden = 1/(($byjeniskelamin->nilai/$pembagi)*$bobot);
                              }
                            }
                          }
                          // Data berdasarkan kemudahan pencarian
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                $sigma_satupersmini_kemudahanpencarian_hidden = 1/(($bykemudahanpencarian->nilai/$pembagi)*$bobot);
                              }
                            }
                          }
                          // Data berdasarkan komposisi berbahaya
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_satupersmini_komposisiberbahaya_hidden = 1/(($bykomposisiberbahaya->nilai/$pembagi)*$bobot);
                              }
                            }
                          }
                          // Hitung keseluruhan nilai data atau per-row
                          $sigma_satupersmini_hidden = $sigma_satupersmini_tipekulit_hidden+$sigma_satupersmini_jeniskelamin_hidden+$sigma_satupersmini_kemudahanpencarian_hidden+$sigma_satupersmini_komposisiberbahaya_hidden;
                          $array_sigma_satupersmini_hidden[] = $sigma_satupersmini_hidden;
                        // END Sigma 1/S-i

                        // START Sigma S-i
                          // Data berdasarkan tipe kulit yang sama seperti user
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_smini_tipekulit_hidden = ($bytipekulit->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Data berdasarkan jenis kelamin yang sama seperti user
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_smini_jeniskelamin_hidden = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Data berdasarkan kemudahan pencarian
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_smini_kemudahanpencarian_hidden = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Data berdasarkan komposisi berbahaya
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $sigma_smini_komposisiberbahaya_hidden = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Hitung keseluruhan nilai data atau per-row
                          $sigma_smini_hidden = $sigma_smini_tipekulit_hidden+$sigma_smini_jeniskelamin_hidden+$sigma_smini_kemudahanpencarian_hidden+$sigma_smini_komposisiberbahaya_hidden;
                          $array_sigma_smini_hidden[] = $sigma_smini_hidden;
                        // END Sigma S-i

                        // START S+i
                          // Data berdasarkan tipe kulit yang sama seperti user
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                // echo $terbobotbenefit_tipekulit." tipe<br>";
                              }
                            }
                          }
                          // Data berdasarkan jenis kelamin yang sama seperti user
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                              }
                            }
                          }
                          // Data berdasarkan kemudahan pencarian
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                              }
                            }
                          }
                          // Data berdasarkan komposisi berbahaya
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                              }
                            }
                          }
                          $terbobotbenefit = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                        // END S+i
                        }
                      }
                    ?>
                  </div>
                  <div class="perhitungan-hidden-dua">
                    <?php
                      // START S+i
                        $terbobotbenefit_tipekulit = 0;
                        $terbobotbenefit_jeniskelamin = 0;
                        $terbobotbenefit_kemudahanpencarian = 0;
                        $terbobotbenefit_komposisiberbahaya = 0;
                        $terbobotbenefit = 0;
                      // END S+i
                      // START Bobot Relatif
                        $bobotrelatif_lima_tipekulit = 0;
                        $bobotrelatif_lima_jeniskelamin = 0;
                        $bobotrelatif_lima_kemudahanpencarian = 0;
                        $bobotrelatif_lima_komposisiberbahaya = 0;
                        $bobotrelatif_lima = 0;
                      // END Bobot Relatif
                      // START QMAX
                        $terbobotcost_tipekulit = 0;
                        $terbobotcost_jeniskelamin = 0;
                        $terbobotcost_kemudahanpencarian = 0;
                        $terbobotcost_komposisiberbahaya = 0;
                        $qmax = 0;
                        $array_qmax = array();
                      // END QMAX
                      // START Ranking Copras
                        $rankingcopras = 0;
                        $array_rankingcopras = array();
                      // END Ranking Copras

                      foreach($produks as $produk) {
                        if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                          // START S+i
                            // Data berdasarkan tipe kulit yang sama seperti user
                            foreach($bytipekulits as $bytipekulit) {
                              if($bytipekulit->id_produk == $produk->id_produk) {
                                $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Benefit') {
                                  $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                  // echo $terbobotbenefit_tipekulit." tipe<br>";
                                }
                              }
                            }
                            // Data berdasarkan jenis kelamin yang sama seperti user
                            foreach($byjeniskelamins as $byjeniskelamin) {
                              if($byjeniskelamin->id_produk == $produk->id_produk) {
                                $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Benefit') {
                                  $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                  // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                                }
                              }
                            }
                            // Data berdasarkan kemudahan pencarian
                            foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                              if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Benefit') {
                                  $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                  // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                                }
                              }
                            }
                            // Data berdasarkan komposisi berbahaya
                            foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                              if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Benefit') {
                                  $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                  // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                                }
                              }
                            }
                            $terbobotbenefit = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                          // END S+i

                          // START Bobot Relatif
                            foreach($bytipekulits as $bytipekulit) {
                              if($bytipekulit->id_produk == $produk->id_produk) {
                                $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $bobotrelatif_lima_tipekulit = $terbobotbenefit_tipekulit+(array_sum($array_sigma_smini_hidden)/((($bytipekulit->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                }
                              }
                            }
                            foreach($byjeniskelamins as $byjeniskelamin) {
                              if($byjeniskelamin->id_produk == $produk->id_produk) {
                                $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $bobotrelatif_lima_jeniskelamin = $terbobotbenefit_jeniskelamin+(array_sum($array_sigma_smini_hidden)/((($byjeniskelamin->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                }
                              }
                            }
                            foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                              if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $bobotrelatif_lima_kemudahanpencarian = $terbobotbenefit_kemudahanpencarian+(array_sum($array_sigma_smini_hidden)/((($bykemudahanpencarian->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                }
                              }
                            }
                            foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                              if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $bobotrelatif_lima_komposisiberbahaya = $terbobotbenefit_komposisiberbahaya+(array_sum($array_sigma_smini_hidden)/((($bykomposisiberbahaya->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                }
                              }
                            }
                          // END Bobot Relatif

                          // Start QMAX
                            // Data berdasarkan tipe kulit yang sama seperti user
                            foreach($bytipekulits as $bytipekulit) {
                              if($bytipekulit->id_produk == $produk->id_produk) {
                                $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $terbobotcost_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                  // echo $terbobotcost_tipekulit." tipe<br>";
                                }
                              }
                            }
                            // Data berdasarkan jenis kelamin yang sama seperti user
                            foreach($byjeniskelamins as $byjeniskelamin) {
                              if($byjeniskelamin->id_produk == $produk->id_produk) {
                                $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $terbobotcost_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                  // echo $terbobotcost_jeniskelamin." jenis<br>";
                                }
                              }
                            }
                            // Data berdasarkan kemudahan pencarian
                            foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                              if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $terbobotcost_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                  // echo $terbobotcost_kemudahanpencarian." kemudahan<br>";
                                }
                              }
                            }
                            // Data berdasarkan komposisi berbahaya
                            foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                              if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                if($tipekriteria == 'Cost') {
                                  $terbobotcost_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                  // echo $terbobotcost_komposisiberbahaya." komposisi<br>";
                                }
                              }
                            }
                            $qmax = $terbobotbenefit+(array_sum($array_sigma_smini_hidden)/(($terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya)*array_sum($array_sigma_satupersmini_hidden)));
                            $array_qmax[] = $qmax;
                            $get_qmax = max($array_qmax);
                          // END QMAX
                        }
                      }
                    ?>
                  </div>
                  <div class="perhitungan-hidden-tiga">
                    <?php  
                      $terbobotbenefit_copras = 0;
                      $bobotrelatif_lima_copras = 0;
                      $sumrank_copras = 0;
                      $rank_copras = array();
                    
                      foreach($produks as $produk) {
                        if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                        // START S+i
                          $terbobotbenefit_tipekulit = 0;
                          $terbobotbenefit_jeniskelamin = 0;
                          $terbobotbenefit_kemudahanpencarian = 0;
                          $terbobotbenefit_komposisiberbahaya = 0;
                          // Data berdasarkan tipe kulit yang sama seperti user
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Data berdasarkan jenis kelamin yang sama seperti user
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Data berdasarkan kemudahan pencarian
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                          // Data berdasarkan komposisi berbahaya
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                              }
                            }
                          }
                        // END S+i

                        // START Rank
                          $bobotrelatif_lima_tipekulit = 0;
                          $bobotrelatif_lima_jeniskelamin = 0;
                          $bobotrelatif_lima_kemudahanpencarian = 0;
                          $bobotrelatif_lima_komposisiberbahaya = 0;
                          $bobotrelatif_lima = 0;
                          // Data berdasarkan tipe kulit yang sama seperti user
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $bobotrelatif_lima_tipekulit = $terbobotbenefit_tipekulit+(array_sum($array_sigma_smini_hidden)/((($bytipekulit->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                              }
                            }
                          }
                          // Data berdasarkan jenis kelamin yang sama seperti user
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $bobotrelatif_lima_jeniskelamin = $terbobotbenefit_jeniskelamin+(array_sum($array_sigma_smini_hidden)/((($byjeniskelamin->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                              }
                            }
                          }
                          // Data berdasarkan kemudahan pencarian
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $bobotrelatif_lima_kemudahanpencarian = $terbobotbenefit_kemudahanpencarian+(array_sum($array_sigma_smini_hidden)/((($bykemudahanpencarian->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                              }
                            }
                          }
                          // Data berdasarkan komposisi berbahaya
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $bobotrelatif_lima_komposisiberbahaya = $terbobotbenefit_komposisiberbahaya+(array_sum($array_sigma_smini_hidden)/((($bykomposisiberbahaya->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                              }
                            }
                          }
                          $terbobotbenefit_copras = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                          $bobotrelatif_lima_copras = $bobotrelatif_lima_tipekulit+$bobotrelatif_lima_jeniskelamin+$bobotrelatif_lima_kemudahanpencarian+$bobotrelatif_lima_komposisiberbahaya;
                          $sumrank_copras = (($terbobotbenefit_copras+$bobotrelatif_lima_copras)/$get_qmax)*100;
                          $rank_copras[] = [$sumrank_copras, $produk->id_produk];
                        // END Rank
                        }
                      }
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="smom">
                    <?php
                      $no = 1;

                      array_multisort(
                        array_map(
                          static function ($element) {
                            return $element['0'];
                          },
                          $rank_copras
                        ),
                        SORT_DESC,
                        $rank_copras
                      );
                            
                      // var_dump($rank_copras);
                      $rank_copras_idproduk = array_column($rank_copras, '1');
                      // print_r($rank_copras_idproduk);
                      
                      for($i=0;$i<count($rank_copras);$i++) {
                        foreach($produks as $produk) {
                          if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                            if($produk->id_produk == $rank_copras_idproduk[$i]) {
                    ?>
                    <div class="strolls">
                      <div class="card" style="width:200px;height:355px">
                        <div class="card-body">
                          <div class="new-arrival-product">
                            <p class="text-primary"><b>Rangking <?php echo $no++; ?></b></p>
                            <div class="new-arrivals-img-contnent">
                            @if($produk->gambar)
                              <img src="{{ asset('storage/'.$produk->gambar) }}" alt="Gambar Produk" style="width:100%;">
                            @else
                              <span class="badge badge-xs light badge-danger text-center">Belum ada foto produk.</span>
                            @endif
                            </div>
                            <div class="new-arrival-content text-center mt-3">
                              <p style="white-space:pre-line;line-height: normal;"><b><span class="text-primary">{{ $produk->merk }}</span></b><br><?php if(strlen($produk->nama) > 40) { echo substr($produk->nama, 0, 40).".."; } else { echo $produk->nama; }; ?></p>
                              <p style="white-space:pre-line;line-height: normal;"><b><span class="text-danger">Rp <?php echo number_format($produk->harga); ?></span></b></p>
                            </div>
                          </div>
                        </div>
                        <a href="{{ url('produk/'.$produk->id_produk.'/show') }}" class="btn-primary" style="margin:20px;color:#fff;border-radius:10px;padding:5px;font-size:10px;">Lihat Produk</a>
                      </div>
                    </div>
                    <?php
                            }
                          }
                        }
                      }
                    ?>
                  </div>
                </div>
              <?php
                } else {
                  echo "<p>Tidak ada produk untuk ditampilkan.</p>";
                }
              ?>
            </div>
            @endforeach
          </div>
          <?php } else { ?>
          <div class="col-sm">
            <div class="row justify-content-md-center">
            <div class="col-sm-4" style="margin-top:50px;text-align:center;">
              <p style="color:#fc2e53;font-weight:900;font-size:25px;padding:5px;background-color:#ffedf0;border-radius:25px;">Tunggu sebentar!</p>
              <p style="color:#fff;font-weight:500;font-size:17px;line-height:normal;">Duh, maaf ya. Sepertinya kamu harus mengisi halaman profile terlebih dahulu.</p>
              <br>
              <a href="{{ url('profile') }}" class="col-sm btn btn-primary btn-block"><b>Yuk, isi profile kamu di sini!</b></a>
            </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Proses Perhitungan Metode COPRAS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="profile-tab">
          <?php if(isset($data->jeniskelamin) && isset($data->tipekulit) && isset($data->usia)) { ?>
            <div class="custom-tab-1">
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#tahapsatucopras" data-bs-toggle="tab" class="nav-link active show">Tahap 1</a></li>
                <li class="nav-item"><a href="#tahapduacopras" data-bs-toggle="tab" class="nav-link">Tahap 2</a></li>
                <li class="nav-item"><a href="#tahaptigacopras" data-bs-toggle="tab" class="nav-link">Tahap 3</a></li>
                <li class="nav-item"><a href="#tahapempatcopras" data-bs-toggle="tab" class="nav-link">Tahap 4</a></li>
                <li class="nav-item"><a href="#tahaplimacopras" data-bs-toggle="tab" class="nav-link">Tahap 5</a></li>
                <li class="nav-item"><a href="#tahapenamcopras" data-bs-toggle="tab" class="nav-link">Tahap 6</a></li>
              </ul> 
              <div class="tab-content">
                <div id="tahapsatucopras" class="tab-pane fade active show">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Data Awal</b></h3>
                  </div>
                  <div class="">
                    @foreach($kategoriproduks as $kategoriproduk)
                    <hr class="bg-dark border-1 border-top border-dark">
                    <div class="row mt-3 mb-5">
                      <div class="row" style="text-align:center;">
                        <h4 class="text-primary"><b>{{ $kategoriproduk->nama }}</b></h4>
                      </div>
                      <?php
                        $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                        if($countproductbykategori > 0) {
                      ?>
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Merk</th>
                                <th>Produk</th>
                                <th>C1</th>
                                <th>C2</th>
                                <th>C3</th>
                                <th>C4</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1; ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php echo number_format($bytipekulit->nilai, 3, ',', ''); ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php echo number_format($byjeniskelamin->nilai, 3, ',', ''); ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php echo number_format($bykemudahanpencarian->nilai, 3, ',', ''); ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php echo number_format($bykomposisiberbahaya->nilai, 3, ',', ''); ?>
                                  @endif
                                  @endforeach
                                </td>
                              </tr>
                              @endif
                              @endforeach
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b><?php echo number_format($bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai'), 3, ',', ''); ?><b></td>
                                <td><b><?php echo number_format($byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai'), 3, ',', ''); ?><b></td>
                                <td><b><?php echo number_format($bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai'), 3, ',', ''); ?><b></td>
                                <td><b><?php echo number_format($bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai'), 3, ',', ''); ?><b></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php
                        } else {
                          echo "<p style='text-align:center;'>Tidak ada produk untuk ditampilkan.</p>";
                        }
                      ?>
                    </div>
                    @endforeach
                  </div>
                </div>
                <div id="tahapduacopras" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Normalisasi Matriks</b></h3>
                  </div>
                  <div class="">
                    @foreach($kategoriproduks as $kategoriproduk)
                    <hr class="bg-dark border-1 border-top border-dark">
                    <div class="row mt-3 mb-5">
                      <div class="row" style="text-align:center;">
                        <h4 class="text-primary"><b>{{ $kategoriproduk->nama }}</b></h4>
                      </div>
                      <?php
                        $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                        if($countproductbykategori > 0) {
                      ?>
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Merk</th>
                                <th>Produk</th>
                                <th>C1</th>
                                <th>C2</th>
                                <th>C3</th>
                                <th>C4</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1; ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      echo number_format(($bytipekulit->nilai/$pembagi), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      echo number_format(($byjeniskelamin->nilai/$pembagi), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      echo number_format(($bykemudahanpencarian->nilai/$pembagi), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      echo number_format(($bykomposisiberbahaya->nilai/$pembagi), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                              </tr>
                              @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php
                        } else {
                          echo "<p style='text-align:center;'>Tidak ada produk untuk ditampilkan.</p>";
                        }
                      ?>
                    </div>
                    @endforeach
                  </div>
                </div>
                <div id="tahaptigacopras" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Normalisasi Matriks Terbobot</b></h3>
                  </div>
                  <div class="">
                    @foreach($kategoriproduks as $kategoriproduk)
                    <hr class="bg-dark border-1 border-top border-dark">
                    <div class="row mt-3 mb-5">
                      <div class="row" style="text-align:center;">
                        <h4 class="text-primary"><b>{{ $kategoriproduk->nama }}</b></h4>
                      </div>
                      <?php
                        $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                        if($countproductbykategori > 0) {
                      ?>
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Merk</th>
                                <th>Produk</th>
                                <th>C1</th>
                                <th>C2</th>
                                <th>C3</th>
                                <th>C4</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1; ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      echo number_format((($bytipekulit->nilai/$pembagi)*$bobot), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      echo number_format((($byjeniskelamin->nilai/$pembagi)*$bobot), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      echo number_format((($bykemudahanpencarian->nilai/$pembagi)*$bobot), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      echo number_format((($bykomposisiberbahaya->nilai/$pembagi)*$bobot), 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                              </tr>
                              @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php
                        } else {
                          echo "<p style='text-align:center;'>Tidak ada produk untuk ditampilkan.</p>";
                        }
                      ?>
                    </div>
                    @endforeach
                  </div>
                </div>
                <div id="tahapempatcopras" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Maksimal dan Minimal Indeks</b></h3>
                  </div>
                  <div class="">
                    @foreach($kategoriproduks as $kategoriproduk)
                    <hr class="bg-dark border-1 border-top border-dark">
                    <div class="row mt-3 mb-5">
                      <div class="row" style="text-align:center;">
                        <h4 class="text-primary"><b>{{ $kategoriproduk->nama }}</b></h4>
                      </div>
                      <?php
                        $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                        if($countproductbykategori > 0) {
                      ?>
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Merk</th>
                                <th>Produk</th>
                                <th>S+i</th>
                                <th>S-i</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1;
                                $sumsmini = array();
                              ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  <?php
                                    $terbobotbenefit_tipekulit = 0;
                                    $terbobotbenefit_jeniskelamin = 0;
                                    $terbobotbenefit_kemudahanpencarian = 0;
                                    $terbobotbenefit_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    echo number_format(($terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya), 3, ',', '');
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $terbobotcost_tipekulit = 0;
                                    $terbobotcost_jeniskelamin = 0;
                                    $terbobotcost_kemudahanpencarian = 0;
                                    $terbobotcost_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    // echo number_format(($terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya), 3, '.', '');
                                    $terbobotcost = $terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya;
                                    echo number_format($terbobotcost, 3, ',', '');
                                    $sumsmini[] = $terbobotcost;
                                  ?>
                                </td>
                              </tr>
                              @endif
                              @endforeach
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b><?php echo number_format((array_sum($sumsmini)), 3, ',', ''); ?></b></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php
                        } else {
                          echo "<p style='text-align:center;'>Tidak ada produk untuk ditampilkan.</p>";
                        }
                      ?>
                    </div>
                    @endforeach
                  </div>
                </div>
                <div id="tahaplimacopras" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Hitung Bobot Relatif</b></h3>
                  </div>
                  <div class="">
                    @foreach($kategoriproduks as $kategoriproduk)
                    <hr class="bg-dark border-1 border-top border-dark">
                    <div class="row mt-3 mb-5">
                      <div class="row" style="text-align:center;">
                        <h4 class="text-primary"><b>{{ $kategoriproduk->nama }}</b></h4>
                      </div>
                      <?php
                        $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                        if($countproductbykategori > 0) {
                      ?>
                      <div class="perhitungan-hidden">
                        <?php
                          // START Sigma 1/S-i
                            $sigma_satupersmini_hidden = 0;
                            $sigma_satupersmini_tipekulit_hidden = 0;
                            $sigma_satupersmini_jeniskelamin_hidden = 0;
                            $sigma_satupersmini_kemudahanpencarian_hidden = 0;
                            $sigma_satupersmini_komposisiberbahaya_hidden = 0;
                            $array_sigma_satupersmini_hidden = array();
                          // ENS Sigma 1/S-i
                          // START Sigma S-i
                            $sigma_smini_tipekulit_hidden = 0;
                            $sigma_smini_jeniskelamin_hidden = 0;
                            $sigma_smini_kemudahanpencarian_hidden = 0;
                            $sigma_smini_komposisiberbahaya_hidden = 0;
                            $sigma_smini_hidden = 0;
                            $array_sigma_smini_hidden = array();
                          // ENS Sigma S-i

                          foreach($produks as $produk) {
                            if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                            // START Sigma 1/S-i
                              // Data berdasarkan tipe kulit yang sama seperti user
                              foreach($bytipekulits as $bytipekulit) {
                                if($bytipekulit->id_produk == $produk->id_produk) {
                                  $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_satupersmini_tipekulit_hidden = 1/(($bytipekulit->nilai/$pembagi)*$bobot);
                                  }
                                }
                              }
                              // Data berdasarkan jenis kelamin yang sama seperti user
                              foreach($byjeniskelamins as $byjeniskelamin) {
                                if($byjeniskelamin->id_produk == $produk->id_produk) {
                                  $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_satupersmini_jeniskelamin_hidden = 1/(($byjeniskelamin->nilai/$pembagi)*$bobot);
                                  }
                                }
                              }
                              // Data berdasarkan kemudahan pencarian
                              foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                  $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                    $sigma_satupersmini_kemudahanpencarian_hidden = 1/(($bykemudahanpencarian->nilai/$pembagi)*$bobot);
                                  }
                                }
                              }
                              // Data berdasarkan komposisi berbahaya
                              foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                  $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_satupersmini_komposisiberbahaya_hidden = 1/(($bykomposisiberbahaya->nilai/$pembagi)*$bobot);
                                  }
                                }
                              }
                              // Hitung keseluruhan nilai data atau per-row
                              $sigma_satupersmini_hidden = $sigma_satupersmini_tipekulit_hidden+$sigma_satupersmini_jeniskelamin_hidden+$sigma_satupersmini_kemudahanpencarian_hidden+$sigma_satupersmini_komposisiberbahaya_hidden;
                              $array_sigma_satupersmini_hidden[] = $sigma_satupersmini_hidden;
                            // END Sigma 1/S-i

                            // START Sigma S-i
                              // Data berdasarkan tipe kulit yang sama seperti user
                              foreach($bytipekulits as $bytipekulit) {
                                if($bytipekulit->id_produk == $produk->id_produk) {
                                  $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_smini_tipekulit_hidden = ($bytipekulit->nilai/$pembagi)*$bobot;
                                  }
                                }
                              }
                              // Data berdasarkan jenis kelamin yang sama seperti user
                              foreach($byjeniskelamins as $byjeniskelamin) {
                                if($byjeniskelamin->id_produk == $produk->id_produk) {
                                  $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_smini_jeniskelamin_hidden = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                  }
                                }
                              }
                              // Data berdasarkan kemudahan pencarian
                              foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                  $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_smini_kemudahanpencarian_hidden = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                  }
                                }
                              }
                              // Data berdasarkan komposisi berbahaya
                              foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                  $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                  $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                  $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                  if($tipekriteria == 'Cost') {
                                    $sigma_smini_komposisiberbahaya_hidden = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                  }
                                }
                              }
                              // Hitung keseluruhan nilai data atau per-row
                              $sigma_smini_hidden = $sigma_smini_tipekulit_hidden+$sigma_smini_jeniskelamin_hidden+$sigma_smini_kemudahanpencarian_hidden+$sigma_smini_komposisiberbahaya_hidden;
                              $array_sigma_smini_hidden[] = $sigma_smini_hidden;
                            // END Sigma S-i
                            }
                          }
                        ?>
                      </div>
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Merk</th>
                                <th>Produk</th>
                                <th>R1</th>
                                <th>R2</th>
                                <th>R3</th>
                                <th>R4</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1;
                                $sumcost = array();
                              ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  <?php
                                    $satupersmini_tipekulit = 0;
                                    $satupersmini_jeniskelamin = 0;
                                    $satupersmini_kemudahanpencarian = 0;
                                    $satupersmini_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $satupersmini_tipekulit = 1/(($bytipekulit->nilai/$pembagi)*$bobot);
                                        // echo $satupersmini_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $satupersmini_jeniskelamin = 1/(($byjeniskelamin->nilai/$pembagi)*$bobot);
                                        // echo $satupersmini_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $satupersmini_kemudahanpencarian = 1/(($bykemudahanpencarian->nilai/$pembagi)*$bobot);
                                        // echo $satupersmini_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $satupersmini_komposisiberbahaya = 1/(($bykomposisiberbahaya->nilai/$pembagi)*$bobot);
                                        // echo $satupersmini_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $satupersmini = $satupersmini_tipekulit+$satupersmini_jeniskelamin+$satupersmini_kemudahanpencarian+$satupersmini_komposisiberbahaya;
                                    echo number_format($satupersmini, 3, ',', '');
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $terbobotcost_tipekulit = 0;
                                    $terbobotcost_jeniskelamin = 0;
                                    $terbobotcost_kemudahanpencarian = 0;
                                    $terbobotcost_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $terbobotcost = ($terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya)*array_sum($array_sigma_satupersmini_hidden);
                                    echo number_format($terbobotcost, 3, ',', '');
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $terbobotcost_tipekulit = 0;
                                    $terbobotcost_jeniskelamin = 0;
                                    $terbobotcost_kemudahanpencarian = 0;
                                    $terbobotcost_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $terbobotcost = array_sum($array_sigma_smini_hidden)/(($terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya)*array_sum($array_sigma_satupersmini_hidden));
                                    echo number_format($terbobotcost, 3, ',', '');
                                  ?>
                                </td>
                                <td>
                                  <?php
                                  // START S+i
                                    $terbobotbenefit_tipekulit = 0;
                                    $terbobotbenefit_jeniskelamin = 0;
                                    $terbobotbenefit_kemudahanpencarian = 0;
                                    $terbobotbenefit_komposisiberbahaya = 0;
                                    
                                    // Data berdasarkan tipe kulit yang sama seperti user
                                    foreach($bytipekulits as $bytipekulit) {
                                      if($bytipekulit->id_produk == $produk->id_produk) {
                                        $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                        $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                        if($tipekriteria == 'Benefit') {
                                          $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                          // echo $terbobotbenefit_tipekulit." tipe<br>";
                                        }
                                      }
                                    }
                                    // Data berdasarkan jenis kelamin yang sama seperti user
                                    foreach($byjeniskelamins as $byjeniskelamin) {
                                      if($byjeniskelamin->id_produk == $produk->id_produk) {
                                        $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                        $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                        if($tipekriteria == 'Benefit') {
                                          $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                          // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                                        }
                                      }
                                    }
                                    // Data berdasarkan kemudahan pencarian
                                    foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                      if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                        $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                        $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                        if($tipekriteria == 'Benefit') {
                                          $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                          // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                                        }
                                      }
                                    }
                                    // Data berdasarkan komposisi berbahaya
                                    foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                      if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                        $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                        $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                        if($tipekriteria == 'Benefit') {
                                          $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                          // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                                        }
                                      }
                                    }
                                    $terbobotbenefit = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                                  // END S+i

                                    $terbobotcost_tipekulit = 0;
                                    $terbobotcost_jeniskelamin = 0;
                                    $terbobotcost_kemudahanpencarian = 0;
                                    $terbobotcost_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $qmax = $terbobotbenefit+(array_sum($array_sigma_smini_hidden)/(($terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya)*array_sum($array_sigma_satupersmini_hidden)));
                                    echo number_format($qmax, 3, ',', '');
                                    $array_qmax[] = $qmax;
                                  ?>
                                </td>
                              </tr>
                              @endif
                              @endforeach
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b><?php echo number_format((array_sum($array_sigma_satupersmini_hidden)), 3, '.', ''); ?></b></td>
                                <td></td>
                                <td></td>
                                <td><b><?php echo number_format(max($array_qmax), 3, '.', ''); ?></b></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php
                        } else {
                          echo "<p style='text-align:center;'>Tidak ada produk untuk ditampilkan.</p>";
                        }
                      ?>
                    </div>
                    @endforeach
                  </div>
                </div>
                <div id="tahapenamcopras" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Hitung Utilitas Kuantitatif</b></h3>
                  </div>
                  <div class="">
                    @foreach($kategoriproduks as $kategoriproduk)
                    <hr class="bg-dark border-1 border-top border-dark">
                    <div class="row mt-3 mb-5">
                      <div class="row" style="text-align:center;">
                        <h4 class="text-primary"><b>{{ $kategoriproduk->nama }}</b></h4>
                      </div>
                      <?php
                        $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                        if($countproductbykategori > 0) {
                      ?>
                      <div class="perhitungan-hidden">
                        <div class="perhitungan-hidden-satu">
                          <?php
                            // START Sigma 1/S-i
                              $sigma_satupersmini_hidden = 0;
                              $sigma_satupersmini_tipekulit_hidden = 0;
                              $sigma_satupersmini_jeniskelamin_hidden = 0;
                              $sigma_satupersmini_kemudahanpencarian_hidden = 0;
                              $sigma_satupersmini_komposisiberbahaya_hidden = 0;
                              $array_sigma_satupersmini_hidden = array();
                            // ENS Sigma 1/S-i
                            // START Sigma S-i
                              $sigma_smini_tipekulit_hidden = 0;
                              $sigma_smini_jeniskelamin_hidden = 0;
                              $sigma_smini_kemudahanpencarian_hidden = 0;
                              $sigma_smini_komposisiberbahaya_hidden = 0;
                              $sigma_smini_hidden = 0;
                              $array_sigma_smini_hidden = array();
                            // END Sigma S-i
                            // START S+i
                              $terbobotbenefit_tipekulit = 0;
                              $terbobotbenefit_jeniskelamin = 0;
                              $terbobotbenefit_kemudahanpencarian = 0;
                              $terbobotbenefit_komposisiberbahaya = 0;
                              $terbobotbenefit = 0;
                            // END S+i

                            foreach($produks as $produk) {
                              if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                              // START Sigma 1/S-i
                                // Data berdasarkan tipe kulit yang sama seperti user
                                foreach($bytipekulits as $bytipekulit) {
                                  if($bytipekulit->id_produk == $produk->id_produk) {
                                    $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_satupersmini_tipekulit_hidden = 1/(($bytipekulit->nilai/$pembagi)*$bobot);
                                    }
                                  }
                                }
                                // Data berdasarkan jenis kelamin yang sama seperti user
                                foreach($byjeniskelamins as $byjeniskelamin) {
                                  if($byjeniskelamin->id_produk == $produk->id_produk) {
                                    $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_satupersmini_jeniskelamin_hidden = 1/(($byjeniskelamin->nilai/$pembagi)*$bobot);
                                    }
                                  }
                                }
                                // Data berdasarkan kemudahan pencarian
                                foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                  if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                    $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                      $sigma_satupersmini_kemudahanpencarian_hidden = 1/(($bykemudahanpencarian->nilai/$pembagi)*$bobot);
                                    }
                                  }
                                }
                                // Data berdasarkan komposisi berbahaya
                                foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                  if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                    $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_satupersmini_komposisiberbahaya_hidden = 1/(($bykomposisiberbahaya->nilai/$pembagi)*$bobot);
                                    }
                                  }
                                }
                                // Hitung keseluruhan nilai data atau per-row
                                $sigma_satupersmini_hidden = $sigma_satupersmini_tipekulit_hidden+$sigma_satupersmini_jeniskelamin_hidden+$sigma_satupersmini_kemudahanpencarian_hidden+$sigma_satupersmini_komposisiberbahaya_hidden;
                                $array_sigma_satupersmini_hidden[] = $sigma_satupersmini_hidden;
                              // END Sigma 1/S-i

                              // START Sigma S-i
                                // Data berdasarkan tipe kulit yang sama seperti user
                                foreach($bytipekulits as $bytipekulit) {
                                  if($bytipekulit->id_produk == $produk->id_produk) {
                                    $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_smini_tipekulit_hidden = ($bytipekulit->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Data berdasarkan jenis kelamin yang sama seperti user
                                foreach($byjeniskelamins as $byjeniskelamin) {
                                  if($byjeniskelamin->id_produk == $produk->id_produk) {
                                    $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_smini_jeniskelamin_hidden = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Data berdasarkan kemudahan pencarian
                                foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                  if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                    $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_smini_kemudahanpencarian_hidden = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Data berdasarkan komposisi berbahaya
                                foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                  if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                    $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $sigma_smini_komposisiberbahaya_hidden = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Hitung keseluruhan nilai data atau per-row
                                $sigma_smini_hidden = $sigma_smini_tipekulit_hidden+$sigma_smini_jeniskelamin_hidden+$sigma_smini_kemudahanpencarian_hidden+$sigma_smini_komposisiberbahaya_hidden;
                                $array_sigma_smini_hidden[] = $sigma_smini_hidden;
                              // END Sigma S-i

                              // START S+i
                                // Data berdasarkan tipe kulit yang sama seperti user
                                foreach($bytipekulits as $bytipekulit) {
                                  if($bytipekulit->id_produk == $produk->id_produk) {
                                    $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                      // echo $terbobotbenefit_tipekulit." tipe<br>";
                                    }
                                  }
                                }
                                // Data berdasarkan jenis kelamin yang sama seperti user
                                foreach($byjeniskelamins as $byjeniskelamin) {
                                  if($byjeniskelamin->id_produk == $produk->id_produk) {
                                    $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                      // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                                    }
                                  }
                                }
                                // Data berdasarkan kemudahan pencarian
                                foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                  if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                    $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                      // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                                    }
                                  }
                                }
                                // Data berdasarkan komposisi berbahaya
                                foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                  if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                    $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                      // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                                    }
                                  }
                                }
                                $terbobotbenefit = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                              // END S+i
                              }
                            }
                          ?>
                        </div>
                        <div class="perhitungan-hidden-dua">
                          <?php
                            // START S+i
                              $terbobotbenefit_tipekulit = 0;
                              $terbobotbenefit_jeniskelamin = 0;
                              $terbobotbenefit_kemudahanpencarian = 0;
                              $terbobotbenefit_komposisiberbahaya = 0;
                              $terbobotbenefit = 0;
                            // END S+i
                            // START Bobot Relatif
                              $bobotrelatif_lima_tipekulit = 0;
                              $bobotrelatif_lima_jeniskelamin = 0;
                              $bobotrelatif_lima_kemudahanpencarian = 0;
                              $bobotrelatif_lima_komposisiberbahaya = 0;
                              $bobotrelatif_lima = 0;
                            // END Bobot Relatif
                            // START QMAX
                              $terbobotcost_tipekulit = 0;
                              $terbobotcost_jeniskelamin = 0;
                              $terbobotcost_kemudahanpencarian = 0;
                              $terbobotcost_komposisiberbahaya = 0;
                              $qmax = 0;
                              $array_qmax = array();
                            // END QMAX
                            // START Ranking Copras
                              $rankingcopras = 0;
                              $array_rankingcopras = array();
                            // END Ranking Copras

                            foreach($produks as $produk) {
                              if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                                // START S+i
                                  // Data berdasarkan tipe kulit yang sama seperti user
                                  foreach($bytipekulits as $bytipekulit) {
                                    if($bytipekulit->id_produk == $produk->id_produk) {
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_tipekulit." tipe<br>";
                                      }
                                    }
                                  }
                                  // Data berdasarkan jenis kelamin yang sama seperti user
                                  foreach($byjeniskelamins as $byjeniskelamin) {
                                    if($byjeniskelamin->id_produk == $produk->id_produk) {
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                                      }
                                    }
                                  }
                                  // Data berdasarkan kemudahan pencarian
                                  foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                    if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                                      }
                                    }
                                  }
                                  // Data berdasarkan komposisi berbahaya
                                  foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                    if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                                      }
                                    }
                                  }
                                  $terbobotbenefit = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                                // END S+i

                                // START Bobot Relatif
                                  foreach($bytipekulits as $bytipekulit) {
                                    if($bytipekulit->id_produk == $produk->id_produk) {
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_tipekulit = $terbobotbenefit_tipekulit+(array_sum($array_sigma_smini_hidden)/((($bytipekulit->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    }
                                  }
                                  foreach($byjeniskelamins as $byjeniskelamin) {
                                    if($byjeniskelamin->id_produk == $produk->id_produk) {
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_jeniskelamin = $terbobotbenefit_jeniskelamin+(array_sum($array_sigma_smini_hidden)/((($byjeniskelamin->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    }
                                  }
                                  foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                    if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_kemudahanpencarian = $terbobotbenefit_kemudahanpencarian+(array_sum($array_sigma_smini_hidden)/((($bykemudahanpencarian->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    }
                                  }
                                  foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                    if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_komposisiberbahaya = $terbobotbenefit_komposisiberbahaya+(array_sum($array_sigma_smini_hidden)/((($bykomposisiberbahaya->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    }
                                  }
                                // END Bobot Relatif

                                // Start QMAX
                                  // Data berdasarkan tipe kulit yang sama seperti user
                                  foreach($bytipekulits as $bytipekulit) {
                                    if($bytipekulit->id_produk == $produk->id_produk) {
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_tipekulit." tipe<br>";
                                      }
                                    }
                                  }
                                  // Data berdasarkan jenis kelamin yang sama seperti user
                                  foreach($byjeniskelamins as $byjeniskelamin) {
                                    if($byjeniskelamin->id_produk == $produk->id_produk) {
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_jeniskelamin." jenis<br>";
                                      }
                                    }
                                  }
                                  // Data berdasarkan kemudahan pencarian
                                  foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                    if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_kemudahanpencarian." kemudahan<br>";
                                      }
                                    }
                                  }
                                  // Data berdasarkan komposisi berbahaya
                                  foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                    if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $terbobotcost_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotcost_komposisiberbahaya." komposisi<br>";
                                      }
                                    }
                                  }
                                  $qmax = $terbobotbenefit+(array_sum($array_sigma_smini_hidden)/(($terbobotcost_tipekulit+$terbobotcost_jeniskelamin+$terbobotcost_kemudahanpencarian+$terbobotcost_komposisiberbahaya)*array_sum($array_sigma_satupersmini_hidden)));
                                  $array_qmax[] = $qmax;
                                  $get_qmax = max($array_qmax);
                                // END QMAX
                              }
                            }
                          ?>
                        </div>
                        <div class="perhitungan-hidden-tiga">
                          <?php  
                            $terbobotbenefit_copras = 0;
                            $bobotrelatif_lima_copras = 0;
                            $sumrank_copras = 0;
                            $rank_copras = array();
                          
                            foreach($produks as $produk) {
                              if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                              // START S+i
                                $terbobotbenefit_tipekulit = 0;
                                $terbobotbenefit_jeniskelamin = 0;
                                $terbobotbenefit_kemudahanpencarian = 0;
                                $terbobotbenefit_komposisiberbahaya = 0;
                                // Data berdasarkan tipe kulit yang sama seperti user
                                foreach($bytipekulits as $bytipekulit) {
                                  if($bytipekulit->id_produk == $produk->id_produk) {
                                    $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Data berdasarkan jenis kelamin yang sama seperti user
                                foreach($byjeniskelamins as $byjeniskelamin) {
                                  if($byjeniskelamin->id_produk == $produk->id_produk) {
                                    $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Data berdasarkan kemudahan pencarian
                                foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                  if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                    $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                                // Data berdasarkan komposisi berbahaya
                                foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                  if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                    $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Benefit') {
                                      $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                    }
                                  }
                                }
                              // END S+i

                              // START Rank
                                $bobotrelatif_lima_tipekulit = 0;
                                $bobotrelatif_lima_jeniskelamin = 0;
                                $bobotrelatif_lima_kemudahanpencarian = 0;
                                $bobotrelatif_lima_komposisiberbahaya = 0;
                                $bobotrelatif_lima = 0;
                                // Data berdasarkan tipe kulit yang sama seperti user
                                foreach($bytipekulits as $bytipekulit) {
                                  if($bytipekulit->id_produk == $produk->id_produk) {
                                    $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $bobotrelatif_lima_tipekulit = $terbobotbenefit_tipekulit+(array_sum($array_sigma_smini_hidden)/((($bytipekulit->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                    }
                                  }
                                }
                                // Data berdasarkan jenis kelamin yang sama seperti user
                                foreach($byjeniskelamins as $byjeniskelamin) {
                                  if($byjeniskelamin->id_produk == $produk->id_produk) {
                                    $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $bobotrelatif_lima_jeniskelamin = $terbobotbenefit_jeniskelamin+(array_sum($array_sigma_smini_hidden)/((($byjeniskelamin->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                    }
                                  }
                                }
                                // Data berdasarkan kemudahan pencarian
                                foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                                  if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                                    $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $bobotrelatif_lima_kemudahanpencarian = $terbobotbenefit_kemudahanpencarian+(array_sum($array_sigma_smini_hidden)/((($bykemudahanpencarian->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                    }
                                  }
                                }
                                // Data berdasarkan komposisi berbahaya
                                foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                                  if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                                    $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                    $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                    $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                    if($tipekriteria == 'Cost') {
                                      $bobotrelatif_lima_komposisiberbahaya = $terbobotbenefit_komposisiberbahaya+(array_sum($array_sigma_smini_hidden)/((($bykomposisiberbahaya->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                    }
                                  }
                                }
                                $terbobotbenefit_copras = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                                $bobotrelatif_lima_copras = $bobotrelatif_lima_tipekulit+$bobotrelatif_lima_jeniskelamin+$bobotrelatif_lima_kemudahanpencarian+$bobotrelatif_lima_komposisiberbahaya;
                                $sumrank_copras = (($terbobotbenefit_copras+$bobotrelatif_lima_copras)/$get_qmax)*100;
                                $rank_copras[] = $sumrank_copras;
                              // END Rank
                              }
                            }
                          ?>
                        </div>
                      </div>
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Merk</th>
                                <th>Produk</th>
                                <th>UI</th>
                                <th>Rank</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1;
                                $sumcost = array();
                              ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  <?php
                                    $terbobotbenefit_tipekulit = 0;
                                    $terbobotbenefit_jeniskelamin = 0;
                                    $terbobotbenefit_kemudahanpencarian = 0;
                                    $terbobotbenefit_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_tipekulit = ($bytipekulit->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_tipekulit." tipe<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_jeniskelamin = ($byjeniskelamin->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_jeniskelamin." jenis<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_kemudahanpencarian = ($bykemudahanpencarian->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_kemudahanpencarian." kemudahan<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $terbobotbenefit_komposisiberbahaya = ($bykomposisiberbahaya->nilai/$pembagi)*$bobot;
                                        // echo $terbobotbenefit_komposisiberbahaya." komposisi<br>";
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $bobotrelatif_lima_tipekulit = 0;
                                    $bobotrelatif_lima_jeniskelamin = 0;
                                    $bobotrelatif_lima_kemudahanpencarian = 0;
                                    $bobotrelatif_lima_komposisiberbahaya = 0;
                                    $bobotrelatif_lima = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php
                                      $pembagi = $bytipekulits->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_tipekulit = $terbobotbenefit_tipekulit+(array_sum($array_sigma_smini_hidden)/((($bytipekulit->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_jeniskelamin = $terbobotbenefit_jeniskelamin+(array_sum($array_sigma_smini_hidden)/((($byjeniskelamin->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_kemudahanpencarian = $terbobotbenefit_kemudahanpencarian+(array_sum($array_sigma_smini_hidden)/((($bykemudahanpencarian->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php 
                                      $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $bobotrelatif_lima_komposisiberbahaya = $terbobotbenefit_komposisiberbahaya+(array_sum($array_sigma_smini_hidden)/((($bykomposisiberbahaya->nilai/$pembagi)*$bobot)*array_sum($array_sigma_satupersmini_hidden)));
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $terbobotbenefit_hidden = $terbobotbenefit_tipekulit+$terbobotbenefit_jeniskelamin+$terbobotbenefit_kemudahanpencarian+$terbobotbenefit_komposisiberbahaya;
                                    $bobotrelatif_lima = $bobotrelatif_lima_tipekulit+$bobotrelatif_lima_jeniskelamin+$bobotrelatif_lima_kemudahanpencarian+$bobotrelatif_lima_komposisiberbahaya;
                                    $rankingcopras = (($terbobotbenefit_hidden+$bobotrelatif_lima)/$get_qmax)*100;
                                    echo number_format($rankingcopras, 3, '.', '');
                                    $array_rankingcopras[] = $rankingcopras;
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    rsort($rank_copras);
                                    $countrank = count($array_rankingcopras);
                                    if(($no-1) == $countrank) {
                                      echo 'Ranking Nomor '.(array_search($rankingcopras, $rank_copras)+1);
                                    }
                                  ?>
                                </td>
                              </tr>
                              @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php
                        } else {
                          echo "<p style='text-align:center;'>Tidak ada produk untuk ditampilkan.</p>";
                        }
                      ?>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          <?php } else { ?>
            <p style="color:#fc2e53;font-weight:900;font-size:25px;">Tunggu sebentar!</p>
            <p style="font-weight:500;font-size:17px;line-height:normal;">Duh, maaf ya. Sepertinya kamu harus mengisi halaman profile terlebih dahulu.</p>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection