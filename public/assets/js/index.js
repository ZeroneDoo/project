class Component {
    static dataPengantin;
    static num_keluarga = 1;

    static getProvinsi = async (prev = "") => {
        await $.ajax({
            type: "GET",
            url: "http://dev.farizdotid.com/api/daerahindonesia/provinsi",
            success: function (res) {
                if(res){
                    res.provinsi.forEach(data => {
                        // console.log(data)
                        $("#provinsi").append(`
                        <option ${prev == data.nama ? 'selected' : ''} value="${data.id}">${data.nama}</option>
                        `);
                    });
                }
            }
        });
    }
    static getKota = async (prov, prev = "") => {
        let value =$(prov).val()

        if(prev == "") value ? $("#kabupaten").prop("disabled", false) : $("#kabupaten").prop("disabled", true)

        await $.ajax({
            type: "GET",
            url: `http://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=${$(prov).val()}`,
            success: function (res) {
                if(res){
                    $("#kabupaten").html(`<option></option>`)
                    $("#kecamatan").html(`<option></option>`)
                    res.kota_kabupaten.forEach(data => {
                        // console.log(data)
                        $("#kabupaten").append(`
                        <option ${prev == data.nama ? 'selected' : ''} value="${data.id}">${data.nama}</option>
                        `);
                    });
                }
            }
        });
    }
    static getKecamatan = async (kota, prev = "") => {
        let value = $("#provinsi").val()

        if(prev == "") value && $(kota).val() ? $("#kecamatan").prop("disabled", false) : $("#kecamatan").prop("disabled", true)

        await $.ajax({
            type: "GET",
            url: `http://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=${$(kota).val()}`,
            success: function (res) {
                if(res){
                    $("#kecamatan").html(`<option></option>`)
                    res.kecamatan.forEach(data => {
                        // console.log(data)
                        $("#kecamatan").append(`
                        <option ${prev == data.nama ? 'selected' : ''} value="${data.id}">${data.nama}</option>
                        `);
                    });
                }
            }
        });
    }

    static statusMenikah = (val) => {
        let value = $(val).val()

        if(value == "Sudah Menikah"){
            $("#card_kepala_keluarga").removeAttr("hidden")
            $("#card_pasangan").removeAttr("hidden")
            this.enabledPasangan()
            $("#anak").removeAttr("hidden")
        }else if(value == "Belum Menikah"){
            $("#card_kepala_keluarga").removeAttr("hidden")
            $("#card_pasangan").attr("hidden", true)
            this.disabledPasangan()
            $("#anak").attr("hidden", true)
        }else if(value == "Cerai"){
            $("#anak").removeAttr("hidden")
            $("#card_pasangan").attr("hidden", true)
            $("#card_kepala_keluarga").removeAttr("hidden")
        }
    }

    static disabledPasangan = () => {
        var pasangan = document.getElementById("card_pasangan");

        var inputs = pasangan.querySelectorAll("input, select");

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = true;
        }
    }

    static enabledPasangan = () => {
        var pasangan = document.getElementById("card_pasangan");

        var inputs = pasangan.querySelectorAll("input, select");

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
        }
    }

    static showAlert = (message ,status) => {
        if(status == 'success'){
            iziToast.success({
                title: 'Success',
                message: message,
                position: 'topRight'
            });
        }else if(status == 'error'){
            iziToast.error({
                title: 'Failed',
                message: message,
                position: 'topRight',
            });
        }else if(status == 'info'){
            iziToast.info({
                title: 'Info',
                message: message,
                position: 'topRight'
            });
        }
    }

    static tambahAnak = () => {
        let num = 1;
        $("#card_anak").append(`
        <div class="col-sm-6" id="card-${num}">
        <input type="hidden" name="anak[]" value="anak" id="anak">
            <div class="card">
                <div style="display: flex; justify-content: flex-end; padding: 0.75rem">
                    <button class="btn btn-danger" type="button" onclick="Component.hapusAnak('card-${num}')">x</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_anak">Nama Lengkap *</label>
                        <div class="row" style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                            <div class="col">
                                <input type="text" required class="form-control" name="nama_anak[]"
                                    id="nama_anak">
                            </div>
                            <div class="col-5">
                                <select name="jk_anak[]" required class="form-select" id="jk_anak">
                                    <option value="" hidden selected>Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir_anak">Tempat Lahir *</label>
                        <input type="text" required class="form-control" name="tmpt_lahir_anak[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tmpt_lahir_anak">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir_anak">Tanggal Lahir *</label>
                        <input type="date" required class="form-control" name="tgl_lahir_anak[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tgl_lahir_anak">
                    </div>
                    <div class="form-group">
                        <label for="pendidikan_anak">Pendidikan *</label>
                        <input type="text" required class="form-control" name="pendidikan_anak[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pendidikan_anak">
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan_anak">Pekerjaan (optional)</label>
                        <input type="text" class="form-control" name="pekerjaan_anak[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pekerjaan_anak">
                    </div>
                    <div class="form-group">
                        <label for="diserahkan_anak">Diserahkan *</label>
                        <select name="diserahkan_anak[]" required style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="diserahkan_anak">
                            <option value="" hidden selected>Diserahkan</option>
                            <option value="Y">Iya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="baptis_anak">Baptis Selam *</label>
                        <select name="baptis_anak[]" required style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="baptis_anak">
                            <option value="" hidden selected>Baptis Selam</option>
                            <option value="Y">Iya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nikah_anak">Nikah *</label>
                        <select name="nikah_anak[]" required style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="nikah_anak">
                            <option value="" hidden selected>Nikah</option>
                            <option value="Y">Iya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        `)
        num++
    }

    static hapusAnak = (id) => {
        $(`#${id}`).remove()
    }
    
    static tambahKeluarga = ({hubungan: hubungans}) => {
        let values = JSON.parse(hubungans)
        console.log(Component.num_keluarga)
        $("#card_keluarga").append(`
        <div class="col-sm-6" id="card-keluarga-${Component.num_keluarga}" style='margin-bottom:1rem;'>
        <input type="hidden" name="keluarga[]" required value="keluarga" id="keluarga">
            <div class="card">
                <div style="display: flex; justify-content: flex-end; padding: 0.75rem">
                    <button class="btn btn-danger" type="button" onclick="Component.hapusKeluarga('card-keluarga-${Component.num_keluarga}')">x</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_keluarga">Nama Lengkap *</label>
                        <div class="row" style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                            <div class="col">
                                <input type="text" required class="form-control" name="nama_keluarga[]"
                                    id="nama_keluarga">
                            </div>
                            <div class="col-5">
                                <select name="jk_keluarga[]" required class="form-select" id="jk_keluarga">
                                    <option value="" hidden selected>Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir_keluarga">Tempat Lahir *</label>
                        <input type="text" required class="form-control" name="tmpt_lahir_keluarga[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tmpt_lahir_keluarga">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir_keluarga">Tanggal Lahir *</label>
                        <input type="date" required class="form-control" name="tgl_lahir_keluarga[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tgl_lahir_keluarga">
                    </div>
                    <div class="form-group">
                        <label for="pendidikan_keluarga">Pendidikan *</label>
                        <input type="text" required class="form-control" name="pendidikan_keluarga[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pendidikan_keluarga">
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan_keluarga">Pekerjaan (optional)</label>
                        <input type="text" class="form-control" name="pekerjaan_keluarga[]"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pekerjaan_keluarga">
                    </div>
                    <div class="form-group">
                        <label for="diserahkan_keluarga">Diserahkan *</label>
                        <select name="diserahkan_keluarga[]" required style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="diserahkan_keluarga">
                            <option value="" hidden selected>Diserahkan</option>
                            <option value="Y">Iya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="baptis_keluarga">Baptis Selam *</label>
                        <select name="baptis_keluarga[]" required style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="baptis_keluarga">
                            <option value="" hidden selected>Baptis Selam</option>
                            <option value="Y">Iya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nikah_keluarga">Nikah *</label>
                        <select name="nikah_keluarga[]" required style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="nikah_keluarga">
                            <option value="" hidden selected>Nikah</option>
                            <option value="Y">Iya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Hubungan *</label>
                        <select name="hubungan_keluarga[]" onchange="Component.hubunganInput(this, '#hubungan-input-${Component.num_keluarga}', 'hubungan_keluarga[]x')"  style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="hubungan_keluarga">
                            <option value="" hidden selected>Hubungan</option>
                            ${values.map(hubungan => `<option value="${hubungan}">${hubungan}</option>`)}
                            <option value="">Lainnya</option>
                        </select>
                        <div id="hubungan-input-${Component.num_keluarga}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `)
        Component.num_keluarga++
    }

    static hubunganInput = (select, id_input, name) => {
        let value = $(select).val()
        let id = $(id_input)

        if(value === "") {
            console.log(value)
            $(id).html(`
            <label for="">Hubungan lainnya</label>
            <input required class="form-control" name="${name}">
            `)
        }else {
            $(id).html(``)
        }
    }

    static hapusKeluarga = (id) => {
        $(`#${id}`).remove()
    }

    static searchKkj = ({route:route, token:token}) => {
        let value = $("#search").val()
        let hubungan = $("#hubungan").val()
        $.ajax({
            url: route,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': token,
            },
            data: {
                kode:value,
                hubungan:hubungan
            },
            success: function (res) {
                // console.log(res)
                if(res.length != 0){
                    $('#select-keluarga-anak').prop('hidden', false)
                    $('#keluarga_anak_id').html(`<option value="" selected hidden>Pilih orang di bawah ini</option>`)
                    res.forEach(data => {
                        $('#keluarga_anak_id').append(`<option value="${data.id}">${data.nama}</option>`)
                    });
                }else{
                    $('#keluarga_anak_id').html(`<option value="" selected hidden>Pilih orang di bawah ini</option>`)
                    $('#card_penyerahan_baptis').prop('hidden', true)
                    return Component.showAlert("Data yang dicari tidak ada", "info")
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                Component.showAlert("Gagal mencari data", "error")
                $('#card_penyerahan_baptis').prop('hidden', true)
                $('#select-keluarga-anak').prop('hidden', true)
            }
        });
    }

    static getDataKandidat = ({route:route,select:select, token:token}) => {
        let value = $(select).val()
        let hubungan = $("#hubungan").val()

        $.ajax({
            type: "POST",
            url: route,
            headers: {
                'X-CSRF-TOKEN': token,
            },
            data: {
                id: value,
                hubungan
            },
            success: function (res) {
                console.log(res)
                if(res){
                    $("#card_penyerahan_baptis").prop("hidden", false)
                    $("#data_kandidat").html(
                        `<input type="hidden" value="${res.id}" id="id" name="id">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" disabled value="${res.nama}" name="nama" class="form-control">
                                </div>
                                <div class="col-5">
                                    <input type="text" disabled value="${res.jk =='L' ? 'Laki-Laki': 'Perempuan'}" name="jk" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" disabled>${res.kkj.alamat}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="tmpt_lahir">Tempat & Tanggal Lahir</label>
                            <input type="text" class="form-control" disabled value="${ res.tmpt_lahir +", "+ res.tgl_lahir }">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Ayah</label>
                            <input type="text" disabled class="form-control" value="${res.kepala_keluarga.nama}">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Ibu</label>
                            <input type="text" disabled class="form-control" value="${res.pasangan ?res.pasangan.nama : 'Tidak Ada'}">
                        </div>`
                    )

                    // input checkbox
                    if(res.baptis == "Y") {
                        $("#baptis").prop("checked", true)
                        $("#baptis").prop("disabled", true)
                    }else{
                        $("#baptis").prop("checked", false)
                        $("#baptis").prop("disabled", false)
                    }

                    if(res.diserahkan == "Y") {
                        $("#penyerahan").prop("checked", true)
                        $("#penyerahan").prop("disabled", true)
                    }else{
                        $("#penyerahan").prop("checked", false)
                        $("#penyerahan").prop("disabled", false)
                    }
                }
            }
        });
    }

    static getDataPengantin = ({route:route,select:select, token:token}) => {
        let value = $(select).val()
        let hubungan = $("#hubungan").val()

        $.ajax({
            type: "POST",
            url: route,
            headers: {
                'X-CSRF-TOKEN': token,
            },
            data: {
                id: value,
                hubungan
            },
            success: function (res) {
                if(res){
                    console.log(res)
                    if(res == 'info') {
                        $("#card_pria").prop("hidden", true)
                        $("#card_wanita").prop("hidden", true)
                        Component.showAlert("Pengantin tersebut belum di baptis", res)
                        return
                    }
                    Component.jkPengantin(res.jk, res)
                    $("#card_pria").prop("hidden", false)
                    $("#card_wanita").prop("hidden", false)
                }
            }
        });
    }

    static jkPengantin = (val, res) => {
        // let value = $(val).val()
        let value = val

        if(value == 'L'){
            // reset wanita
            $("#pengantin_wanita").html(`
            <p style="font-weight: 500; font-size: 20px">Pengantin Wanita</p>
            <div class="form-group">
                <label for="nama_wanita">Nama Wanita</label>
                <input type="text" name="nama_wanita" id="nama_wanita" required class="form-control">
            </div>
            <div class="form-group">
                <label for="">Hari, Tanggal Baptis Selam</label>
                <input type="datetime-local" class="form-control" required name="waktu_baptis_wanita" id="waktu_baptis_wanita">
            </div>
            <div class="form-group">
                <label for="gereja_wanita">Baptis di Gereja</label>
                <input type="text" class="form-control" name="gereja_wanita" required id="gereja_wanita">
            </div>
            <div class="form-group">
                <label for="no_kkj_wanita">No. Kartu Keluarga Jemaat</label>
                <input type="text" class="form-control" name="no_kkj_wanita" required id="no_kkj_wanita">
            </div>
            <div class="form-group">
                <label for="no_ktp_wanita">No. KTP</label>
                <input type="number" class="form-control" name="no_ktp_wanita" required id="no_ktp_wanita">
            </div>
            <div class="form-group">
                <label for="tmpt_lahir_wanita">Tempat Lahir</label>
                <input type="text" class="form-control" name="tmpt_lahir_wanita" required id="tmpt_lahir_wanita">
            </div>
            <div class="form-group">
                <label for="tgl_lahir_wanita">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir_wanita" required id="tgl_lahir_wanita">
            </div>
            <div class="form-group">
                <label for="status_pernikahan_wanita">Status Pernikahan</label>
                <select name="status_pernikahan_wanita" id="status_pernikahan_wanita" required class="form-select">
                    <option value="" selected hidden>Pilih Status Pernikahan</option>
                    <option value="Belum Pernah">Belum Pernah</option>
                    <option value="Belum Pernah">Sudah Pernah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat_wanita">Alamat Saat Ini</label>
                <textarea class="form-control" name="alamat_wanita" required id="alamat_wanita"></textarea>
            </div>
            <div class="form-group">
                <label for="no_telp_wanita">No Telepon untuk dihubungi</label>
                <input class="form-control" name="no_telp_wanita" required id="no_telp_wanita">
            </div>
            <div class="form-group">
                <label for="nama_ayah_wanita">Nama Ayah</label>
                <input class="form-control" name="nama_ayah_wanita" required id="nama_ayah_wanita">
            </div>
            <div class="form-group">
                <label for="nama_ibu_wanita">Nama Ibu</label>
                <input class="form-control" name="nama_ibu_wanita" required id="nama_ibu_wanita">
            </div>
            <div class="form-group">
                <label for="">Foto Wanita</label>
                <input type="file" accept="image/*" class="form-control" name="foto_wanita">
            </div>
            `)

            // fill pria
            $("#pengantin_pria").html(`
            <p style="font-weight: 500; font-size: 20px">Pengantin Pria</p>
            <input type="hidden" value="pria" name="pengantin_pria">
            <input type="hidden" value="${res.id}" name="id">
            <div class="form-group">
                <label for="nama_pria">Nama Pria</label>
                <input type="text" name="nama_pria" disabled value="${res.nama}" required id="nama_pria" class="form-control">
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label for="">Hari, Tanggal Baptis Selam</label>
                <input type="datetime-local" class="form-control" required disabled value="${res.baptiss.waktu}" name="waktu_baptis_pria" id="waktu_baptis_pria">
                <small style="font-weight:500">${res.baptiss.waktu_format}</small>
            </div>
            <div class="form-group">
                <label for="gereja_pria">Baptis di Gereja</label>
                <input type="text" class="form-control" name="gereja_pria" required value="GBI (Gereja Bethel Indonesia)" id="gereja_pria">
            </div>
            <div class="form-group">
                <label for="no_kkj_pria">No. Kartu Keluarga Jemaat</label>
                <input type="text" class="form-control" name="no_kkj_pria" required value="${res.kkj.kode}" id="no_kkj_pria">
            </div>
            <div class="form-group">
                <label for="no_ktp_pria">No. KTP</label>
                <input type="number" class="form-control" name="no_ktp_pria" required id="no_ktp_pria">
            </div>
            <div class="form-group">
                <label for="tmpt_lahir_pria">Tempat Lahir</label>
                <input type="text" class="form-control" name="tmpt_lahir_pria" disabled required value="${res.tmpt_lahir}" id="tmpt_lahir_pria">
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label for="tgl_lahir_pria">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir_pria" disabled required value="${res.tgl_lahir}" id="tgl_lahir_pria">
                <small style="font-weight:500">${res.tgl_lahir_format}</small>
            </div>
            <div class="form-group">
                <label for="status_pernikahan_pria">Status Pernikahan</label>
                <select name="status_pernikahan_pria" id="status_pernikahan_pria" required class="form-select">
                    <option value="" selected >Pilih Status Pernikahan</option>
                    <option value="Belum Pernah">Belum Pernah</option>
                    <option value="Belum Pernah">Sudah Pernah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat_pria">Alamat Saat Ini</label>
                <textarea class="form-control" name="alamat_pria" required id="alamat_pria">${res.kkj.alamat}</textarea>
            </div>
            <div class="form-group">
                <label for="no_telp_pria">No Telepon untuk dihubungi</label>
                <input class="form-control" name="no_telp_pria" required id="no_telp_pria">
            </div>
            <div class="form-group">
                <label for="nama_ayah_pria">Nama Ayah</label>
                <input class="form-control" name="nama_ayah_pria" required disabled value="${res.kepala_keluarga.nama}" id="nama_ayah_pria">
            </div>
            <div class="form-group">
                <label for="nama_ibu_pria">Nama Ibu</label>
                <input class="form-control" name="nama_ibu_pria" required disabled value="${res.pasangan ? res.pasangan.nama : 'Tidak Ada'}" id="nama_ibu_pria">
            </div>
            <div class="form-group">
                <label for="">Foto Pria</label>
                <input type="file" accept="image/*" class="form-control" name="foto_pria">
            </div>
            `)
        }else if(value == "P"){
            // reset pria
            $("#pengantin_pria").html(`
            <p style="font-weight: 500; font-size: 20px">Pengantin Pria</p>
            <div class="form-group">
                <label for="nama_pria">Nama Pria</label>
                <input type="text" name="nama_pria" id="nama_pria" required class="form-control">
            </div>
            <div class="form-group">
                <label for="">Hari, Tanggal Baptis Selam</label>
                <input type="datetime-local" class="form-control" required name="waktu_baptis_pria" id="waktu_baptis_pria">
            </div>
            <div class="form-group">
                <label for="gereja_pria">Baptis di Gereja</label>
                <input type="text" class="form-control" name="gereja_pria" required id="gereja_pria">
            </div>
            <div class="form-group">
                <label for="no_kkj_pria">No. Kartu Keluarga Jemaat</label>
                <input type="text" class="form-control" name="no_kkj_pria" required id="no_kkj_pria">
            </div>
            <div class="form-group">
                <label for="no_ktp_pria">No. KTP</label>
                <input type="number" class="form-control" name="no_ktp_pria" required id="no_ktp_pria">
            </div>
            <div class="form-group">
                <label for="tmpt_lahir_pria">Tempat Lahir</label>
                <input type="text" class="form-control" name="tmpt_lahir_pria" required id="tmpt_lahir_pria">
            </div>
            <div class="form-group">
                <label for="tgl_lahir_pria">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir_pria" required id="tgl_lahir_pria">
            </div>
            <div class="form-group">
                <label for="status_pernikahan_pria">Status Pernikahan</label>
                <select name="status_pernikahan_pria" required id="status_pernikahan_pria" class="form-select">
                    <option value="" selected hidden>Pilih Status Pernikahan</option>
                    <option value="Belum Pernah">Belum Pernah</option>
                    <option value="Belum Pernah">Sudah Pernah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat_pria">Alamat Saat Ini</label>
                <textarea class="form-control" name="alamat_pria" required id="alamat_pria"></textarea>
            </div>
            <div class="form-group">
                <label for="no_telp_pria">No Telepon untuk dihubungi</label>
                <input class="form-control" name="no_telp_pria" required id="no_telp_pria">
            </div>
            <div class="form-group">
                <label for="nama_ayah_pria">Nama Ayah</label>
                <input class="form-control" name="nama_ayah_pria" required id="nama_ayah_pria">
            </div>
            <div class="form-group">
                <label for="nama_ibu_pria">Nama Ibu</label>
                <input class="form-control" name="nama_ibu_pria" required id="nama_ibu_pria">
            </div>
            <div class="form-group">
                <label for="">Foto Pria</label>
                <input type="file" accept="image/*" class="form-control" name="foto_pria">
            </div>
            `)

            // fill wanita
            $("#pengantin_wanita").html(`
            <p style="font-weight: 500; font-size: 20px">Pengantin Wanita</p>
            <input type="hidden" value="${res.id}" name="id">
            <input type="hidden" value="wanita" name="pengantin_wanita">
            <div class="form-group">
                <label for="nama_wanita">Nama Wanita</label>
                <input type="text" name="nama_wanita" id="nama_wanita" disabled required value="${res.nama}" class="form-control">
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label for="">Hari, Tanggal Baptis Selam</label>
                <input type="datetime-local" class="form-control" required name="waktu_baptis_wanita" disabled value="${res.baptiss.waktu}" id="waktu_baptis_wanita">
                <small style="font-weight:500">${res.baptiss.waktu_format}</small>
            </div>
            <div class="form-group">
                <label for="gereja_wanita">Baptis di Gereja</label>
                <input type="text" class="form-control" name="gereja_wanita" required value="GBI (Gereja Bethel Indonesia)" id="gereja_wanita">
            </div>
            <div class="form-group">
                <label for="no_kkj_wanita">No. Kartu Keluarga Jemaat</label>
                <input type="text" class="form-control" name="no_kkj_wanita" required value="${res.kkj.kode}" id="no_kkj_wanita">
            </div>
            <div class="form-group">
                <label for="no_ktp_wanita">No. KTP</label>
                <input type="number" class="form-control" name="no_ktp_wanita"  required id="no_ktp_wanita">
            </div>
            <div class="form-group">
                <label for="tmpt_lahir_wanita">Tempat Lahir</label>
                <input type="text" class="form-control" name="tmpt_lahir_wanita" disabled required value="${res.tmpt_lahir}" id="tmpt_lahir_wanita">
            </div>
            <div class="form-group" style="margin-bottom:1rem">
                <label for="tgl_lahir_wanita">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir_wanita" disabled required value="${res.tgl_lahir}" id="tgl_lahir_wanita">
                <small style="font-weight:500">${res.tgl_lahir_format}</small>
            </div>
            <div class="form-group">
                <label for="status_pernikahan_wanita">Status Pernikahan</label>
                <select name="status_pernikahan_wanita" id="status_pernikahan_wanita" required class="form-select">
                    <option value="" selected hidden>Pilih Status Pernikahan</option>
                    <option value="Belum Pernah">Belum Pernah</option>
                    <option value="Belum Pernah">Sudah Pernah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat_wanita">Alamat Saat Ini</label>
                <textarea class="form-control" name="alamat_wanita" required id="alamat_wanita">${res.kkj.alamat}</textarea>
            </div>
            <div class="form-group">
                <label for="no_telp_wanita">No Telepon untuk dihubungi</label>
                <input class="form-control" name="no_telp_wanita" required id="no_telp_wanita">
            </div>
            <div class="form-group">
                <label for="nama_ayah_wanita">Nama Ayah</label>
                <input class="form-control" name="nama_ayah_wanita" disabled required value="${res.kepala_keluarga.nama}" id="nama_ayah_wanita">
            </div>
            <div class="form-group">
                <label for="nama_ibu_wanita">Nama Ibu</label>
                <input class="form-control" name="nama_ibu_wanita" disabled required value="${res.pasangan ? res.pasangan.nama : 'Tidak Ada'}" id="nama_ibu_wanita">
            </div>
            <div class="form-group">
                <label for="">Foto Wanita</label>
                <input type="file" accept="image/*" class="form-control" name="foto_wanita">
            </div>
            `)
        }
    }
}