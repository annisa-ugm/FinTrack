<?php

namespace App\Repositories;
use App\Models\Pembayaran;
use App\Interfaces\PembayaranRepositoryInterface;
class PembayaranRepository implements PembayaranRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return Pembayaran::all();
    }

    public function getById($id){
       return Pembayaran::findOrFail($id);
    }

    public function store(array $data){
       return Pembayaran::create($data);
    }

    public function update(array $data,$id){
       return Pembayaran::whereId($id)->update($data);
    }

    public function delete($id){
       Pembayaran::destroy($id);
    }
}
