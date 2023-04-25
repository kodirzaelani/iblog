<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Employe;

use App\Models\Employe;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;

class Employeprofile extends Component
{
    use WithFileUploads;
    public $userId;
    public $name;
    public $displayname;
    public $email;
    public $username;
    public $celuller_no;
    public $bio;
    public $password;
    public $image;
    public $oldimage;

    public $current_hashed_password;
    public $current_password_for_email;
    public $current_password_for_phone;
    public $current_password_for_password;
    public $password_confirmation;

    public $prevName;
    public $prevDisplayname;
    public $prevEmail;
    public $prevBio;
    public $prevImage;
    public $prevEmployename;
    public $prevCeluller;

    public $uploadPath = 'uploads/images/users';

    public function mount()
    {
        $this->userId      = auth()->user()->id;
        $model             = Employe::find($this->userId);
        $this->name        = $model->name;
        $this->displayname = $model->displayname;
        $this->username    = $model->username;
        $this->bio         = $model->bio;
        $this->oldimage    = $model->image;

        $this->prevName                = $model->name;
        $this->prevDisplayname         = $model->displayname;
        $this->prevEmail               = $model->email;
        $this->prevEmployename            = $model->username;
        $this->prevCeluller            = $model->celuller_no;
        $this->prevBio                 = $model->bio;
        $this->prevImage               = $model->image;
        $this->current_hashed_password = $model->password;
    }

    public function update()
    {
        // This is always the case
        $validateData = [
            'displayname' => 'min:2',
        ];


        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $data = [];

        if ($this->displayname !== $this->prevDisplayname) {
            $data = array_merge($data, ['displayname' => $this->displayname]);
        }

        if (count($data)) {
            Employe::find($this->userId)->update($data);
            session()->flash('success', 'Data Display name updated successfully');
            return redirect()->to('backend/admin/profile');
        }
    }
    public function updatebio()
    {
        // This is always the case
        $validateData = [
            'bio' => 'min:5',
        ];


        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $data = [];


        if ($this->bio !== $this->prevBio) {
            $data = array_merge($data, ['bio' => $this->bio]);
        }

        if (count($data)) {
            Employe::find($this->userId)->update($data);
            session()->flash('success', 'Data Bio updated successfully');
            return redirect()->to('backend/admin/profile');
        }
    }

    public function changeemail()
    {
        // This is always the case
        $validateData = [];

        if ($this->email !== $this->prevEmail) {
            if (empty($this->email)) {
                $validateData = array_merge($validateData, [
                    'email' => 'required|email'
                ]);
            }

            $validateData = array_merge($validateData, [
                'current_password_for_email' => ['required', 'customPassCheckHashed:' . $this->current_hashed_password]
            ]);
        }

        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $data = [];

        if ($this->email !== $this->prevEmail) {
            $data = array_merge($data, ['email' => $this->email]);
        }

        if (count($data)) {
            Employe::find($this->userId)->update($data);
            session()->flash('success', 'Data updated successfully');

            return redirect()->to('backend/admin/profile');
        }
    }

    public function changeimage()
    {
        // This is always the case
        $validateData = [];
        $oldImage = $this->prevImage;

        // Validate image
        if (!empty($this->image)) {
            // Append to the validation if image is not empty
            $validateData = array_merge($validateData, [
                'image' => 'image|max:1024'
            ]);
        }

        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $data = [];

        if (!empty($this->image)) {
            $imageHashName = $this->image->hashName();

            // This is to save the filename of the image in the database
            $data = array_merge($data, [
                'image' => $imageHashName
            ]);

            // Upload the main image
            $this->image->store('images/users/');

            // Create a thumbnail of the image using Intervention Image Library
            $manager = new ImageManager();
            $imagedata = $manager->make('uploads/images/users/' . $imageHashName)->resize(120, 100); // Jangan lupa sesauikan nama folder dengan public folder image
            $imagedata->save(public_path('uploads/images/users/images_thumb/' . $imageHashName)); // Jangan lupa buat folder sesuai dengan rencana penyimpanan

        }

        if (count($data)) {

            Employe::find($this->userId)->update($data);


            // Jika gambar lama ada maka lakukan hapus gambar
            if ($oldImage !== $data) {
                $this->removeImage($oldImage);
            }

            session()->flash('success', 'Image updated successfully');

            return redirect()->to('backend/admin/profile');
        }
    }

    private function removeImage($oldImage)
    {
        if (!empty($oldImage)) {
            $imagePath     = $this->uploadPath . '/' . $oldImage;
            $thumbnailPath = $this->uploadPath . '/images_thumb/' . $oldImage;

            if (file_exists($imagePath)) unlink($imagePath);
            if (file_exists($thumbnailPath)) unlink($thumbnailPath);
        }
    }

    public function changepassword()
    {
        // This is always the case
        $validateData = [];

        if (!empty($this->password)) {
            $validateData = array_merge($validateData, [
                // customPassCheckHashed dibuat di file App\Provider\AppServiceProvider.php
                'current_password_for_password' => ['required', 'customPassCheckHashed:' . $this->current_hashed_password],
                'password' => 'confirmed|min:6',
                'password_confirmation' => 'required'
            ]);
        }
        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $data = [];
        if (!empty($this->password)) {
            $data = array_merge($data, ['password' => Hash::make($this->password)]);
        }

        if (count($data)) {
            Employe::find($this->userId)->update($data);
            session()->flash('success', 'Password updated successfully');
            return redirect()->to('backend/admin/profile');
        }
    }
    public function changephone()
    {
        // This is always the case
        $validateData = [];

        if ($this->celuller_no !== $this->prevCeluller) {
            if (empty($this->celuller_no)) {
                $validateData = array_merge($validateData, [
                    'celuller_no' => 'required'
                ]);
            }

            $validateData = array_merge($validateData, [
                'current_password_for_phone' => ['required', 'customPassCheckHashed:' . $this->current_hashed_password]
            ]);
        }

        // Just add validation if there are any changes in the fields
        $this->validate($validateData);

        $data = [];

        if ($this->celuller_no !== $this->prevCeluller) {
            $data = array_merge($data, ['celuller_no' => $this->celuller_no]);
        }

        if (count($data)) {
            Employe::find($this->userId)->update($data);
            session()->flash('success', 'Data updated successfully');
            return redirect()->to('backend/admin/profile');
        }
    }
    public function render()
    {
        return view('livewire.template.backend.nusantara.employe.employeprofile');
    }
}
