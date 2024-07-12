<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;

class ReservationsModel extends Model
{
    protected $DBGroup = 'adh_wh'; // Grupo de base de datos
    protected $table = 'RemoteAtelierFrontCRS_Reservations';
    protected $primaryKey = 'ReservationNumber';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [ "ReservationNumber", "AgencyNumber", "RoomTypeId", "Rooms", "DateFrom", "DateTo", "Name", "LastName", "CustomerId", "Company", "AgencyId", "GroupId", "Email", "MealPlanId", "AgentId", "CustomField1", "CustomField2", "CustomField3", "VipId", "ReservationTypeId", "ChannelId", "WarrantyId", "FormsPaymentCatalogId", "LimitCredit", "Deadline", "SegmentId", "LanguageId", "Contact", "ProgramId", "NumProgram", "Master", "Age1", "Age2", "Age3", "Age4", "Age5", "Age6", "Age7", "Age8", "Adults", "Nights", "NetRate", "Notes", "LoyaltyPaymentDate", "LoyaltyComentary", "LoyaltyStatus", "LoyaltyAgent", "LoyaltyDate", "LoyaltyPaidDate", "ContractId", "PromotionId", "PromotionCode", "ReservationDate", "LoyaltyPercent", "Manual", "CurrencyIdFrom", "CurrencyIdTo", "ExchangeRate", "BookingCode1", "BookingCode2", "BookingCode3", "FlagCustomerFiel", "ReasonsCancellationId", "CancellationNumber", "Deleted", "IsLoyaltyDwh", "HotelId", "RoomId", "SpecialRequest", "Infants", "Children", "Teens", "SafeControlId", "DateCancel", "UserCancel", "PaymentMethodId", "CallId", "Source", "AdhUser"];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function find($id = null, bool $returnArray = false)
    {
        $this->select('RemoteAtelierFrontCRS_Reservations.*, RemoteAtelierFrontCRS_RoomTypes.Name as room_type_name, RemoteAtelierFrontCRS_RoomTypes.Code as room_type_code, RemoteAtelierFrontCRS_Agencies.Name as agency_name, RemoteAtelierFrontCRS_Agencies.AgencyCode as agency_code, RemoteAtelierFrontCRS_Hotels.Name as hotel_name');
        $this->join('RemoteAtelierFrontCRS_RoomTypes', 'RemoteAtelierFrontCRS_RoomTypes.RoomTypeId = RemoteAtelierFrontCRS_Reservations.RoomTypeId', 'left');
        $this->join('RemoteAtelierFrontCRS_Agencies', 'RemoteAtelierFrontCRS_Agencies.AgencyId = RemoteAtelierFrontCRS_Reservations.AgencyId', 'left');
        $this->join('RemoteAtelierFrontCRS_Hotels', 'RemoteAtelierFrontCRS_Hotels.HotelId = RemoteAtelierFrontCRS_Reservations.HotelId', 'left');
        return parent::find($id, $returnArray);
    }
}
