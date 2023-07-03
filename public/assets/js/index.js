class Component {
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
    
    static tambahKeluarga = () => {
        let num = 1;
        $("#card_keluarga").append(`
        <div class="col-sm-6" id="card-keluarga-${num}">
        <input type="hidden" name="keluarga[]" required value="keluarga" id="keluarga">
            <div class="card">
                <div style="display: flex; justify-content: flex-end; padding: 0.75rem">
                    <button class="btn btn-danger" type="button" onclick="Component.hapusKeluarga('card-keluarga-${num}')">x</button>
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
                </div>
            </div>
        </div>
        `)
        num++
    }

    static hapusKeluarga = (id) => {
        console.log(id)
        $(`#${id}`).remove()
    }

    // static destroyAnak = ({url: url, token: token}) => {
    //     $.ajax({
    //         type: "DELETE",
    //         url: url,
    //         headers: {
    //             'X-CSRF-TOKEN': token,
    //         },
    //         success: function (res) {
    //             console.log(res)
    //         }
    //     });
    // }
    // static destroyKeluarga = ({url: url, token: token}) => {
    //     $.ajax({
    //         type: "DELETE",
    //         url: url,
    //         headers: {
    //             'X-CSRF-TOKEN': token,
    //         },
    //         success: function (res) {
    //             console.log(res)
    //         }
    //     });
    // }
}