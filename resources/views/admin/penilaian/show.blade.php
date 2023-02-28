@extends('admin.layout')

@section('content')

<!-- Sidebar start -->
<div class="dlabnav">
  <div class="dlabnav-scroll">
    <ul class="metismenu" id="menu">
      <!-- Beranda menu start -->
      <li>
        <a class="" href="{{ url('admin') }}" aria-expanded="false">
          <i class="fas fa-home"></i>
          <span class="nav-text">Beranda</span>
        </a>
      </li>
      <!-- Beranda menu end -->
      <!-- Data Master menu start -->
      <li>
        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-table"></i>
          <span class="nav-text">Data Master</span>
        </a>
        <ul aria-expanded="false">
          <li><a href="{{ url('admin/kriteria') }}">Kriteria</a></li>
          <li><a href="{{ url('admin/subkriteria') }}">Sub Kriteria</a></li>
          <li><a href="{{ url('admin/nilaikriteria') }}">Nilai Kriteria</a></li>
          <li><a href="{{ url('admin/kategoriproduk') }}">Kategori Produk</a></li>
          <li><a href="{{ url('admin/user') }}">User</a></li>
        </ul>
      </li>
      <!-- Data Master menu end -->
      <!-- Data Perhitungan menu start -->
      <li>
        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
          <i class="fas fa-file-alt"></i>
          <span class="nav-text">Perhitungan</span>
        </a>
        <ul aria-expanded="false">
          <li><a href="{{ url('admin/produk') }}">Produk</a></li>
          <li><a href="{{ url('admin/alternatif') }}">Alternatif</a></li>
          <li class="mm-active"><a href="{{ url('admin/penilaian') }}" class="mm-active">Penilaian</a></li>
        </ul>
      </li>
      <!-- Data Perhitungan menu end -->
    </ul>
  </div>
</div>
<!-- Sidebar end -->
    
<!-- Content body start -->
<div class="content-body">
  <div class="container-fluid">
    <div class="col-lg-12">
      @if(session()->has('success'))
      <div class="alert alert-outline-success alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        <strong>Success!</strong> {{ session('success') }}
      </div>
      @endif
      @if(session()->has('error'))
      <div class="alert alert-outline-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        <strong>Failed!</strong> {{ session('error') }}
      </div>
      @endif
      <div class="card">
        <div class="card-header d-block">
          <h4 class="card-title"><b>Penilaian</b></h4>
          <p class="mb-0 subtitle">Hi beauty! Disini kamu bisa memproses data-data untuk Penilaian</p>
        </div>
      </div>
    </div>
    <!-- Metode COPRAS -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Metode COPRAS</h4>
          </div>
          <div class="card-body">
            <div class="profile-tab">
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
                                        echo number_format(($bytipekulit->nilai/$pembagi), 3, ',', '');;
                                      ?>
                                    @endif
                                    @endforeach
                                  </td>
                                  <td>
                                    @foreach($byjeniskelamins as $byjeniskelamin)
                                    @if($byjeniskelamin->id_produk == $produk->id_produk)
                                      <?php 
                                        $pembagi = $byjeniskelamins->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        echo number_format(($byjeniskelamin->nilai/$pembagi), 3, ',', '');;
                                      ?>
                                    @endif
                                    @endforeach
                                  </td>
                                  <td>
                                    @foreach($bykemudahanpencarians as $bykemudahanpencarian)
                                    @if($bykemudahanpencarian->id_produk == $produk->id_produk)
                                      <?php 
                                        $pembagi = $bykemudahanpencarians->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        echo number_format(($bykemudahanpencarian->nilai/$pembagi), 3, ',', '');;
                                      ?>
                                    @endif
                                    @endforeach
                                  </td>
                                  <td>
                                    @foreach($bykomposisiberbahayas as $bykomposisiberbahaya)
                                    @if($bykomposisiberbahaya->id_produk == $produk->id_produk)
                                      <?php 
                                        $pembagi = $bykomposisiberbahayas->where('id_kategoriproduk', $kategoriproduk->id_kategoriproduk)->sum('nilai');
                                        echo number_format(($bykomposisiberbahaya->nilai/$pembagi), 3, ',', '');;
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
                                        echo number_format((($bytipekulit->nilai/$pembagi)*$bobot), 3, ',', '');;
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
                                        echo number_format((($byjeniskelamin->nilai/$pembagi)*$bobot), 3, ',', '');;
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
                                        echo number_format((($bykemudahanpencarian->nilai/$pembagi)*$bobot), 3, ',', '');;
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
                                        echo number_format((($bykomposisiberbahaya->nilai/$pembagi)*$bobot), 3, ',', '');;
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
                                  <td><b><?php echo number_format((array_sum($sumsmini)), 3, ',', ''); ?><b></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
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
                        <div class="perhitungan-hidden" style="display:none;">
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
                                  <td><b><?php echo number_format((array_sum($array_sigma_satupersmini_hidden)), 3, '.', ''); ?><b></td>
                                  <td></td>
                                  <td></td>
                                  <td><b><?php echo number_format(max($array_qmax), 3, '.', ''); ?><b></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
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
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Metode MOORA -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Metode MOORA</h4>
          </div>
          <div class="card-body">
            <div class="profile-tab">
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
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Content body end -->

@endsection