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
						<li><a href="{{ url('copras') }}">Metode COPRAS</a></li>
						<li><a href="{{ url('moora') }}">Metode MOORA</a></li>
						<li class="active"><a href="{{ url('perbandingan') }}"><b>Perbandingan COPRAS & MOORA</b></a></li>
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
      <h1 class="text-primary" style="text-align:center;"><b>Perbandingan Metode COPRAS dan Metode MOORA</b></h1>
      <div class="row">
        <div class="col-sm-2" style="margin:10vh 0px 7vh 0;">
          <form method="POST" action="{{ url('perbandingan') }}" enctype="multipart/form-data">
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
            <div class="mt-5" style="margin:100px 0px 75px 0;text-align:center;">
              <h1 style="color:#fff;text-align:center"><b>{{ $kategoriproduk->nama }}</b></h1>
              <div class="row mt-2 mb-5">
                <h2 class="mt-2 mb-2 text-primary"><b>Metode COPRAS</b></h2>
                <?php
                  $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                  if($countproductbykategori > 0) {
                ?>
                <div class="perhitungan-copras-hidden" style="display:none;">
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
              <div class="row mt-5 mb-5">
                <h2 class="mt-2 mb-2 text-primary"><b>Metode MOORA</b></h2>
                <?php
                  $countproductbykategori = $produks->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->count();
                  if($countproductbykategori > 0) {
                ?>
                <div class="perhitungan-moora-hidden" style="display:none;">
                  <div class="perhitungan-hidden-satu" style="display:none;">
                    <?php
                      $pangkatdua_tipekulit = 0;
                      $pangkatdua_jeniskelamin = 0;
                      $pangkatdua_kemudahanpencarian = 0;
                      $pangkatdua_komposisiberbahaya = 0;
                      $array_pangkatdua_tipekulit = array();
                      $array_pangkatdua_jeniskelamin = array();
                      $array_pangkatdua_kemudahanpencarian = array();
                      $array_pangkatdua_komposisiberbahaya = array();
                                  
                      foreach($produks as $produk) {
                        if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $pangkatdua_tipekulit = pow($bytipekulit->nilai, 2);
                              $array_pangkatdua_tipekulit[] = $pangkatdua_tipekulit;
                            }
                          }
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $pangkatdua_jeniskelamin = pow($byjeniskelamin->nilai, 2);
                              $array_pangkatdua_jeniskelamin[] = $pangkatdua_jeniskelamin;
                            }
                          }
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $pangkatdua_kemudahanpencarian = pow($bykemudahanpencarian->nilai, 2);
                              $array_pangkatdua_kemudahanpencarian[] = $pangkatdua_kemudahanpencarian;
                            }
                          }
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $pangkatdua_komposisiberbahaya = pow($bykomposisiberbahaya->nilai, 2);
                              $array_pangkatdua_komposisiberbahaya[] = $pangkatdua_komposisiberbahaya;
                            }
                          }
                        }
                      }
                    ?>
                  </div>
                  <div class="perhitungan-hidden-dua" style="display:none;">
                    <?php
                    // START Optimasi Benefit
                      $benefit_normalisasi_tipekulit = 0;
                      $benefit_normalisasi_jeniskelamin = 0;
                      $benefit_normalisasi_kemudahanpencarian = 0;
                      $benefit_normalisasi_komposisiberbahaya = 0;
                    // END Normalisasi Benefit
                    // START Optimasi Benefit
                      $benefit_optimasi_tipekulit = 0;
                      $benefit_optimasi_jeniskelamin = 0;
                      $benefit_optimasi_kemudahanpencarian = 0;
                      $benefit_optimasi_komposisiberbahaya = 0;
                    // END Optimasi Benefit
                    // START Normalisasi Cost
                      $cost_normalisasi_tipekulit = 0;
                      $cost_normalisasi_jeniskelamin = 0;
                      $cost_normalisasi_kemudahanpencarian = 0;
                      $cost_normalisasi_komposisiberbahaya = 0;
                    // END Normalisasi Cost
                    // START Optimasi Cost
                      $cost_optimasi_tipekulit = 0;
                      $cost_optimasi_jeniskelamin = 0;
                      $cost_optimasi_kemudahanpencarian = 0;
                      $cost_optimasi_komposisiberbahaya = 0;
                    // END Optimasi Cost
                    // START Optimasi Cost
                      $sum_benefit_hidden = 0;
                      $sum_cost_hidden = 0;
                      $sum_benefitcost_hidden = 0;
                      $rank_moora = array();
                    // END Optimasi Cost
                                  
                      foreach($produks as $produk) {
                        if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $benefit_normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                $benefit_optimasi_tipekulit = $benefit_normalisasi_tipekulit*$bobot;
                              }
                            }
                          }
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $benefit_normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                $benefit_optimasi_jeniskelamin = $benefit_normalisasi_jeniskelamin*$bobot;
                              }
                            }
                          }
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $benefit_normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                $benefit_optimasi_kemudahanpencarian = $benefit_normalisasi_kemudahanpencarian*$bobot;
                              }
                            }
                          }
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Benefit') {
                                $benefit_normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                $benefit_optimasi_komposisiberbahaya = $benefit_normalisasi_komposisiberbahaya*$bobot;
                              }
                            }
                          }
                          
                          foreach($bytipekulits as $bytipekulit) {
                            if($bytipekulit->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $cost_normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                $cost_optimasi_tipekulit = $cost_normalisasi_tipekulit*$bobot;
                              }
                            }
                          }
                          foreach($byjeniskelamins as $byjeniskelamin) {
                            if($byjeniskelamin->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $cost_normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                $cost_optimasi_jeniskelamin = $cost_normalisasi_jeniskelamin*$bobot;
                              }
                            }
                          }
                          foreach($bykemudahanpencarians as $bykemudahanpencarian) {
                            if($bykemudahanpencarian->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $cost_normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                $cost_optimasi_kemudahanpencarian = $cost_normalisasi_kemudahanpencarian*$bobot;
                              }
                            }
                          }
                          foreach($bykomposisiberbahayas as $bykomposisiberbahaya) {
                            if($bykomposisiberbahaya->id_produk == $produk->id_produk) {
                              $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                              $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                              if($tipekriteria == 'Cost') {
                                $cost_normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                $cost_optimasi_komposisiberbahaya = $cost_normalisasi_komposisiberbahaya*$bobot;
                              }
                            }
                          }
                          $sum_benefit_hidden = $benefit_optimasi_tipekulit+$benefit_optimasi_jeniskelamin+$benefit_optimasi_kemudahanpencarian+$benefit_optimasi_komposisiberbahaya;
                          $sum_cost_hidden = $cost_optimasi_tipekulit+$cost_optimasi_jeniskelamin+$cost_optimasi_kemudahanpencarian+$cost_optimasi_komposisiberbahaya;
                          $sum_benefitcost_hidden = $sum_benefit_hidden-$sum_cost_hidden;
                          $rank_moora[] = [$sum_benefitcost_hidden, $produk->id_produk];
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
                          $rank_moora
                        ),
                        SORT_DESC,
                        $rank_moora
                      );
                            
                      // var_dump($rank_moora);
                      $rank_moora_idproduk = array_column($rank_moora, '1');
                      // print_r($rank_moora_idproduk);
                      
                      for($i=0;$i<count($rank_moora);$i++) {
                        foreach($produks as $produk) {
                          if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk) {
                            if($produk->id_produk == $rank_moora_idproduk[$i]) {
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

@endsection