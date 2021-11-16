<?php

namespace App\Helpers\GeneralAffair;

use DB;
use Error;
use Modules\User\Models\GroupSite;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ClientException;
use Modules\GeneralAffair\Models\InvDevice;
use Modules\GeneralAffair\Models\InvLaptop;
use Modules\GeneralAffair\Models\InvStatus;
use Modules\GeneralAffair\Models\InvHistory;
use Modules\GeneralAffair\Models\InvMonitor;
use Modules\GeneralAffair\Models\InvPrinter;
use Modules\GeneralAffair\Models\InvKomputer;
use Illuminate\Validation\ValidationException;
use Modules\GeneralAffair\Models\InvMaintenance;
use Modules\GeneralAffair\Models\ConfigInvRamsize;
use Modules\GeneralAffair\Models\ConfigInvCategory;
use Modules\GeneralAffair\Models\ConfigInvCondition;
use Modules\GeneralAffair\Models\ConfigInvProcessor;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Modules\GeneralAffair\Models\ConfigInvScreensize;
use Modules\GeneralAffair\Models\ConfigInvStoragesize;
use Modules\GeneralAffair\Models\ConfigInvStoragetype;
use Modules\GeneralAffair\Models\InvMaintenanceDetail;
use Modules\GeneralAffair\Models\ConfigInvJenismonitor;
use Modules\GeneralAffair\Models\ConfigInvJenisprinter;
use Modules\GeneralAffair\Models\ConfigInvHistorystatus;
use Modules\GeneralAffair\Models\ConfigInvOperatingsystem;
use Modules\GeneralAffair\Models\ConfigInvMaintenancejenis;
use Modules\GeneralAffair\Models\ConfigInvMaintenancestatus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InventoryHelper
{

    public function InventoryScreenSize()
    {
        $data = ConfigInvScreensize::orderBy('id', 'ASC')->get();
        $dataScreen = $data->pluck('value', 'value')->toArray();

        return $dataScreen;
    }

    public function InventoryStorageType()
    {
        $data = ConfigInvStoragetype::orderBy('id', 'ASC')->get();
        $dataStorage = $data->pluck('value', 'value')->toArray();

        return $dataStorage;
    }

    public function InventoryStorageSize()
    {
        $data = ConfigInvStoragesize::orderBy('id', 'ASC')->get();
        $dataStorageSize = $data->pluck('value', 'value')->toArray();

        return $dataStorageSize;
    }

    public function InventoryRamSize()
    {
        $data = ConfigInvRamsize::orderBy('id', 'ASC')->get();
        $dataRamSize = $data->pluck('value', 'value')->toArray();

        return $dataRamSize;
    }

    public function InventoryProcessor()
    {
        $data = ConfigInvProcessor::orderBy('id', 'ASC')->get();
        $dataProcessor = $data->pluck('value', 'value')->toArray();

        return $dataProcessor;
    }

    public function InventoryOperatingSystem()
    {
        $data = ConfigInvOperatingsystem::orderBy('id', 'ASC')->get();
        $dataOs = $data->pluck('value', 'value')->toArray();

        return $dataOs;
    }

    public function InventoryConditionList()
    {
        $data = ConfigInvCondition::orderBy('id', 'ASC')->get();
        $dataCondition = $data->pluck('value', 'value')->toArray();

        return $dataCondition;
    }

    public function InventoryConditionListBadges()
    {
        $data = ConfigInvCondition::orderBy('id', 'ASC')->get();
        $dataCondition = $data->pluck('badges', 'value')->toArray();

        return $dataCondition;
    }

    public function numberInventoryLaptop()
    {
        //get last number of laptop
        $inventoryLaptopCount = InvLaptop::get()->count();
        $defaultFormat = "LTP-ITE-00001";

        // format nomor inventory laptop
        // LTP-ITE-01047 cek last number yang formatnya LTP, jika datanya sudah ada

        if ($inventoryLaptopCount > 0) {
            $dataInvLaptop = InvLaptop::where('inventory_number', 'like', '%LTP-ITE-%')->orderBy('id', 'DESC')->first();

            $explode = explode('-', $dataInvLaptop->inventory_number);
            $squence =  sprintf("%05d", (int) $explode[2] + 1);
            $formatNew = "LTP-ITE-" . $squence;
        } else {
            $formatNew = $defaultFormat;
        }

        return $formatNew;
    }

    public function numberInventoryKomputer()
    {
        //get last number of inventory
        $inventoryLaptopCount = InvKomputer::get()->count();
        $defaultFormat = "CPU-ITE-00001";

        // format nomor inventory laptop
        // LTP-ITE-01047 cek last number yang formatnya LTP, jika datanya sudah ada

        if ($inventoryLaptopCount > 0) {
            $dataInvLaptop = InvKomputer::where('inventory_number', 'like', '%CPU-ITE-%')->orderBy('id', 'DESC')->first();

            $explode = explode('-', $dataInvLaptop->inventory_number);
            $squence =  sprintf("%05d", (int) $explode[2] + 1);
            $formatNew = "CPU-ITE-" . $squence;
        } else {
            $formatNew = $defaultFormat;
        }

        return $formatNew;
    }

    public function numberInventoryMonitor()
    {
        //get last number of inventory
        $inventoryLaptopCount = InvMonitor::get()->count();
        $defaultFormat = "MON-ITE-00001";

        // format nomor inventory laptop
        // MON-ITE-01047 cek last number yang formatnya MON, jika datanya sudah ada

        if ($inventoryLaptopCount > 0) {
            $dataInvLaptop = InvMonitor::where('inventory_number', 'like', '%MON-ITE-%')->orderBy('id', 'DESC')->first();

            $explode = explode('-', $dataInvLaptop->inventory_number);
            $squence =  sprintf("%05d", (int) $explode[2] + 1);
            $formatNew = "MON-ITE-" . $squence;
        } else {
            $formatNew = $defaultFormat;
        }

        return $formatNew;
    }

    public function numberInventoryPrinter()
    {
        //get last number of inventory
        $inventoryLaptopCount = InvPrinter::get()->count();
        $defaultFormat = "PRI-ITE-00001";

        // format nomor inventory laptop
        // PRI-ITE-01047 cek last number yang formatnya PRI, jika datanya sudah ada

        if ($inventoryLaptopCount > 0) {
            $dataInvLaptop = InvPrinter::where('inventory_number', 'like', '%PRI-ITE-%')->orderBy('id', 'DESC')->first();

            $explode = explode('-', $dataInvLaptop->inventory_number);
            $squence =  sprintf("%05d", (int) $explode[2] + 1);
            $formatNew = "PRI-ITE-" . $squence;
        } else {
            $formatNew = $defaultFormat;
        }

        return $formatNew;
    }

    public function numberInventoryDeviceSupport()
    {
        //get last number of inventory
        $inventoryDeviceCount = InvDevice::get()->count();
        $defaultFormat = "DVS-ITE-00001";

        // format nomor inventory
        // DVS-ITE-01047 cek last number yang formatnya DVS, jika datanya sudah ada

        if ($inventoryDeviceCount > 0) {
            $dataInvLaptop = InvDevice::where('inventory_number', 'like', '%DVS-ITE-%')->orderBy('id', 'DESC')->first();

            $explode = explode('-', $dataInvLaptop->inventory_number);
            $squence =  sprintf("%05d", (int) $explode[2] + 1);
            $formatNew = "DVS-ITE-" . $squence;
        } else {
            $formatNew = $defaultFormat;
        }

        return $formatNew;
    }

    public function inventoryHistoryStatus()
    {
        $data = ConfigInvHistorystatus::orderBy('id', 'ASC')->get();
        $dataInventoryStatus = $data->pluck('value', 'value')->toArray();

        return $dataInventoryStatus;
    }

    public function inventoryStatusMaintenance()
    {
        $data = ConfigInvMaintenancestatus::orderBy('id', 'ASC')->get();
        $dataInventoryMaintenanceStatus = $data->pluck('value', 'value')->toArray();

        return $dataInventoryMaintenanceStatus;
    }

    public function inventoryStatusMaintenanceColor()
    {
        $data = ConfigInvMaintenancestatus::orderBy('id', 'ASC')->get();
        $dataInventoryMaintenanceStatus = $data->pluck('badges', 'value')->toArray();

        return $dataInventoryMaintenanceStatus;
    }

    public function inventoryJenisMaintenance()
    {
        $data = ConfigInvMaintenancejenis::orderBy('id', 'ASC')->get();
        $dataInventoryMaintenanceJenis = $data->pluck('value', 'value')->toArray();

        return $dataInventoryMaintenanceJenis;
    }

    public function nomorPermohonanMaintenance($groupId)
    {
        if (is_null($groupId)) {
            $dataGroup = GroupSite::where('nama_group', 'Noble House')->first();
            $groupIdSet = $dataGroup->id;
        } else {
            $groupIdSet = $groupId;
        }

        //get last number of inventory
        $invMaintenanceCount = InvMaintenance::get()->count();
        $defaultFormat = "B" . $groupIdSet . "." . date("md") . ".001";

        if ($invMaintenanceCount > 0) {
            $dataInv = InvMaintenance::orderby('id', 'DESC')->first();

            $explode = explode('.', $dataInv->no_permohonan);
            $squence =  sprintf("%03d", (int) $explode[2] + 1);
            $formatNew = "B" . $groupIdSet . "." . date("md") . "." . $squence;
        } else {
            $formatNew = $defaultFormat;
        }

        return $formatNew;
    }

    public function inventoryCategoryMaintenance()
    {
        $data = ConfigInvCategory::orderBy('id', 'ASC')->get();
        $dataInventoryMaintenanceCategory = $data->pluck('value', 'value')->toArray();

        return $dataInventoryMaintenanceCategory;
    }

    
    public function inventoryCategoryModel()
    {
        $data = ConfigInvCategory::orderBy('id', 'ASC')->get();
        $dataInventoryMaintenanceCategoryModel = $data->pluck('model_class', 'value')->toArray();
        
        return $dataInventoryMaintenanceCategoryModel;
    }

    public function InventoryJenisMonitorList()
    {
        $data = ConfigInvJenismonitor::orderBy('id', 'ASC')->get();
        $dataInventoryJenisMonitorList = $data->pluck('value', 'value')->toArray();

        return $dataInventoryJenisMonitorList;
    }

    public function InventoryJenisPrinterList()
    {
        $data = ConfigInvJenisprinter::orderBy('id', 'ASC')->get();
        $dataInventoryJenisPrinterList = $data->pluck('value', 'value')->toArray();

        return $dataInventoryJenisPrinterList;
    }

    public function inventoryImportClass()
    {
        $data = ConfigInvCategory::orderBy('id', 'ASC')->get();
        $dataInventoryImportClass = $data->pluck('import_class', 'value')->toArray();
        
        return $dataInventoryImportClass;
    }

    public function inventoryImportColor()
    {
        $dataInventoryImportColor = [
            "uploaded" => "primary",
            "process" => "primary",
            "done" => "success",
            "failed" => "danger",
        ];

        return $dataInventoryImportColor;
    }

    public function inventoryDeleteRelationData($classModelInventory, $IdInventory)
    {
        DB::beginTransaction();

        try {

            // proses delete history inventory
            InvHistory::where('model_type', $classModelInventory)->where('model_id', $IdInventory)->delete();

            // proses delete maintenance detail
            $getMaintenance = InvMaintenance::where('model_type', $classModelInventory)->where('model_id', $IdInventory)->get();
            if (count($getMaintenance) > 0) {
                foreach ($getMaintenance as $key => $value) {
                    // delete maintenance detail
                    InvMaintenanceDetail::where('inv_maintenance_id', $value->id)->delete();
                }

                // delete maintenance header
                InvMaintenance::where('model_type', $classModelInventory)->where('model_id', $IdInventory)->delete();
            }

            DB::commit();

            return true;

	    } catch (\Exception $e) {
	        DB::rollback();
	        return app('string.helper')->setErrorResponseApi($e);
	    }
    }

    public function getIdInventoryStatusDigunakan()
    {
        $statusInventoryDigunakan = InvStatus::where('name_status', 'Digunakan')->first();

        return $statusInventoryDigunakan->id;
    }
}