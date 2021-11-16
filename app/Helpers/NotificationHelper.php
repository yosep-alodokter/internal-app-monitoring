<?php

namespace App\Helpers;

use Error;
use Modules\User\Models\User;
use App\Models\SetConfiguration;
use Modules\Hrd\Models\Employee;
use Spatie\Permission\Models\Role;
use App\Models\RoleHasBusinessUnit;
use Illuminate\Support\Facades\Auth;
use Modules\Hrd\Models\BusinessUnit;
use Modules\User\Models\Notification;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Modules\GeneralAffair\Jobs\SendEmailUserActivated;
use Modules\GeneralAffair\Models\InvMaintenanceDetail;
use Modules\GeneralAffair\Jobs\SendEmailApproveSuratKeluar;
use Modules\GeneralAffair\Jobs\SendEmailRequestSuratKeluar;
use Modules\GeneralAffair\Jobs\SendEmailUserMaintenanceInventory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationHelper
{ 
    public function createNotification($dataRequest)
    {
        if (is_array($dataRequest['role_tujuan'])) {
            foreach ($dataRequest['role_tujuan'] as $key => $value) {
                $createNotification = Notification::create([
                    'judul_pesan' => $dataRequest['judul_pesan'],
                    'isi_pesan' => $dataRequest['isi_pesan'],
                    'link_pesan' => $dataRequest['link_pesan'],
                    'is_read' => 'no',
                    'role_tujuan' => $value,
                    'role_pengirim' => $dataRequest['role_pengirim'],
                    'note' => $dataRequest['note'],
                    'model_id' => $dataRequest['model_id'],
                    'model_type' => $dataRequest['model_type'],
                    'type' => $dataRequest['type'],
                    'employee_id_tujuan' => array_key_exists('employee_id_tujuan', $dataRequest) ? $dataRequest['employee_id_tujuan'] : null,
                    'created_by' => $dataRequest['user'],
                    'updated_by' => $dataRequest['user'],
                ]);

                // send mail
                self::sendMailConfig($createNotification);

            }
        } else {
            $createNotification = Notification::create([
                'judul_pesan' => $dataRequest['judul_pesan'],
                'isi_pesan' => $dataRequest['isi_pesan'],
                'link_pesan' => $dataRequest['link_pesan'],
                'is_read' => 'no',
                'role_tujuan' => $dataRequest['role_tujuan'],
                'role_pengirim' => $dataRequest['role_pengirim'],
                'note' => $dataRequest['note'],
                'model_id' => $dataRequest['model_id'],
                'model_type' => $dataRequest['model_type'],
                'type' => $dataRequest['type'],
                'employee_id_tujuan' => array_key_exists('employee_id_tujuan', $dataRequest) ? $dataRequest['employee_id_tujuan'] : null,
                'created_by' => $dataRequest['user'],
                'updated_by' => $dataRequest['user'],
            ]);

            // send mail
            self::sendMailConfig($createNotification);
        }        

        return true;
    }

    // request surat keluar
    public function roleGetNotificationRequestSuratKeluar() {
        $roles = ['superadmin'];
        $bu_ga = BusinessUnit::where('letter_code', 'GA')->first();

        // to get role has business unit
        $roleHasBu = RoleHasBusinessUnit::with('role')->where('business_unit_id', $bu_ga->id)->get();
        foreach ($roleHasBu as $key => $value) {
            $roles[] = $value->role->name;
        }

        return $roles;
    }

    // request tujuan email request surat keluar
    public function emailGetNotificationRequestSuratKeluar($roleName) 
    {
        // to get administrator email
        $appInfo = SetConfiguration::where('is_active', 'yes')->where('config_type', 'app_info')->where('name', 'administrator_email')->orderBy('id', 'ASC')->first();
        
        $role = Role::where('name', $roleName)->first();
        $roleHasBu = RoleHasBusinessUnit::with('business_unit')->where('roles_id', $role->id)->get();

        $listEmail = [];
        
        if ($roleHasBu->count() > 0) {
            foreach ($roleHasBu as $key => $value) {
                if (!is_null($value->business_unit)) {
                    if (!is_null($value->business_unit->email)) {
                        $listEmail[] = $value->business_unit->email;
                    }
                }
            }
        } else {
            $listEmail = [$appInfo->value];
        }

        return $listEmail;
    }

    // request tujuan email request surat keluar
    public function emailGetNotificationToUser($roleName) 
    {
        // to get administrator email
        $appInfo = SetConfiguration::where('is_active', 'yes')->where('config_type', 'app_info')->where('name', 'administrator_email')->orderBy('id', 'ASC')->first();
        
        $role = Role::where('name', $roleName)->first();
        $roleHasBu = RoleHasBusinessUnit::with('business_unit')->where('roles_id', $role->id)->get();
        
        if ($roleHasBu->count() > 0) {
            foreach ($roleHasBu as $key => $value) {
                if (!is_null($value->business_unit)) {
                    $listEmail[] = $value->business_unit->email;
                }
            }
        } else {
            $listEmail = [$appInfo->value];
        }

        return $listEmail;
    }

    // send Email
    public function sendMailConfig($dataNotification) 
    {
        switch ($dataNotification)
		{
			case $dataNotification->model_type == "Modules\GeneralAffair\Models\PersuratanSuratKeluarRequest" && $dataNotification->type == "send" :
				return self::sendEmailRequestNomorSurat($dataNotification);
				break;
            case $dataNotification->model_type == "Modules\GeneralAffair\Models\PersuratanSuratKeluarRequest" && $dataNotification->type == "response" :
				return self::sendEmailApproveNomorSurat($dataNotification);
				break;
            case $dataNotification->model_type == "Modules\User\Models\User" && $dataNotification->type == "response" :
                return self::sendEmailUserActivated($dataNotification);
                break;
            case $dataNotification->model_type == "Modules\GeneralAffair\Models\InvMaintenance" && $dataNotification->type == "response" :
                return self::sendEmailUserInventoryMaintenance($dataNotification);
                break;
			default :
			return false;
        }
    }

    public function sendEmailRequestNomorSurat($dataNotification) 
    {
        // get info request
        $requestNomorSuratKeluar = $dataNotification->model_type::with('business_unit', 'persuratan_jenis_surat_keluar', 'persuratan_nomor_surat_keluar')->where('id', $dataNotification->model_id)->first();

        // email tujuan
        $emailTujuan = self::emailGetNotificationRequestSuratKeluar($dataNotification->role_tujuan);

        if (count($emailTujuan) > 0) {
            foreach ($emailTujuan as $key => $value) {
                $send_variables = [
                    'judul_pesan' => $dataNotification->judul_pesan,
                    'isi_pesan' => $dataNotification->isi_pesan,
                    'link_pesan' => $dataNotification->link_pesan,
                    'tipe_notif' => $dataNotification->type,
                    'created_by' => $dataNotification->created_by,
                    'email_tujuan' => $value,
                    'business_unit' => $requestNomorSuratKeluar->business_unit->name,
                    'jenis_surat_keluar' => $requestNomorSuratKeluar->persuratan_jenis_surat_keluar->nama_jenis_surat,
                    'status_surat_keluar' => $requestNomorSuratKeluar->status,
                    'nama_surat_keluar' => $requestNomorSuratKeluar->nama_surat,
                    'note_surat_keluar' => $requestNomorSuratKeluar->note,
                    'is_confidential' => $requestNomorSuratKeluar->is_confidential,
                    'waktu_dibuat_surat_keluar' => $requestNomorSuratKeluar->created_at,
                ];
        
                dispatch(new SendEmailRequestSuratKeluar($send_variables));
    
                $send_variables = [];
            }
        }
    }

    public function sendEmailApproveNomorSurat($dataNotification) 
    {
        // get info request
        $requestNomorSuratKeluar = $dataNotification->model_type::with('business_unit', 'persuratan_jenis_surat_keluar', 'persuratan_nomor_surat_keluar')->where('id', $dataNotification->model_id)->first();

        // email tujuan
        $emailTujuan = self::emailGetNotificationRequestSuratKeluar($dataNotification->role_tujuan);

        if (count($emailTujuan) > 0) {
            foreach ($emailTujuan as $key => $value) {
                $send_variables = [
                    'judul_pesan' => $dataNotification->judul_pesan,
                    'isi_pesan' => $dataNotification->isi_pesan,
                    'link_pesan' => $dataNotification->link_pesan,
                    'tipe_notif' => $dataNotification->type,
                    'created_by' => $dataNotification->created_by,
                    'email_tujuan' => $value,
                    'business_unit' => $requestNomorSuratKeluar->business_unit->name,
                    'jenis_surat_keluar' => $requestNomorSuratKeluar->persuratan_jenis_surat_keluar->nama_jenis_surat,
                    'status_request_surat_keluar' => $requestNomorSuratKeluar->status,
                    'nama_surat_keluar' => $requestNomorSuratKeluar->nama_surat,
                    'note_surat_keluar' => $requestNomorSuratKeluar->note,
                    'is_confidential' => $requestNomorSuratKeluar->is_confidential,
                    'process_by' => $requestNomorSuratKeluar->process_by,
                    'waktu_approval' => $requestNomorSuratKeluar->updated_at,
                    'nomor_surat_keluar' => $requestNomorSuratKeluar->persuratan_nomor_surat_keluar->nomor_surat,
                ];
        
                dispatch(new SendEmailApproveSuratKeluar($send_variables));
    
                $send_variables = [];
            }
        }
    }

    public function sendEmailUserActivated($dataNotification) 
    {
        // get info request
        $employee = Employee::with('business_unit', 'group_site', 'position')->where('id', $dataNotification->employee_id_tujuan)->first();

        // email tujuan
        $emailTujuan = $employee->email;

        $send_variables = [
            'created_by' => $dataNotification->created_by,
            'email_tujuan' => $emailTujuan,
            'nik' => $employee->nik,
            'name' => $employee->name,
            'join_date' => is_null($employee->join_date) ? '-' : date("d - M - Y", strtotime($employee->join_date)),
            'business_unit' => $employee->business_unit->name,
            'position' => $employee->position->name,
            'group_site' => (is_null($employee->group_site)) ? "-" : $employee->group_site->nama_group,
        ];

        dispatch(new SendEmailUserActivated($send_variables));
    }

    public function sendEmailUserInventoryMaintenance($dataNotification) 
    {
        // get info request
        $employee = Employee::with('business_unit', 'group_site', 'position')->where('id', $dataNotification->employee_id_tujuan)->first();
        $dataMaintenance = $dataNotification->model_type::with('inv_maintenance_details')->where('id', $dataNotification->model_id)->first();
        $dataMaintenanceDetail = InvMaintenanceDetail::where('inv_maintenance_id', $dataMaintenance->id)->orderBy('id', 'DESC')->first();
        $dataInventory = $dataMaintenance->model_type::where('id', $dataMaintenance->model_id)->first();

        // email tujuan
        $emailTujuan = $employee->email;

        $send_variables = [
            'created_by' => $dataNotification->created_by,
            'email_tujuan' => $emailTujuan,
            'name' => $employee->name,
            'inventory_number' => $dataInventory->inventory_number,
            'serial_number' => $dataInventory->serial_number,
            'name_inventory' => $dataInventory->name,
            'operating_system' => $dataInventory->operating_system,
            'no_permohonan' => $dataMaintenance->no_permohonan,
            'tgl_permohonan' => is_null($dataMaintenance->tgl_permohonan) ? '-' : date("d - M - Y", strtotime($dataMaintenance->tgl_permohonan)),
            'tgl_selesai' => is_null($dataMaintenance->tgl_selesai) ? '-' : date("d - M - Y", strtotime($dataMaintenance->tgl_selesai)),
            'category' => $dataMaintenance->category,
            'note_pemohon' => $dataMaintenance->note_pemohon,
            'tgl_proses' => is_null($dataMaintenanceDetail->tgl_proses) ? '-' : date("d - M - Y", strtotime($dataMaintenanceDetail->tgl_proses)),
            'note' => $dataMaintenanceDetail->note,
            'status' => $dataMaintenanceDetail->status,
        ];

        dispatch(new SendEmailUserMaintenanceInventory($send_variables));
    }
}