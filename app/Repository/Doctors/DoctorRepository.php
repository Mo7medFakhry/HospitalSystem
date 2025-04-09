<?php
namespace App\Repository\Doctors;
use App\Traits\UPloadTrait;
use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Doctor;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorRepository implements DoctorRepositoryInterface
{
    use UPloadTrait;

    public function index()
    {
        $doctors = Doctor::all();
        return view('Dashboard.Doctors.index', compact('doctors'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('Dashboard.Doctors.add', compact('sections'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {

            $doctors = new Doctor();
            $doctors->email = $request->email;
            $doctors->password = Hash::make($request->password);
            $doctors->section_id = $request->section_id;
            $doctors->phone = $request->phone;
            $doctors->price = $request->price;
            $doctors->status = 1;
            $doctors->save();
            // store trans
            $doctors->name = $request->name;
            $doctors->appointments = implode(",", $request->appointments);
            $doctors->save();


            //Upload img
            $this->StoreImageAndVerify($request, 'photo', 'doctors', 'upload_image', 'App\Models\Doctor', $doctors->id);

            DB::commit();
            session()->flash('add');
            return redirect()->route('Doctors.create');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }

    public function update($request)
    {
    }

    public function destroy($request)
    {
    }
}
