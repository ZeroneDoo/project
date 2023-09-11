<?php

namespace App\Http\Requests\KKJ;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // "nama_kepala_keluarga" => "required",
            // // "jk" => "required",
            // "alamat" => "required",
            // "rt_rw" => "required",
            // "telp" => "required",
            // "kecamatan" => "required",
            // "kabupaten" => "required",
            // "provinsi" => "required",
            // "status_menikah" => "required",
            // // ayah
            // "nama" => "required",
            // "jk" => "required",
            // "tmpt_lahir" => "required",
            // "tgl_lahir" => "required",
            // "pendidikan_terakhir" => "required",
            // "pekerjaan" => "required",
            // "baptis" => "required",
            // // ibu
            // "nama_ibu" => "required",
            // "jk_ibu" => "required",
            // "tmpt_lahir_ibu" => "required",
            // "tgl_lahir_ibu" => "required",
            // "pendidikan_terakhir_ibu" => "required",
            // "pekerjaan_ibu" => "required",
            // "baptis_date_ibu" => "required",
            // // anak
            // "nama_anak" => "required",
            // "jk_anak" => "required",
            // "tmpt_lahir_anak" => "required",
            // "tgl_lahir_anak" => "required",
            // "pendidikan_anak" => "required",
            // "pekerjaan_anak" => "required",
            // "diserahkan_anak" => "required",
            // "baptis_anak" => "required",
            // "nikah_anak" => "required",
            // // keluarga
            // "nama_keluarga" => "required",
            // "jk_keluarga" => "required",
            // "tmpt_lahir_keluarga" => "required",
            // "tgl_lahir_keluarga" => "required",
            // "pendidikan_keluarga" => "required",
            // "pekerjaan_keluarga" => "required",
            // "diserahkan_keluarga" => "required",
            // "baptis_keluarga" => "required",
            // "nikah_keluarga" => "required",
        ];
    }
}
