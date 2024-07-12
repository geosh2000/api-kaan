<?php

namespace App\Controllers\Rsv;

use App\Models\Quote\DiscountCodeModel;
use CodeIgniter\Controller;

class DiscountCodes extends Controller
{
    public function index()
    {
        $model = new DiscountCodeModel();
        $data['discountCodes'] = $model->findAll();

        return view('Quote/discountCodes', $data);
    }

    public function create()
    {
        // Aquí puedes manejar la lógica para agregar un nuevo registro
    }

    public function delete($id)
    {
        // Aquí puedes manejar la lógica para eliminar un registro
    }
}
