@vite('resources/js/driver/index.js')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Driver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createDriver">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required
                            placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label for="no_tlp">No Telfon</label>
                        <input type="number" class="form-control" id="no_tlp" name="no_tlp" required
                            placeholder="No Telfon">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            placeholder="email@gmail.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            placeholder="**********">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required placeholder="Alamat Lengkap"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserModalLabel">Edit Data Orang Tua</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    @csrf
                    <input type="hidden" id="editUserId" name="id">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="editNamaLengkap" name="nama_lengkap" required
                            placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label for="no_tlp">No Telfon</label>
                        <input type="number" class="form-control" id="editNoTlp" name="no_tlp" required
                            placeholder="No Telfon">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required
                            placeholder="email@gmail.com">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="editAlamat" name="alamat" required placeholder="Alamat Lengkap"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password"
                            placeholder="**********">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="saveChanges" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confrimDeleteModal" tabindex="-1" aria-labelledby="confrimDeleteModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confrimDeleteModalLabel">Delete Data Orang Tua</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteUserForm">
                    @csrf
                    <input type="hidden" id="deleteUserId" name="id">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="deleteNamaLengkap" name="nama_lengkap"
                            required placeholder="Nama Lengkap">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="deleteChanges" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
