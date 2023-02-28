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
						<li class="active"><a href="{{ url('moora') }}"><b>Metode MOORA</b></a></li>
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
      <h1 class="text-primary" style="text-align:center;"><b>Metode MOORA</b></h1>
      <a href="#" class="btn btn-info col-sm-3" style="color:#fff;margin:auto;" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Lihat Proses Perhitungan</a>
      <div class="row">
        <div class="col-sm-2" style="margin:10vh 0px 7vh 0;">
          <form method="POST" action="{{ url('moora') }}" enctype="multipart/form-data">
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
        <h5 class="modal-title">Proses Perhitungan Metode MOORA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="profile-tab">
          <?php if(isset($data->jeniskelamin) && isset($data->tipekulit) && isset($data->usia)) { ?>
            <div class="custom-tab-1">
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#tahapsatumoora" data-bs-toggle="tab" class="nav-link active show">Tahap 1</a></li>
                <li class="nav-item"><a href="#tahapduamoora" data-bs-toggle="tab" class="nav-link">Tahap 2</a></li>
                <li class="nav-item"><a href="#tahaptigamoora" data-bs-toggle="tab" class="nav-link">Tahap 3</a></li>
                <li class="nav-item"><a href="#tahapempatmoora" data-bs-toggle="tab" class="nav-link">Tahap 4</a></li>
              </ul> 
              <div class="tab-content">
                <div id="tahapsatumoora" class="tab-pane fade active show">
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
                <div id="tahapduamoora" class="tab-pane fade">
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
                      <div class="perhitungan-hidden" style="display:none;">
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
                      <div class="row">
                        <div class="table-responsive" style="height:200px;">
                          <!-- <table id="example2" class="table table-responsive-md display" style="width:100%;text-align:center;"> -->
                          <table class="table table-responsive-md display" style="width:100%;text-align:center;">
                            <thead>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php echo number_format(sqrt(array_sum($array_pangkatdua_tipekulit)), 3, ',', ''); ?></td>
                              </tr>
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
                                      $normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                      echo number_format($normalisasi_tipekulit, 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php
                                      $normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                      echo number_format($normalisasi_jeniskelamin, 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                      echo number_format($normalisasi_kemudahanpencarian, 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php
                                      $normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                      echo number_format($normalisasi_komposisiberbahaya, 3, ',', '');
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
                <div id="tahaptigamoora" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Optimasi Nilai Atribut</b></h3>
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
                      <div class="perhitungan-hidden" style="display:none;">
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
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                      $optimasi_tipekulit = $normalisasi_tipekulit*$bobot;
                                      echo number_format($optimasi_tipekulit, 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                      $optimasi_jeniskelamin = $normalisasi_jeniskelamin*$bobot;
                                      echo number_format($optimasi_jeniskelamin, 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                      $optimasi_kemudahanpencarian = $normalisasi_kemudahanpencarian*$bobot;
                                      echo number_format($optimasi_kemudahanpencarian, 3, ',', '');
                                    ?>
                                  @endif
                                  @endforeach
                                </td>
                                <td>
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                      $optimasi_komposisiberbahaya = $normalisasi_komposisiberbahaya*$bobot;
                                      echo number_format($optimasi_komposisiberbahaya, 3, ',', '');
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
                <div id="tahapempatmoora" class="tab-pane fade">
                  <div class="mt-5 mb-5" style="text-align:center;">
                    <h3 class="text-muted"><b>Menentukan Nilai Yi(Max-Min)</b></h3>
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
                        // START Optimasi Cost
                          $sum_benefit_hidden = 0;
                          $sum_cost_hidden = 0;
                          $sum_benefitcost_hidden = 0;
                          $rank_moora = array();
                          
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
                              $rank_moora[] = $sum_benefitcost_hidden;
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
                                <th>Max</th>
                                <th>Min</th>
                                <th>Max-Min</th>
                                <th>Rank</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no = 1; 
                                $sum_benefitcost = 0;
                                $array_sum_benefitcost = array();
                              ?>
                              @foreach($produks as $produk)
                              @if($produk->id_kategoriproduk == $kategoriproduk->id_kategoriproduk)
                              <tr>
                                <td><?php echo $no++.'.'; ?></td>
                                <td>{{ $produk->merk }}</td>
                                <td style="text-align:left;">{{ $produk->nama }}</td>
                                <td>
                                  <?php
                                    $benefit_normalisasi_tipekulit = 0;
                                    $benefit_normalisasi_jeniskelamin = 0;
                                    $benefit_normalisasi_kemudahanpencarian = 0;
                                    $benefit_normalisasi_komposisiberbahaya = 0;
                                    $benefit_optimasi_tipekulit = 0;
                                    $benefit_optimasi_jeniskelamin = 0;
                                    $benefit_optimasi_kemudahanpencarian = 0;
                                    $benefit_optimasi_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $benefit_normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                        $benefit_optimasi_tipekulit = $benefit_normalisasi_tipekulit*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $benefit_normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                        $benefit_optimasi_jeniskelamin = $benefit_normalisasi_jeniskelamin*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $benefit_normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                        $benefit_optimasi_kemudahanpencarian = $benefit_normalisasi_kemudahanpencarian*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Benefit') {
                                        $benefit_normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                        $benefit_optimasi_komposisiberbahaya = $benefit_normalisasi_komposisiberbahaya*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $sum_benefit = $benefit_optimasi_tipekulit+$benefit_optimasi_jeniskelamin+$benefit_optimasi_kemudahanpencarian+$benefit_optimasi_komposisiberbahaya;
                                    echo number_format($sum_benefit, 3, ',', '');
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $cost_normalisasi_tipekulit = 0;
                                    $cost_normalisasi_jeniskelamin = 0;
                                    $cost_normalisasi_kemudahanpencarian = 0;
                                    $cost_normalisasi_komposisiberbahaya = 0;
                                    $cost_optimasi_tipekulit = 0;
                                    $cost_optimasi_jeniskelamin = 0;
                                    $cost_optimasi_kemudahanpencarian = 0;
                                    $cost_optimasi_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                        $cost_optimasi_tipekulit = $cost_normalisasi_tipekulit*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                        $cost_optimasi_jeniskelamin = $cost_normalisasi_jeniskelamin*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                        $cost_optimasi_kemudahanpencarian = $cost_normalisasi_kemudahanpencarian*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                        $cost_optimasi_komposisiberbahaya = $cost_normalisasi_komposisiberbahaya*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $sum_cost = $cost_optimasi_tipekulit+$cost_optimasi_jeniskelamin+$cost_optimasi_kemudahanpencarian+$cost_optimasi_komposisiberbahaya;
                                    echo number_format($sum_cost, 3, ',', '');
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    $benefit_normalisasi_tipekulit = 0;
                                    $benefit_normalisasi_jeniskelamin = 0;
                                    $benefit_normalisasi_kemudahanpencarian = 0;
                                    $benefit_normalisasi_komposisiberbahaya = 0;
                                    $benefit_optimasi_tipekulit = 0;
                                    $benefit_optimasi_jeniskelamin = 0;
                                    $benefit_optimasi_kemudahanpencarian = 0;
                                    $benefit_optimasi_komposisiberbahaya = 0;
                                    
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
                                  ?>
                                  <?php
                                    $cost_normalisasi_tipekulit = 0;
                                    $cost_normalisasi_jeniskelamin = 0;
                                    $cost_normalisasi_kemudahanpencarian = 0;
                                    $cost_normalisasi_komposisiberbahaya = 0;
                                    $cost_optimasi_tipekulit = 0;
                                    $cost_optimasi_jeniskelamin = 0;
                                    $cost_optimasi_kemudahanpencarian = 0;
                                    $cost_optimasi_komposisiberbahaya = 0;
                                  ?>
                                  @foreach($bytipekulits as $bytipekulit)
                                  @if($bytipekulit->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bytipekulit->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_tipekulit = ($bytipekulit->nilai)/sqrt(array_sum($array_pangkatdua_tipekulit));
                                        $cost_optimasi_tipekulit = $cost_normalisasi_tipekulit*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($byjeniskelamins as $byjeniskelamin)
                                  @if($byjeniskelamin->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $byjeniskelamin->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_jeniskelamin = ($byjeniskelamin->nilai)/sqrt(array_sum($array_pangkatdua_jeniskelamin));
                                        $cost_optimasi_jeniskelamin = $cost_normalisasi_jeniskelamin*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                  @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                    <?php 
                                      $bobot = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykemudahanpencarian->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_kemudahanpencarian = ($bykemudahanpencarian->nilai)/sqrt(array_sum($array_pangkatdua_kemudahanpencarian));
                                        $cost_optimasi_kemudahanpencarian = $cost_normalisasi_kemudahanpencarian*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                  @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                    <?php
                                      $bobot = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->bobot;
                                      $tipekriteria = $kriterias->where('id_kriteria', $bykomposisiberbahaya->id_kriteria)->first()->tipe;
                                      if($tipekriteria == 'Cost') {
                                        $cost_normalisasi_komposisiberbahaya = ($bykomposisiberbahaya->nilai)/sqrt(array_sum($array_pangkatdua_komposisiberbahaya));
                                        $cost_optimasi_komposisiberbahaya = $cost_normalisasi_komposisiberbahaya*$bobot;
                                      }
                                    ?>
                                  @endif
                                  @endforeach
                                  <?php
                                    $sum_benefit = $benefit_optimasi_tipekulit+$benefit_optimasi_jeniskelamin+$benefit_optimasi_kemudahanpencarian+$benefit_optimasi_komposisiberbahaya;
                                    $sum_cost = $cost_optimasi_tipekulit+$cost_optimasi_jeniskelamin+$cost_optimasi_kemudahanpencarian+$cost_optimasi_komposisiberbahaya;
                                    $sum_benefitcost = $sum_benefit-$sum_cost;
                                    echo number_format($sum_benefitcost, 3, ',', '');
                                    $array_sum_benefitcost[] = $sum_benefitcost;
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    rsort($rank_moora);
                                    $countrank = count($array_sum_benefitcost);
                                    if(($no-1) == $countrank) {
                                      echo 'Ranking Nomor '.(array_search($sum_benefitcost, $rank_moora)+1);
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