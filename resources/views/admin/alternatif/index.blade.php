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
          <li class="mm-active"><a href="{{ url('admin/alternatif') }}" class="mm-active">Alternatif</a></li>
          <li><a href="{{ url('admin/penilaian') }}">Penilaian</a></li>
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
          <h4 class="card-title"><b>Alternatif</b></h4>
          <p class="mb-0 subtitle">Hi beauty! Disini kamu bisa memproses data-data untuk Alternatif</p>
        </div>
        <div class="card-body">
          <!-- Tambah data button start -->
          <a href="{{ url('admin/alternatif/create') }}" type="button" class="btn btn-rounded btn-primary">
            <span class="btn-icon-start text-primary">
              <i class="fa fa-plus"></i>
            </span>
            Tambah Data
          </a>
          <!-- Tambah data button end -->
        </div>
      </div>
    </div>
    <!-- row -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Datatable - Alternatif</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="display" style="min-width: 845px">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kategori Produk</th>
                    <th>Merk</th>
                    <th>Produk</th>
                    <th>Kriteria</th>
                    <th>Sub Kriteria</th>
                    <th>Nilai</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; ?>
                  @foreach($data as $key=>$value)
                  <tr>
                    <td><?php echo $no++.'.'; ?></td>
                    <td>{{ $value->namakategoriproduk }}</td>
                    <td>{{ $value->merk }}</td>
                    <td>{{ $value->namaproduk }}</td>
                    <td>{{ $value->namakriteria }}</td>
                    <td><?php if(isset($value->namasubkriteria)) { echo $value->namasubkriteria; } else { echo "-"; } ?></td>
                    <td>{{ $value->nilai }}</td>
                    <td>
                      <div class="d-flex">
											  <a href="{{ url('admin/alternatif/'.$value->id_produk.'/show') }}" class="btn btn-info shadow btn-xs sharp me-1"><i class="fas fa-eye"></i></a>
											  <a href="{{ url('admin/alternatif/'.$value->id_produk.'/edit') }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{ url('admin/alternatif/'.$value->id_produk.'/') }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
                          @csrf
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                            &nbsp;<i class="fas fa-trash"></i>&nbsp;
                          </button>
                        </form>
											</div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kategori Produk</th>
                    <th>Nama Produk</th>
                    <th>Kriteria</th>
                    <th>Sub Kriteria</th>
                    <th>Nilai</th>
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