<!-- Modal untuk memilih mobil -->
<div class="modal fade" id="modalListMobil" tabindex="-1" aria-labelledby="modalListMobilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListMobilLabel">Pilih Mobil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Plat</th>
                                <th>Merk</th>
                                <th>Type</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mobils as $mobil)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mobil->number_plate }}</td>
                                    <td>{{ $mobil->merk }}</td>
                                    <td>{{ $mobil->type }}</td>
                                    <td>{{ number_format($mobil->price) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-pilih-mobil"
                                            data-id="{{ $mobil->id }}" data-merk="{{ $mobil->merk }}"
                                            data-type="{{ $mobil->type }}" data-bs-dismiss="modal">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
