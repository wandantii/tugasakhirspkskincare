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
    <!-- row -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Datatable - Penilaian</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="display" style="min-width: 845px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Tipe Kulit</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  @foreach($data as $key=>$value)
                  <tr>
                    <td><?php echo $no++.'.'; ?></td>
                    <td>{{ $value->username }}</td>
                    <td>{{ $value->namalengkap }}</td>
                    <td><?php if(isset($value->tipekulit)) { echo $value->namatipekulit; } else { echo '<span class="badge badge-xs light badge-danger">Belum terinput oleh user</span>'; } ?></td>
                    <td><?php if(isset($value->namajeniskelamin)) { echo $value->namajeniskelamin; } else { echo '<span class="badge badge-xs light badge-danger">Belum terinput oleh user</span>'; } ?></td>
                    <td><?php if(isset($value->usia)) { echo $value->usia." Tahun"; } else { echo '<span class="badge badge-xs light badge-danger">Belum terinput oleh user</span>'; } ?></td>
                    <?php if(isset($value->jeniskelamin) && isset($value->tipekulit) && isset($value->usia)) { ?>
										<td><a href="{{ url('admin/penilaian/'.$value->id_user.'/show') }}" class="btn btn-info shadow btn-xs sharp me-1"><i class="fas fa-eye"></i></a></td>
                    <?php } else { ?>
										<td><a href="" class="btn btn-dark shadow btn-xs sharp me-1" style="pointer-events:none;"><i class="fas fa-eye"></i></a></td>
                    <?php } ?>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Tipe Kulit</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Content body end -->

@endsection