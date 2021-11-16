<?php

namespace App\Helpers\GeneralAffair;

use Error;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Modules\GeneralAffair\Models\PersuratanJenisSuratKeluar;
use Modules\GeneralAffair\Models\PersuratanNomorSuratKeluar;
use Modules\GeneralAffair\Models\PersuratanSuratMasuk;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PersuratanHelper
{

    public function getLastLetterCodeSuratKeluar($codeBusinessUnit)
    {
        $setCodeLetter = '';

        $getLastCodeByBusinessUnit = PersuratanJenisSuratKeluar::with('business_unit')->where('code', 'like', $codeBusinessUnit['q'] . '-%')->orderBy('id', 'DESC')->first();

        if (is_null($getLastCodeByBusinessUnit)) {
            $setCodeLetter = $codeBusinessUnit['q'] . "-001";
        } else {
            $explodeCode = explode('-', $getLastCodeByBusinessUnit->code);
            $lastNumber = (int) $explodeCode[1];
            $squence =  sprintf("%03d", $lastNumber + 1);
            $setCodeLetter = $codeBusinessUnit['q'] . "-" . $squence;
        }

        return $setCodeLetter;
    }

    public function persuratanSuratKeluarStatus()
    {
        $dataSuratKeluarStatus = [
            "menunggu proses" => "info",
            "selesai" => "success",
        ];

        return $dataSuratKeluarStatus;
    }

    public function getLastLetterNumberSuratKeluar($jenis_surat_id)
    {
        $setLetterNumber = '';
        $thisYear = date('Y');

        $getDataJenisSurat = PersuratanJenisSuratKeluar::with('business_unit')->where('id', $jenis_surat_id)->first();

        $getLastByPenomoranSurat = PersuratanNomorSuratKeluar::with('business_unit', 'persuratan_jenis_surat_keluar')->where('business_unit_id', $getDataJenisSurat->business_unit_id)->orderBy('id', 'DESC')->first();

        if (is_null($getLastByPenomoranSurat)) {
            $setLetterNumber = $thisYear . '/' . $getDataJenisSurat->code . '/001';
        } else {
            $explodeNumber = explode('/', $getLastByPenomoranSurat->nomor_surat);
            $lastNumber = (int) $explodeNumber[2];
            $squence =  sprintf("%03d", $lastNumber + 1);

            $setLetterNumber = $thisYear . '/' . $getDataJenisSurat->code . '/' . $squence;
        }

        return $setLetterNumber;
    }

    public function persuratanConfidentialStatusColor()
    {
        $dataSuratKeluarConfidentialColor = [
            "no" => "info",
            "yes" => "danger",
        ];

        return $dataSuratKeluarConfidentialColor;
    }

    public function setTypePersuratanClass()
    {
        $dataPersuratanClass = [
            "surat keluar" => PersuratanNomorSuratKeluar::class,
        ];

        return $dataPersuratanClass;
    }

    public function persuratanSuratKeluarRequestStatus()
    {
        $dataSuratKeluarRequestStatus = [
            "menunggu" => "menunggu",
            "disetujui" => "disetujui",
        ];

        return $dataSuratKeluarRequestStatus;
    }

    public function persuratanSuratKeluarRequestStatusColor()
    {
        $dataSuratKeluarRequestStatus = [
            "menunggu" => "info",
            "disetujui" => "success",
        ];

        return $dataSuratKeluarRequestStatus;
    }

    public function persuratanSuratMasukStatus()
    {
        $dataSuratMasukStatus = [
            "belum diterima" => "belum diterima",
            "sudah diterima" => "sudah diterima",
        ];

        return $dataSuratMasukStatus;
    }

    public function persuratanSuratMasukStatusColor()
    {
        $dataSuratMasukStatus = [
            "belum diterima" => "warning",
            "sudah diterima" => "success",
        ];

        return $dataSuratMasukStatus;
    }

    public function persuratanSuratMasukTipe()
    {
        $suratKeluarTipe = [
            "umum" => "Umum",
            "bumn" => "BUMN",
        ];

        return $suratKeluarTipe;
    }

    public function persuratanSuratMasukTipeColor()
    {
        $suratKeluarTipeColor = [
            "umum" => "info",
            "bumn" => "success",
        ];

        return $suratKeluarTipeColor;
    }

    public function getLastLetterNumberSuratMasuk()
    {
        $setLetterCode = '';

        $getLastByCodeSuratKeluar = PersuratanSuratMasuk::with('business_unit', 'employee', 'employee_disposisi')->orderBy('id', 'DESC')->first();

        if (is_null($getLastByCodeSuratKeluar)) {
            $setLetterCode = '001';
        } else {
            $explodeNumber = explode('-', $getLastByCodeSuratKeluar->kode_surat);
            $lastNumber = (int) $explodeNumber[0];
            $squence =  sprintf("%03d", $lastNumber + 1);

            $setLetterCode = $squence;
        }

        return $setLetterCode;
    }

    public function persuratanBarangMasukStatus()
    {
        $dataBarangMasukStatus = [
            "belum diterima" => "belum diterima",
            "sudah diterima" => "sudah diterima",
        ];

        return $dataBarangMasukStatus;
    }

    public function persuratanBarangMasukStatusColor()
    {
        $dataBarangMasukStatus = [
            "belum diterima" => "warning",
            "sudah diterima" => "success",
        ];

        return $dataBarangMasukStatus;
    }
}